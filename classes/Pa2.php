<?php 

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package   photoalbums2 
 * @author    Daniel Kiesel <https://github.com/icodr8> 
 * @license   LGPL 
 * @copyright Daniel Kiesel 2012 
 */


/**
 * Namespace
 */
namespace Photoalbums2;

/**
 * Class Pa2 
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 * 
 * DEPRECATED
 */
class Pa2 extends \Frontend
{
	public $type = 'pa2';
	protected $arrVars = array();
	
	
	/**
	 * fetchAlbums function.
	 * 
	 * @access protected
	 * @param object $objAlbums
	 * @return array
	 */
	protected function fetchAlbums($objAlbums)
	{
		if (!is_object($objAlbums))
		{
			return false;
		}
		
		$arrAlbums = array();
		
		while($objAlbums->next())
		{
			$arrAlbums[] = $objAlbums->id;
		}
		
		// Sort out protected
		$arrSortedAlbums = $this->sortOutElements($arrAlbums, 'album');
		
		// Check for array and content
		if (!is_array($arrSortedAlbums) || count($arrSortedAlbums) < 1)
		{
			return false;
		}
		
		// Reset object
		$objAlbums->reset();
		
		// Set array
		$arrAlbums = array();
		
		// Filter data
		while($objAlbums->next())
		{
			$album = $objAlbums->row();
			
			if (in_array($objAlbums->id, $arrSortedAlbums))
			{
				$album['pictures'] = deserialize($album['pictures']);
				$album['pic_sort'] = deserialize($album['pic_sort']);
				
				$objPicSorter = new \PicSorter($album['pictures'], $GLOBALS['TL_DCA']['tl_photoalbums2_album']['fields']['pictures']['eval']['extensions']);
				$album['pictures'] = $objPicSorter->getPicIds();
				
				$objPreviewPic = new \Pa2PreviewPic($objAlbums, $this->arrVars['pa2PreviewPic']);
				$album['preview_pic'] = $objPreviewPic->getPreviewPicObject();
				
				$arrAlbums[] = $album;
			}
		}
		
		return $arrAlbums;
	}
	
	
	/**
	 * sortOutElements function.
	 * 
	 * @access public
	 * @param array $arrElements
	 * @param string $type (default: 'archive')
	 * @return array
	 */
	public function sortOutElements($arrElements, $type = 'archive')
	{
		if (/*BE_USER_LOGGED_IN || */!is_array($arrElements) || count($arrElements) < 1)
		{
			return $arrElements;
		}
		
		if ($type!='archive' && $type!='album')
		{
			return false;
		}

		$this->import('FrontendUser', 'User');
		
		// Check if album
		$albumSQL = "";
		if ($type == 'archive')
		{
			$objElement = \Photoalbums2ArchiveModel::findMultipleByIds($arrElements);
		}
		else if ($type == 'album')
		{
			$objElement = \Photoalbums2AlbumModel::findMultipleByIds($arrElements);
		}
		
		$arrElements = array();

		while ($objElement->next())
		{
			// If album is published
			if ($objElement->published==1 || $type=='archive')
			{
				if ($objElement->protected)
				{
					if (!FE_USER_LOGGED_IN)
					{
						continue;
					}
					
					$users = deserialize($objElement->users);
					$groups = deserialize($objElement->groups);
					
					// Check users and groups
					if ((!is_array($users) || count($users) < 1 || count(array_intersect($users, array($this->User->id))) < 1) && (!is_array($groups) || count($groups) < 1 || count(array_intersect($groups, $this->User->groups)) < 1))
					{
						continue;
					}
				}
				
				// Timefilter
				if ($type=='album' && ($this->pa2TimeFilter))
				{
					$today = mktime(0, 0, 0, date('n', time()), date('j', time()), date('Y', time()));
					
					$filterStart = $this->Pa2->getTimeFilterData($this->pa2TimeFilterStart);
					$filterEnd = $this->Pa2->getTimeFilterData($this->pa2TimeFilterEnd, true);
					$dateStart = $objElement->startdate;
					$dateEnd = $objElement->enddate;
					
					if (!(($filterStart <= $dateStart && $dateStart < $filterEnd) || ($filterStart <= $dateEnd && $dateEnd < $filterEnd)))
					{
						continue;
					}
				}
				
				$arrElements[] = $objElement->id;
			}
		}

		return $arrElements;
	}
	
	
	/**
	 * getTimeFilterData function.
	 * 
	 * @access protected
	 * @param array $arrData
	 * @return int
	 */
	public function getTimeFilterData($arrData, $typeEnd = false)
	{
		// If use vars are not setted
		if (!isset($arrData['unit']) || !isset($arrData['value']))
		{
			return false;
		}
		
		$intValue = false;
		
		// Get date vars
		$day = date('j', time());
		$month = date('n', time());
		$year = date('Y', time());
		
		switch ($arrData['unit'])
		{
			case 'days':
				$intValue = mktime(0, 0, 0, $month, $day+($typeEnd ? 1 : 0)-$arrData['value'], $year);
			break;
			
			case 'weeks':
				$intValue = mktime(0, 0, 0, $month, $day+($typeEnd ? 7 : 0)-($arrData['value']*7)-(date('N', time())-1), $year);
			break;
			
			case 'months':
				$intValue = mktime(0, 0, 0, $month+($typeEnd ? 1 : 0)-$arrData['value'], 1, $year);
			break;
			
			case 'years':
				$intValue = mktime(0, 0, 0, 1, 1, $year+($typeEnd ? 1 : 0)-$arrData['value']);
			break;
		}
		
		return $intValue;
	}
	
	
	/**
	 * pa2PerRow function.
	 * 
	 * @access protected
	 * @param object $objTemplate
	 * @param int $total
	 * @param int $i
	 * @param string $type
	 * @return object
	 */
	protected function pa2PerRow($objTemplate, $total, $i, $perRow)
	{
		// Check
		if(!is_object($objTemplate))
		{
			return false;
		}
		
		// Get modulo
		$m = $i%$perRow;
		
		// Set width from objects
		$objTemplate->style = (($objTemplate->style=='') ? '' : ($objTemplate->style) . ' ') . 'width: ' . (100/$perRow) . '%;';
		
		// Set row start
		$objTemplate->rowStart = false;
		if($m == 0)
		{
		    $objTemplate->class .= ' first';
		    $objTemplate->rowStart = true;
		}
		
		// Set row end
		$objTemplate->rowEnd = false;
		if($m == ($perRow-1) || $total == ($i+1))
		{
		    $objTemplate->class .= ' last';
		    $objTemplate->rowEnd = true;
		}
		
		// Set even and odd in photos
		$objTemplate->class .= ' ' . ((($i%2) == 0) ? 'even' : 'odd');
		
		// Set even and odd in rows
		if($m == 0)
		{
			if(!isset($GLOBALS['pa2RowEvenOdd']))
			{
				$GLOBALS['pa2RowEvenOdd'] = 0;
			}
			
			$objTemplate->rowClass = ((($GLOBALS['pa2RowEvenOdd']%2) == 0) ? 'even' : 'odd');
			
			$GLOBALS['pa2RowEvenOdd']++;
		}
		
		return $objTemplate;
	}
	
	
	/**
	 * pa2AddSpecificClasses function.
	 * 
	 * @access protected
	 * @param object $objTemplate
	 * @param int $totalItems
	 * @param int $i
	 * @param int $intItemsPerPage
	 * @return object
	 */
	protected function pa2AddSpecificClasses($objTemplate, $totalItems, $i, $intItemsPerPage, $type)
	{
		// Fix empty vars
		if(!is_object($objTemplate) || !is_numeric($totalItems) || !is_numeric($i) || !is_numeric($intItemsPerPage))
		{
			return $objTemplate;
		}
		
		// Fix division by zero problem
		if($intItemsPerPage < 1)
		{
			$intItemsPerPage = $totalItems;
		}
		
		// Set var maxPage
		$maxPage = (int) ceil($totalItems/$intItemsPerPage);
		
		// Set var page
		$page = $this->Input->get('page');
		$page = (is_numeric($page)) ? $page : 1;
		$page = ($maxPage > $page) ? $page : $maxPage;
		
		// Set picNum var
		if($type == 'albums')
		{
			$picNum = $i+1+(($page-1)*$intItemsPerPage);
		}
		else if($type == 'photos')
		{
			$picNum = $i+1;
		}
		else
		{
			return $objTemplate;
		}
		
		// Set firstPageNum
		$firstPageNum = (($page-1)*$intItemsPerPage) + 1;
		$firstPageNum = ($totalItems > $firstPageNum) ? $firstPageNum : $totalItems;
		
		// Set lastPageNum
		$lastPageNum = ($page*$intItemsPerPage);
		$lastPageNum = ($totalItems > $lastPageNum) ? $lastPageNum : $totalItems;
		
		// Set firstOfAll class
		if($picNum == '1')
		{
			$objTemplate->class .= ($objTemplate->class == '') ? 'firstOfAll' : ' firstOfAll';
		}
		
		// Set lastOfAll class
		if($picNum == $totalItems)
		{
			$objTemplate->class .= ($objTemplate->class == '') ? 'lastOfAll' : ' lastOfAll';
		}
		
		$objTemplate->class .= ($objTemplate->class == '') ? 'picnum_' . $picNum : ' picnum_' . $picNum;
		
		// Set vars in template
		$objTemplate->picNum = $picNum;
		$objTemplate->firstPageNum = $firstPageNum;
		$objTemplate->lastPageNum = $lastPageNum;
		
		return $objTemplate;
	}
	
	
	/**
	 * pa2BuildDate function.
	 * 
	 * @access protected
	 * @param object $objTemplate
	 * @param int $intStartdate
	 * @param int $intEnddate
	 * @return object
	 */
	protected function pa2BuildDate($objTemplate, $intStartdate, $intEnddate)
	{
		global $objPage;
		
		// Check
		if(!is_object($objTemplate))
		{
			return false;
		}
		
		$startdate = (!empty($intStartdate) && $intStartdate > 0) ? $this->parseDate($objPage->dateFormat, $intStartdate) : false;
		$enddate = (!empty($intEnddate) && $intEnddate > 0) ? $this->parseDate($objPage->dateFormat, $intEnddate) : false;
		
		if ($startdate == $enddate)
		{
		    $objTemplate->date = $startdate;
		}
		else
		{
		    $objTemplate->date = $startdate . ' - ' . $enddate;
		}
		
		return $objTemplate;
	}
	
	
	/**
	 * pa2MetaFields function.
	 * 
	 * @access protected
	 * @param object $objTemplate
	 * @param string $type
	 * @return object
	 */
	protected function pa2MetaFields($objTemplate, $metaFields)
	{
		// Check
		if(!is_object($objTemplate))
		{
			return false;
		}
		
		// Set vars to template object
		$objTemplate->metaFields = (is_array($metaFields) && count($metaFields) > 0) ? $metaFields : false;
		
		return $objTemplate;
	}
	
	
	/**
	 * addArrVars function.
	 * 
	 * @access public
	 * @param array $arrVars
	 * @return void
	 */
	public function addArrVars($arrVars)
	{
		$this->arrVars = $arrVars;
	}
	
	
	/**
	 * cleanRteOutput function.
	 * 
	 * @access public
	 * @param string $text
	 * @return string
	 */
	public function cleanRteOutput($text)
	{
		global $objPage;
		$this->import('String');
		
		// Clean the RTE output
		if ($objPage->outputFormat == 'xhtml')
		{
			$text = $this->String->toXhtml($text);
		}
		else
		{
			$text = $this->String->toHtml5($text);
		}

		$text = $this->String->encodeEmail($text);
		
		return $text;
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
		
		while ($objArchive->next())
		{
			$objArchive->feedName = ($objArchive->alias != '') ? $objArchive->alias : 'pa2' . $objArchive->id;

			$this->generateFiles($objArchive->row());
			$this->log('Generated pa2 feed "' . $objArchive->feedName . '.xml"', 'Pa2 generateFeeds()', TL_CRON);
		}
	}


	/**
	 * Generate an XML files and save them to the root directory
	 * @param array
	 */
	protected function generateFiles($arrArchive)
	{
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
		while ($objArticle->next())
		{
			// Deserialize picture arrays
			$objArticle->pictures = deserialize($objArticle->pictures);
			$objArticle->pic_sort = deserialize($objArticle->pic_sort);
			
			// Sort photos
			$objPa2PicSorter = new \Pa2PicSorter($objArticle->pic_sort_check, $objArticle->pictures, $objArticle->pic_sort);
			$this->arrPhotos = $objPa2PicSorter->getSortedIds();
			
			$objItem = new \FeedItem();
			
			$objItem->title = $objArticle->title;
			$objItem->link = sprintf($strLink . $strUrl, (($objArticle->alias != '' && !$GLOBALS['TL_CONFIG']['disableAlias']) ? $objArticle->alias : $objArticle->id));
			$objItem->published = $objArticle->startdate;
			$objItem->author = $objArticle->authorName;
			
			if(is_array($objArticle->arrPhotos) && count($objArticle->arrPhotos) > 0)
			{
				foreach($objArticle->arrPhotos as $photo)
				{
					if (is_file(TL_ROOT . '/' . $photo))
					{
						$objItem->addEnclosure($photo);
					}
				}
			}

			// Prepare the description
			$objItem->description = $this->replaceInsertTags($objArticle->description);

			$objFeed->addItem($objItem);
		}

		// Create file
		$objRss = new \File($strFile . '.xml');
		$objRss->write($this->replaceInsertTags($objFeed->$strType()));
		$objRss->close();
	}
}
