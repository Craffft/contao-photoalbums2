<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel 
 * @package    photoalbums2 
 * @license    LGPL 
 * @filesource
 */


/**
 * Class Pa2
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel 
 * @package    Frontend
 */
class Pa2 extends Frontend
{
	public $pa2Type = 'pa2';
	protected $arrVars = array();
	
	
	/**
	 * addCssFile function.
	 * 
	 * @access public
	 * @return void
	 */
	public function addCssFile()
	{
		// Get layout skipPhotoalbums2 to disable photoalbums css file
		$objLayout = $this->Database->prepare("SELECT skipPhotoalbums2 FROM tl_layout WHERE id=? OR fallback=1 ORDER BY fallback")
									->limit(1)
									->execute($objPage->layout);
		
		// Add css
		if (TL_MODE=='FE' && $objLayout->skipPhotoalbums2 != '1')
		{
			$GLOBALS['TL_CSS'][] = TL_FILES_URL . 'system/modules/photoalbums2/html/photoalbums2.css';
		}
		
		// Add css
		if (TL_MODE=='BE')
		{
			$GLOBALS['TL_CSS'][] = TL_FILES_URL . 'system/modules/photoalbums2/html/photoalbums2.css';
			$GLOBALS['TL_CSS'][] = TL_FILES_URL . 'system/modules/photoalbums2/html/photoalbums2_be.css';
		}
	}
	
	
	/**
	 * fetchAlbums function.
	 * 
	 * @access protected
	 * @param object $objAlbums
	 * @return array
	 */
	protected function fetchAlbums($objAlbums)
	{
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
		
		// Fetch all albums
		$arrAlbumsFetch = $objAlbums->fetchAllAssoc();
		
		// Set array
		$arrAlbums = array();
		
		// Import PicSortWizard
		$this->import('PicSortWizard');
		
		// Filter data
		foreach($arrAlbumsFetch as $album)
		{
			if (in_array($album['id'], $arrSortedAlbums))
			{
				$album['pictures'] = $this->PicSortWizard->getUnsortedPictures(deserialize($album['pictures']), $GLOBALS['TL_DCA']['tl_photoalbums2_album']['fields']['pictures']['eval']['extensions']);
				$album['preview_pic'] = deserialize($album['preview_pic']);
				$album['preview_pic'] = $this->getPreviewPic($album, $this->arrVars['pa2PreviewPic']);
				$album['pic_sort'] = deserialize($album['pic_sort']);
				
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
		if ($type=='album')
		{
			$albumSQL = ", published, startdate, enddate";
		}
		
		$objElement = $this->Database->execute("SELECT id, protected, users, groups" . $albumSQL . " FROM tl_photoalbums2_" . $type . " WHERE id IN(" . implode(',', array_map('intval', $arrElements)) . ")");
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
	 * sortElements function.
	 * 
	 * @access public
	 * @param array $arrImagePaths
	 * @param string $sortType
	 * @return array
	 */
	public function sortElements($arrImagePaths, $sortType)
	{
		// Sort by name
		if($sortType == 'name_asc' || $sortType == 'name_desc')
		{
			$arrSort = array();
			
			foreach($arrImagePaths as $key => $imagePath)
		    {
		    	$arrSort[$key] = substr(strrchr($imagePath, '/'), 1);
		    }
		    
		    if($sortType == 'name_asc')
		    {
		    	array_multisort($arrSort, SORT_ASC, $arrImagePaths, SORT_ASC);
		    }
		    
		    if($sortType == 'name_desc')
		    {
		    	array_multisort($arrSort, SORT_DESC, $arrImagePaths, SORT_DESC);
		    }
		}
		
		// Sort by date
		if($sortType == 'date_asc' || $sortType == 'date_desc')
		{
			$arrSort = array();
			
			foreach($arrImagePaths as $key => $imagePath)
		    {
		    	$arrSort[$key] = filemtime($imagePath);
		    }
		    
		    if($sortType == 'date_asc')
		    {
		    	array_multisort($arrSort, SORT_NUMERIC, SORT_ASC, $arrImagePaths, SORT_ASC);
		    }
		    
		    if($sortType == 'date_desc')
		    {
		    	array_multisort($arrSort, SORT_NUMERIC, SORT_DESC, $arrImagePaths, SORT_DESC);
		    }
		}
		
		// Sort random
		if($sortType == 'random')
		{
			shuffle($arrImagePaths);
		}
		
		return $arrImagePaths;
	}
	
	
	/**
	 * getTimeFilterData function.
	 * 
	 * @access protected
	 * @param array $arrData
	 * @return int
	 */
	protected function getTimeFilterData($arrData, $typeEnd = false)
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
	 * @param int $totalAll
	 * @param int $i
	 * @param int $pa2PerPage
	 * @return object
	 */
	protected function pa2AddSpecificClasses($objTemplate, $totalAll, $i, $pa2PerPage, $type)
	{
		// Set var maxPage
		$maxPage = (int) ceil($totalAll/$pa2PerPage);
		
		// Set var page
		$page = $this->Input->get('page');
		$page = (is_numeric($page)) ? $page : 1;
		$page = ($maxPage > $page) ? $page : $maxPage;
		
		// Set numRow var
		if($type == 'albums')
		{
			$picNum = $i+1+(($page-1)*$pa2PerPage);
		}
		else if($type == 'photos')
		{
			$picNum = $i+1;
		}
		else
		{
			return false;
		}
		
		// Set firstPageNum
		$firstPageNum = (($page-1)*$pa2PerPage) + 1;
		$firstPageNum = ($totalAll > $firstPageNum) ? $firstPageNum : $totalAll;
		
		// Set lastPageNum
		$lastPageNum = ($page*$pa2PerPage);
		$lastPageNum = ($totalAll > $lastPageNum) ? $lastPageNum : $totalAll;
		
		// Set firstOfAll class
		if($picNum == '1')
		{
			$objTemplate->class .= ($objTemplate->class == '') ? 'firstOfAll' : ' firstOfAll';
		}
		
		// Set lastOfAll class
		if($picNum == $totalAll)
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
	 * pa2Pagination function.
	 * 
	 * @access public
	 * @param mixed $arrElements
	 * @param mixed $pa2NumberOf
	 * @param mixed $pa2PerPage
	 * @param mixed $total
	 * @return void
	 */
	public function pa2Pagination($arrElements, $pa2NumberOf, $pa2PerPage, $total)
	{
		// Check for array and content
		if(!is_array($arrElements) || count($arrElements) < 1)
		{
			return false;
		}
		
		// Maximum number of items
		if ($pa2NumberOf > 0)
		{
			$limit = $pa2NumberOf;
		}
		
		if ($pa2PerPage > 0 && (!isset($limit) || $pa2NumberOf > $pa2PerPage))
		{
			// Adjust the overall limit
			if (isset($limit))
			{
				$total = min($limit, $total);
			}

			$page = $this->Input->get('page') ? $this->Input->get('page') : 1;

			// Check the maximum page number
			if ($page > ($total/$pa2PerPage))
			{
				$page = ceil($total/$pa2PerPage);
			}

			// Limit and offset
			$limit = $pa2PerPage;
			$offset = (max($page, 1) - 1) * $pa2PerPage;

			// Overall limit
			if ($offset + $limit > $total)
			{
				$limit = $total - $offset;
			}

			// Add the pagination menu
			$objPagination = new Pagination($total, $pa2PerPage);
			$pagination = $objPagination->generate("\n  ");
			
			// Filter albums by pagination
			$arrPaginationFilter = array();
			for($i=$offset; ($offset+$limit) > $i; $i++)
			{
				$arrPaginationFilter[] = $arrElements[$i];
			}
			
			$arrElements = $arrPaginationFilter;
		}
		
		// Set return array
		$arrReturn = array(
			'elements' => $arrElements,
			'pagination' => $pagination
		);
		
		return $arrReturn;
	}
	
	
	/**
	 * getPreviewPic function.
	 * 
	 * @access public
	 * @param array $album
	 * @param string $pa2PreviewPic
	 * @return string
	 */
	public function getPreviewPic($album, $pa2PreviewPic)
	{
		$previewPic = '';
		
		switch($pa2PreviewPic)
		{
			case 'use_album_options':
				switch($album['preview_pic_check'])
				{
					case 'no_preview_pic':
						$previewPic = '';
					break;
					
					case 'random_preview_pic':
						$previewPic = $this->getRandomPreviewPic($album);
					break;
					
					case 'select_preview_pic':
						$previewPic = $album['preview_pic'];
					break;
				}
			break;
			
			case 'no_preview_pics':
				$previewPic = '';
			break;
			
			case 'random_pics':
				$previewPic = $this->getRandomPreviewPic($album);
			break;
			
			case 'random_pics_at_no_preview_pics':
				if($album['preview_pic_check'] == 'select_preview_pic')
				{
					$previewPic = $album['preview_pic'];
				}
				else
				{
					$previewPic = $this->getRandomPreviewPic($album);
				}
			break;
		}
		
		return $previewPic;
	}
	
	
	/**
	 * getRandomPreviewPic function.
	 * 
	 * @access public
	 * @param array $album
	 * @return string
	 */
	public function getRandomPreviewPic($album)
	{
		if(count($album['pictures']) < 1)
		{
			return '';
		}
		
		return $album['pictures'][mt_rand(0, count($album['pictures'])-1)];
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
		$objArchive = $this->Database->prepare("SELECT * FROM tl_photoalbums2_archive WHERE id=? AND makeFeed=?")
									 ->limit(1)
									 ->execute($intId, 1);

		if ($objArchive->numRows < 1)
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
		$objArchive = $this->Database->execute("SELECT * FROM tl_photoalbums2_archive WHERE makeFeed=1 AND protected!=1");

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

		$objFeed = new Feed($strFile);

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
		$objParent = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")
									->limit(1)
									->execute($arrArchive['modulePage']);

		if ($objParent->numRows < 1)
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
			$objArticle->arrPhotos = ($objArticle->pic_sort_check == 'pic_sort_wizard') ? $objArticle->pic_sort : $this->sortElements($objArticle->pictures, $objArticle->pic_sort_check);
			
			$objItem = new FeedItem();
			
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
		$objRss = new File($strFile . '.xml');
		$objRss->write($this->replaceInsertTags($objFeed->$strType()));
		$objRss->close();
	}
}

?>