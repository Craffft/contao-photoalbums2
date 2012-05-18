<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
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
 * Class ModulePhotoalbums2
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel 
 * @package    Controller
 */
class ModulePhotoalbums2 extends Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_photoalbums2';


	/**
	 * Subtemplate
	 * @var string
	 */
	protected $strSubtemplate = 'pa2_album';
	
	
	/**
	 * generate function.
	 * 
	 * @access public
	 * @return void
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### PHOTOALBUMS 2 MODULE ###';

			return $objTemplate->parse();
		}
		
		// Deserialize vars
		$this->groups = deserialize($this->groups);
		$this->pa2Archives = deserialize($this->pa2Archives);
		$this->pa2AlbumsMetaFields = deserialize($this->pa2AlbumsMetaFields);
		$this->pa2PhotosMetaFields = deserialize($this->pa2PhotosMetaFields);
		$this->pa2TimeFilterStart = deserialize($this->pa2TimeFilterStart);
		$this->pa2TimeFilterEnd = deserialize($this->pa2TimeFilterEnd);
		
		// Get unsorted pictures
		$this->import('PicSortWizard');
		$this->loadDataContainer('tl_photoalbums2_album');
		$this->pictures = $this->PicSortWizard->getUnsortedPictures($this->pictures, $GLOBALS['TL_DCA']['tl_photoalbums2_album']['fields']['pictures']['eval']['extensions']);
		
		// Import Photoalbums2 class
		$this->import('Photoalbums2');
		
		return parent::generate();
	}


	/**
	 * compile function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function compile()
	{
		global $objPage;
		
		// Get layout skipPhotoalbums2 to disable photoalbums css file
		$objLayout = $this->Database->prepare("SELECT skipPhotoalbums2 FROM tl_layout WHERE id=? OR fallback=1 ORDER BY fallback")
									->limit(1)
									->execute($objPage->layout);
		
		// Add css
		if (TL_MODE=='FE' && $objLayout->skipPhotoalbums2 != '1')
		{
			$GLOBALS['TL_CSS'][] = TL_FILES_URL . 'system/modules/photoalbums2/html/photoalbums2.css';
		}
		
		// Check for detail view
		if ($this->Input->get('items'))
		{
			// Set Subtemplate
			$this->strSubtemplate = $this->pa2PhotosTemplate;
			
			$pa2NumberOf = $this->pa2NumberOfPhotos;
			$pa2PerPage = $this->pa2PhotosPerPage;
			$arrElements = $this->getAlbum($this->Input->get('items'));
			$arrPhotos = $arrElements[0];
			
			$arrElements = ($arrElements[0]['pic_sort_check'] == 'pic_sort_wizard') ? $arrElements[0]['pic_sort'] : $this->sortElements($arrElements[0]['pictures'], $arrElements[0]['pic_sort_check']);
			
			// Go back
			$this->Template->referer = $this->generateFrontendUrl(array('id'=>$objPage->id, 'alias'=>$objPage->alias));
			$this->Template->back = $GLOBALS['TL_LANG']['MSC']['goBack'];
			
			// Empty text
			$empty = $GLOBALS['TL_LANG']['MSC']['photosEmpty'];
		}
		else
		{
			// Set Subtemplate
			$this->strSubtemplate = $this->pa2AlbumsTemplate;
			
			// Define vars
			$pa2NumberOf = $this->pa2NumberOfAlbums;
			$pa2PerPage = $this->pa2AlbumsPerPage;
			
			// Sort out 
			$this->pa2Archives = $this->sortOutElements($this->pa2Archives);
			$arrElements = $this->getAlbums($this->pa2Archives);
			
			// Empty text
			$empty = $GLOBALS['TL_LANG']['MSC']['albumsEmpty'];
		}
		
		// Add Subtemplate to Template
		$this->Template->strSubtemplate = $this->strSubtemplate;
		
		// Get albums
		$total = count($arrElements);
		
		// If albums empty
		if ($total < 1 || !$arrElements)
		{
			$this->strTemplate = 'mod_photoalbums2_empty';
			$this->Template = new FrontendTemplate($this->strTemplate);
			$this->Template->setData($this->arrData);
			$this->Template->empty = $empty;
		}
		
		// Pagination
		$arrPa2Pagination = $this->pa2Pagination($arrElements, $pa2NumberOf, $pa2PerPage, $total);
		$arrElements = $arrPa2Pagination['elements'];
		$this->Template->pagination = $arrPa2Pagination['pagination'];
		
		// Check for detail view
		if ($this->Input->get('items'))
		{
			// Parse photos
			$this->items = $this->parsePhotos($arrPhotos, $arrElements);
		}
		else
		{
			// Parse albums
			$this->items = $this->parseAlbums($arrElements);
		}
		
		// Set Template vars
		$this->Template->items = $this->items;
	}
	
	
	/**
	 * getAlbumIdByAlias function.
	 * 
	 * @access protected
	 * @param string $alias
	 * @return int
	 */
	protected function getAlbum($alias)
	{
		// Get album id by alias
		$objAlbums = $this->Database->prepare("SELECT * FROM tl_photoalbums2_album WHERE alias=? LIMIT 1")
									->execute($alias);
		
		return $this->fetchAlbums($objAlbums);
	}
	
	
	/**
	 * getAlbums function.
	 * 
	 * @access protected
	 * @param array $arrArchives
	 * @return array
	 */
	protected function getAlbums($arrArchives)
	{
		// Check for array and content
		if (!is_array($arrArchives) || count($arrArchives) < 1)
		{
			return false;
		}
		
		// Get albums from archives
		$objAlbums = $this->Database->execute("SELECT * FROM tl_photoalbums2_album WHERE pid IN(" . implode(',', array_map('intval', $arrArchives)) . ") ORDER BY pid, sorting");
		
		return $this->fetchAlbums($objAlbums);
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
		
		// Filter data
		foreach($arrAlbumsFetch as $album)
		{
			if (in_array($album['id'], $arrSortedAlbums))
			{
				$album['pictures'] = $this->PicSortWizard->getUnsortedPictures(deserialize($album['pictures']), $GLOBALS['TL_DCA']['tl_photoalbums2_album']['fields']['pictures']['eval']['extensions']);
				$album['pic_preview'] = deserialize($album['pic_preview']);
				$album['pic_sort'] = deserialize($album['pic_sort']);
				
				$arrAlbums[] = $album;
			}
		}
		
		return $arrAlbums;
	}
	
	
	/**
	 * sortElements function.
	 * 
	 * @access protected
	 * @param array $arrImagePaths
	 * @param string $sortType
	 * @return array
	 */
	protected function sortElements($arrImagePaths, $sortType)
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
		    
		    foreach($arrImagePaths as $a)
		    {
		    	echo '<br>';
		    	echo filemtime($a);
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
	 * sortOutElements function.
	 * 
	 * @access protected
	 * @param array $arrElements
	 * @param string $type (default: 'archive')
	 * @return array
	 */
	protected function sortOutElements($arrElements, $type = 'archive')
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
					
					$filterStart = $this->Photoalbums2->getTimeFilterData($this->pa2TimeFilterStart);
					$filterEnd = $this->Photoalbums2->getTimeFilterData($this->pa2TimeFilterEnd, true);
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
	 * pa2Pagination function.
	 * 
	 * @access protected
	 * @param mixed $arrElements
	 * @param mixed $pa2NumberOf
	 * @param mixed $pa2PerPage
	 * @param mixed $total
	 * @return void
	 */
	protected function pa2Pagination($arrElements, $pa2NumberOf, $pa2PerPage, $total)
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
	 * pa2PerRow function.
	 * 
	 * @access public
	 * @param object $objTemplate
	 * @param int $total
	 * @param int $i
	 * @param string $type
	 * @return object
	 */
	function pa2PerRow($objTemplate, $total, $i, $type)
	{
		// Check
		if(!is_object($objTemplate) || ($type!='albums' && $type!='photos'))
		{
			return false;
		}
		
		// Get perRow var
		$typePerRow = 'pa2' . ucfirst($type) . 'PerRow';
		$perRow = $this->$typePerRow;
		
		// Get modulo
		$m = $i%$perRow;
		
		// Set width from objects
		$objTemplate->style = (($objTemplate->style=='') ? '' : ($objTemplate->style) . ' ') . 'width: ' . (100/$perRow) . '%;';
		
		// Set row start
		$objTemplate->rowStart = false;
		if($m == 0)
		{
		    $objTemplate->class = (($objTemplate->class=='') ? ' ' : ($objTemplate->class) . ' ') . 'first';
		    $objTemplate->rowStart = true;
		}
		
		// Set row end
		$objTemplate->rowEnd = false;
		if($m == ($perRow-1) || $total == ($i+1))
		{
		    $objTemplate->class = (($objTemplate->class=='') ? ' ' : ($objTemplate->class) . ' ') . 'last';
		    $objTemplate->rowEnd = true;
		}
		
		return $objTemplate;
	}
	
	
	/**
	 * pa2BuildDate function.
	 * 
	 * @access public
	 * @param object $objTemplate
	 * @param int $intStartdate
	 * @param int $intEnddate
	 * @return object
	 */
	function pa2BuildDate($objTemplate, $intStartdate, $intEnddate)
	{
		// Check
		if(!is_object($objTemplate))
		{
			return false;
		}
		
		$startdate = (!empty($intStartdate) && $intStartdate > 0) ? date($GLOBALS['TL_CONFIG']['dateFormat'], $intStartdate) : false;
		$enddate = (!empty($intEnddate) && $intEnddate > 0) ? date($GLOBALS['TL_CONFIG']['dateFormat'], $intEnddate) : false;
		
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
	 * @access public
	 * @param object $objTemplate
	 * @param string $type
	 * @return object
	 */
	function pa2MetaFields($objTemplate, $type)
	{
		// Check
		if(!is_object($objTemplate) || ($type!='albums' && $type!='photos'))
		{
			return false;
		}
		
		// Get metaFields var
		$typeMetaFields = 'pa2' . ucfirst($type) . 'MetaFields';
		$metaFields = $this->$typeMetaFields;
		
		// Set vars to template object
		$objTemplate->metaFields = (is_array($metaFields) && count($metaFields) > 0) ? $metaFields : false;
		
		return $objTemplate;
	}
	
	
	/**
	 * parsePhotos function.
	 * 
	 * @access public
	 * @param array $arrAlbum
	 * @param array $arrPaginationPhotos
	 * @return array
	 */
	function parsePhotos($arrAlbum, $arrPaginationPhotos)
	{
		// Check
		if(!is_array($arrAlbum) || count($arrAlbum) < 1 || !is_array($arrPaginationPhotos) || count($arrPaginationPhotos) < 1)
		{
			return false;
		}
		
		global $objPage;
		
		$arrElements = array();
		
		$this->Template->title = $arrAlbum['title'];
		$this->Template->alias = $arrAlbum['alias'];
		
		// Define date
		$this->Template = $this->pa2BuildDate($this->Template, $arrAlbum['startdate'], $arrAlbum['enddate']);
		
		// Define metaFields
		$this->Template = $this->pa2MetaFields($this->Template, 'photos');
		$this->Template->event = $arrAlbum['event'];
		$this->Template->place = $arrAlbum['place'];
		$this->Template->photographer = $arrAlbum['photographer'];
		$this->Template->description = $arrAlbum['description'];
		
		// Get only pictures as array
		$arrPictures = ($arrAlbum['pic_sort_check'] == 'pic_sort_wizard') ? $arrAlbum['pic_sort'] : $this->sortElements($arrAlbum['pictures'], $arrAlbum['pic_sort_check']);;
		
		// Check arrElements
		if(!is_array($arrPictures) || count($arrPictures) < 1)
		{
			return false;
		}
		
		// Define pagination helper vars
		$pagiantionCount = 0;
		$paginationTotal = count($arrPaginationPhotos);
		
		foreach($arrPictures as $i => $element)
		{
			$objTemplate = new FrontendTemplate($this->strSubtemplate);
			$objTemplate->setData($this->arrData);
			
			// Define show
			$objTemplate->show = false;
			
			// Check Version
			$objTemplate->lbvCheck = (version_compare(VERSION.'.'.BUILD, '2.11.0', '>='));
			
			// Define image array
			$arrImage = array();
			
			// If show element
			if (in_array($element, $arrPaginationPhotos))
			{
				// Define perRow
				$objTemplate = $this->pa2PerRow($objTemplate, $paginationTotal, $pagiantionCount, 'photos');
				
				// Define show
				$objTemplate->show = true;
				
				// Set image
			    $arrImage['size'] = $this->pa2PhotosImageSize;
			    $arrImage['imagemargin'] = $this->pa2PhotosImageMargin;
			    $arrImage['singleSRC'] = $element;
				
				$pagiantionCount++;
			}
			else
			{
				//Set image
				$arrImage['size'] = serialize(array(0, 0, 'crop'));
				$arrImage['imagemargin'] = serialize(array('bottom'=>'', 'left'=>'', 'right'=>'', 'top'=>'', 'unit'=>''));
			    $arrImage['singleSRC'] = 'system/modules/photoalbums2/html/blank.gif';
			}
			
			// Set element ID
			$objTemplate->elementID = $i;
			
			// Set album ID
			$objTemplate->albumID = $this->id;
			
			// Set href
			$objTemplate->href = str_replace(' ', '%20', $element);
			
			// Add an image
			if ($element!='' && is_file(TL_ROOT . '/' . $element))
			{
			    // Add alt tag
			    $arrImage['alt'] = substr(strrchr($element, '/'), 1);
			    
			    $this->addImageToTemplate($objTemplate, $arrImage);
			    
			    // Add imgName to template
				$objTemplate->imgName = substr(strrchr($element, '/'), 1);
			}
			
			// Parse template
			$arrElements[] = $objTemplate->parse();
		}
		
		return $arrElements;
	}
	
	
	/**
	 * parseAlbums function.
	 * 
	 * @access public
	 * @param array $arrAlbums
	 * @return array
	 */
	function parseAlbums($arrAlbums)
	{
		// Check
		if(!is_array($arrAlbums) || count($arrAlbums) < 1)
		{
			return false;
		}
		
		global $objPage;
		
		$arrElements = array();
		
		// Numerical value of all albums
		$total = count($arrAlbums);
		
		foreach($arrAlbums as $i => $album)
		{
			$objTemplate = new FrontendTemplate($this->strSubtemplate);
			$objTemplate->setData($this->arrData);
			
			// Define perRow
			$objTemplate = $this->pa2PerRow($objTemplate, $total, $i, 'albums');
			
			// Define date
			$objTemplate = $this->pa2BuildDate($objTemplate, $album['startdate'], $album['enddate']);
			
			// Define metaFields
			$objTemplate = $this->pa2MetaFields($objTemplate, 'albums');
			
			// Add an image
			if ($album['pic_preview']!='' && is_file(TL_ROOT . '/' . $album['pic_preview']))
			{
				$arrImage = array();
				$arrImage['size'] = $this->pa2AlbumsImageSize;
				$arrImage['imagemargin'] = $this->pa2AlbumsImageMargin;
				$arrImage['singleSRC'] = $album['pic_preview'];
				$arrImage['alt'] = strip_tags($album['title']);

				$this->addImageToTemplate($objTemplate, $arrImage);
			}
			
			// Add imgName to template
			$objTemplate->imgName = strip_tags($album['title']);
			
			// Add array
			$arrLink = array(
				'id' => $objPage->id,
				'alias' => $objPage->alias
			);
			
			$objTemplate->title = $album['title'];
			$objTemplate->alias = $album['alias'];
			$objTemplate->event = $album['event'];
			$objTemplate->place = $album['place'];
			$objTemplate->photographer = $album['photographer'];
			$objTemplate->description = $album['description'];
			$objTemplate->href = $this->generateFrontendUrl($arrLink, '/items/' . $album['alias']);
			
			// Parse template
			$arrElements[] = $objTemplate->parse();
		}
		
		return $arrElements;
	}
}

?>