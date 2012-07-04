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
	public function getAlbum($val)
	{
		// Set id and alias
		$id = '';
		$alias = '';
		
		// Check value
		if(is_numeric($val))
		{
			$id = $val;
		}
		else
		{
			$alias = $val;
		}
		
		
		// Get album by alias
		$objAlbums = $this->Database->prepare("SELECT * FROM tl_photoalbums2_album WHERE id=? OR alias=? LIMIT 1")
									->execute($id, $alias);
		
		return $this->fetchAlbums($objAlbums);
	}
	
	
	/**
	 * parsePhotos function.
	 * 
	 * @access public
	 * @param array $arrAlbum
	 * @param array $arrPaginationPhotos
	 * @return array
	 */
	public function parsePhotos($objTemplate, $arrAlbum, $arrPaginationPhotos)
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
		$objTemplate->showHeadline = $this->arrVars['pa2ShowHeadline'];
		$objTemplate->showTitle = $this->arrVars['pa2ShowTitle'];
		$objTemplate->showTeaser = $this->arrVars['pa2ShowTeaser'];
		$objTemplate->teaser = $this->cleanRteOutput($this->arrVars['pa2Teaser']);
		
		// Check headline
		if($objTemplate->headline == '')
		{
			$objTemplate->showHeadline = false;
		}
		
		// Check title
		if($objTemplate->title == '')
		{
			$objTemplate->showTitle = false;
		}
		
		// Check teaser
		if($objTemplate->teaser == '')
		{
			$objTemplate->showTeaser = false;
		}
		
		// Define date
		$objTemplate = $this->pa2BuildDate($objTemplate, $arrAlbum['startdate'], $arrAlbum['enddate']);
		
		// Define metaFields
		$objTemplate = $this->pa2MetaFields($objTemplate, $this->arrVars['pa2MetaFields']);
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
			$objSubTemplate = new FrontendTemplate($this->arrVars['strSubtemplate']);
			$objSubTemplate->setData($this->arrVars['arrData']);
			
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
				$objSubTemplate = $this->pa2PerRow($objSubTemplate, $paginationTotal, $pagiantionCount, $this->arrVars['pa2PerRow']);
				
				// Define show
				$objSubTemplate->show = true;
				
				// Set image
			    $arrImage['size'] = $this->arrVars['pa2ImageSize'];
			    $arrImage['imagemargin'] = $this->arrVars['pa2ImageMargin'];
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
			$objSubTemplate->albumID = $this->arrVars['id'];
			
			// Set href
			$objSubTemplate->href = str_replace(' ', '%20', $element);
			
			// Add an image
			if ($element!='' && is_file(TL_ROOT . '/' . $element))
			{
			    // Add alt tag
			    $arrImage['alt'] = substr(strrchr($element, '/'), 1);
			    
			    $this->addImageToTemplate($objSubTemplate, $arrImage);
			    
			    // Add link title to template
				$objSubTemplate->title = substr(strrchr($element, '/'), 1);
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