<?php

/**
 * Extension for Contao Open Source CMS
 *
 * Copyright (c) 2012-2014 Daniel Kiesel
 *
 * @package Photoalbums2
 * @link    https://github.com/icodr8/contao-photoalbums
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Namespace
 */
namespace Photoalbums2;


/**
 * Class Pa2
 *
 * @copyright  Daniel Kiesel 2012-2014
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class Pa2 extends \Controller
{

	/**
	 * addCssFile function.
	 *
	 * @access public
	 * @return void
	 */
	public function addCssFile()
	{
		global $objPage;

		// Get layout skipPhotoalbums2 to disable photoalbums2 css file
		$objLayout = \LayoutModel::findByPk($objPage->layout);

		// Add css
		if ((TL_MODE=='FE' && $objLayout->skipPhotoalbums2 != '1') || TL_MODE=='BE')
		{
			$GLOBALS['TL_CSS'][] = TL_FILES_URL . 'system/modules/photoalbums2/assets/photoalbums2.css';
		}
	}


	/**
	 * Update a particular RSS feed
	 * @param integer
	 */
	public function generateFeed($intId)
	{
		$objArchive = \Photoalbums2ArchiveModel::findOneBy(array('id=?', 'makeFeed=?'), array($intId, 1));

		if ($objArchive == null)
		{
			return;
		}

		$objArchive->feedName = ($objArchive->alias != '') ? $objArchive->alias : 'pa2' . $objArchive->id;

		// Delete XML file
		if ($this->Input->get('act') == 'delete' || $objArchive->protected)
		{
			$this->import('Files');
			$this->Files->delete($objArchive->feedName . '.xml');
		}

		// Update XML file
		else
		{
			$this->generateFiles($objArchive->row());
			$this->log('Generated pa2 feed "' . $objArchive->feedName . '.xml"', 'Pa2 generateFeed()', TL_CRON);
		}
	}


	/**
	 * Delete old files and generate all feeds
	 */
	public function generateFeeds()
	{
		$this->removeOldFeeds();
		$objArchive = \Photoalbums2ArchiveModel::findBy(array('makeFeed=1', 'protected!=1'), array());

		if ($objArchive !== null)
		{
			while ($objArchive->next())
			{
				$objArchive->feedName = ($objArchive->alias != '') ? $objArchive->alias : 'pa2' . $objArchive->id;

				$this->generateFiles($objArchive->row());
				$this->log('Generated pa2 feed "' . $objArchive->feedName . '.xml"', 'Pa2 generateFeeds()', TL_CRON);
			}
		}
	}


	/**
	 * Generate an XML files and save them to the root directory
	 * @param array
	 */
	protected function generateFiles($arrArchive)
	{
		$this->import('Database');

		$time = time();
		$strType = ($arrArchive['format'] == 'atom') ? 'generateAtom' : 'generateRss';
		$strLink = ($arrArchive['feedBase'] != '') ? $arrArchive['feedBase'] : $this->Environment->base;
		$strFile = $arrArchive['feedName'];

		$objFeed = new \Feed($strFile);

		$objFeed->link = $strLink;
		$objFeed->title = $arrArchive['title'];
		$objFeed->description = $arrArchive['description'];
		$objFeed->language = $arrArchive['language'];
		$objFeed->published = $arrArchive['tstamp'];

		// Get items
		$objArticleStmt = $this->Database->prepare("SELECT *, (SELECT name FROM tl_user u WHERE u.id=p.author) AS authorName FROM tl_photoalbums2_album p WHERE pid=? AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1 ORDER BY sorting ASC");

		if ($arrArchive['maxItems'] > 0)
		{
			$objArticleStmt->limit($arrArchive['maxItems']);
		}

		$objArticle = $objArticleStmt->execute($arrArchive['id']);

		// Get the default URL
		$objParent = \PageModel::findByPk($arrArchive['modulePage']);

		if ($objParent == null)
		{
			return;
		}

		$objParent = $this->getPageDetails($objParent->id);
		$strUrl = $this->generateFrontendUrl($objParent->row(), ($GLOBALS['TL_CONFIG']['useAutoItem'] ?  '/%s' : '/album/%s'), $objParent->language);

		// Parse items
		if ($objArticle !== null)
		{
			while ($objArticle->next())
			{
				// Deserialize image arrays
				$objArticle->images = deserialize($objArticle->images);
				$objArticle->imageSort = deserialize($objArticle->imageSort);

				// Sort images
				$objPa2ImageSorter = new \Pa2ImageSorter($objArticle->imageSortType, $objArticle->images, $objArticle->imageSort);
				$this->arrImages = $objPa2ImageSorter->getSortedUuids();

				$objItem = new \FeedItem();

				$objItem->title = $objArticle->title;
				$objItem->link = sprintf($strLink . $strUrl, (($objArticle->alias != '' && !$GLOBALS['TL_CONFIG']['disableAlias']) ? $objArticle->alias : $objArticle->id));
				$objItem->published = $objArticle->startdate;
				$objItem->author = $objArticle->authorName;

				if (is_array($objArticle->arrImages) && count($objArticle->arrImages) > 0)
				{
					foreach ($objArticle->arrImages as $image)
					{
						if (is_file(TL_ROOT . '/' . $image))
						{
							$objItem->addEnclosure($image);
						}
					}
				}

				$objItem->description = $this->replaceInsertTags($objArticle->description);
				$objFeed->addItem($objItem);
			}
		}

		// Create file
		$objRss = new \file($strFile . '.xml');
		$objRss->write($this->replaceInsertTags($objFeed->$strType()));
		$objRss->close();
	}
}
