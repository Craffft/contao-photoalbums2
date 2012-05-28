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
 * Class Pa2Albums
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel 
 * @package    Frontend
 * @extends Pa2
 */
class Pa2Photos extends Pa2
{
	public static $pa2Type = 'photos';
	
	
	/**
	 * getAlbum function.
	 * 
	 * @access public
	 * @param string $alias
	 * @return int
	 */
	public function getAlbum($alias)
	{
		// Get album id by alias
		$objAlbums = $this->Database->prepare("SELECT * FROM tl_photoalbums2_album WHERE alias=? LIMIT 1")
									->execute($alias);
		
		return $this->fetchAlbums($objAlbums);
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
	 * parsePhotos function.
	 * 
	 * @access public
	 * @param array $arrAlbum
	 * @param array $arrPaginationPhotos
	 * @return array
	 */
	function parsePhotos($objTemplate, $arrAlbum, $arrPaginationPhotos, $arrVars)
	{
		// Check
		if(!is_array($arrAlbum) || count($arrAlbum) < 1 || !is_array($arrPaginationPhotos) || count($arrPaginationPhotos) < 1)
		{
			return false;
		}
		
		global $objPage;
		
		$arrElements = array();
		
		$objTemplate->title = $arrAlbum['title'];
		$objTemplate->alias = $arrAlbum['alias'];
		$objTemplate->showHeadline = ($arrVars['pa2ShowHeadline'] == 1) ? true : false;
		$objTemplate->showTitle = ($arrVars['pa2ShowTitle'] == 1) ? true : false;
		
		// Define date
		$objTemplate = $this->pa2BuildDate($objTemplate, $arrAlbum['startdate'], $arrAlbum['enddate']);
		
		// Define metaFields
		$objTemplate = $this->pa2MetaFields($objTemplate, $arrVars['pa2MetaFields']);
		$objTemplate->event = $arrAlbum['event'];
		$objTemplate->place = $arrAlbum['place'];
		$objTemplate->photographer = $arrAlbum['photographer'];
		$objTemplate->description = $arrAlbum['description'];
		
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
			$objSubTemplate = new FrontendTemplate($arrVars['strSubtemplate']);
			$objSubTemplate->setData($arrVars['arrData']);
			
			// Define show
			$objSubTemplate->show = false;
			
			// Check Version
			$objSubTemplate->lbvCheck = (version_compare(VERSION.'.'.BUILD, '2.11.0', '>='));
			
			// Define image array
			$arrImage = array();
			
			// If show element
			if (in_array($element, $arrPaginationPhotos))
			{
				// Define perRow
				$objSubTemplate = $this->pa2PerRow($objSubTemplate, $paginationTotal, $pagiantionCount, $arrVars['pa2PerRow']);
				
				// Define show
				$objSubTemplate->show = true;
				
				// Set image
			    $arrImage['size'] = $arrVars['pa2ImageSize'];
			    $arrImage['imagemargin'] = $arrVars['pa2ImageMargin'];
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
			$objSubTemplate->elementID = $i;
			
			// Set album ID
			$objSubTemplate->albumID = $arrVars['id'];
			
			// Set href
			$objSubTemplate->href = str_replace(' ', '%20', $element);
			
			// Add an image
			if ($element!='' && is_file(TL_ROOT . '/' . $element))
			{
			    // Add alt tag
			    $arrImage['alt'] = substr(strrchr($element, '/'), 1);
			    
			    $this->addImageToTemplate($objSubTemplate, $arrImage);
			    
			    // Add imgName to template
				$objSubTemplate->imgName = substr(strrchr($element, '/'), 1);
			}
			
			// Parse template
			$arrElements[] = $objSubTemplate->parse();
		}
		
		
		
		// Add items to template
		$objTemplate->items = $arrElements;
		
		return $objTemplate;
	}
}

?>