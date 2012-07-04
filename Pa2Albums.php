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
class Pa2Albums extends Pa2
{
	public static $pa2Type = 'albums';
	
	
	/**
	 * getAlbums function.
	 * 
	 * @access public
	 * @param array $arrArchives
	 * @return array
	 */
	public function getAlbums($arrArchives)
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
	 * parseAlbums function.
	 * 
	 * @access public
	 * @param array $arrAlbums
	 * @return array
	 */
	public function parseAlbums($objTemplate, $arrAlbums)
	{
		// Check
		if(!is_array($arrAlbums) || count($arrAlbums) < 1)
		{
			return false;
		}
		
		global $objPage;
		
		$arrElements = array();
		
		// Set Template vars
		$objTemplate->showHeadline = $this->arrVars['pa2ShowHeadline'];
		$objTemplate->showTeaser = $this->arrVars['pa2ShowTeaser'];
		$objTemplate->teaser = $this->cleanRteOutput($this->arrVars['pa2Teaser']);
		
		// Check headline
		if($objTemplate->headline == '')
		{
			$objTemplate->showHeadline = false;
		}
		
		// Check teaser
		if($objTemplate->teaser == '')
		{
			$objTemplate->showTeaser = false;
		}
		
		// Numerical value of all albums
		$total = count($arrAlbums);
		
		foreach($arrAlbums as $i => $album)
		{
			$objSubTemplate = new FrontendTemplate($this->arrVars['strSubtemplate']);
			$objSubTemplate->setData($this->arrVars['arrData']);
			
			// Define perRow
			$objSubTemplate = $this->pa2PerRow($objSubTemplate, $total, $i, $this->arrVars['pa2PerRow']);
			
			// Define date
			$objSubTemplate = $this->pa2BuildDate($objSubTemplate, $album['startdate'], $album['enddate']);
			
			// Define metaFields
			$objSubTemplate = $this->pa2MetaFields($objSubTemplate, $this->arrVars['pa2MetaFields']);
			
			// Add an image
			if ($album['preview_pic']!='' && is_file(TL_ROOT . '/' . $album['preview_pic']))
			{
				$arrImage = array();
				$arrImage['size'] = $this->arrVars['pa2ImageSize'];
				$arrImage['imagemargin'] = $this->arrVars['pa2ImageMargin'];
				$arrImage['singleSRC'] = $album['preview_pic'];
				$arrImage['alt'] = strip_tags($album['title']);

				$this->addImageToTemplate($objSubTemplate, $arrImage);
			}
			
			// Add link title to template
			$objSubTemplate->title = strip_tags($album['title']);
			
			// Add array
			$arrLink = array(
				'id' => $objPage->id,
				'alias' => $objPage->alias
			);
			
			if(!empty($this->arrVars['pa2DetailPage']) && is_numeric($this->arrVars['pa2DetailPage']))
			{
				$objDetailPage = $this->getPageDetails($this->arrVars['pa2DetailPage']);
				
				$arrLink['id'] = $objDetailPage->id;
				$arrLink['alias'] = $objDetailPage->alias;
			}
			
			$objSubTemplate->title = $album['title'];
			$objSubTemplate->alias = $album['alias'];
			$objSubTemplate->showTitle = $this->arrVars['pa2ShowTitle'];
			$objSubTemplate->event = $album['event'];
			$objSubTemplate->place = $album['place'];
			$objSubTemplate->photographer = $album['photographer'];
			$objSubTemplate->description = $album['description'];
			$objSubTemplate->href = $this->generateFrontendUrl($arrLink, '/album/' . $album['alias']);
			
			// Check title
			if($objSubTemplate->title == '')
			{
				$objSubTemplate->showTitle = false;
			}
			
			// If album lightbox is activated the photos will be added to the album template
			$objSubTemplate = $this->albumLightbox($objSubTemplate, $album, $this->arrVars['pa2AlbumLightbox']);
			
			// Parse template
			$arrElements[] = $objSubTemplate->parse();
		}
		
		// Add items to template
		$objTemplate->items = $arrElements;
		
		return $objTemplate;
	}
	
	
	protected function albumLightbox($objTemplate, $album, $pa2AlbumLightbox)
	{
		$objTemplate->albumLightbox = $pa2AlbumLightbox;
		
		if($objTemplate->albumLightbox)
		{
			// Sort pictures
			$arrElements = ($album['pic_sort_check'] == 'pic_sort_wizard') ? $album['pic_sort'] : $this->sortElements($album['pictures'], $album['pic_sort_check']);
			
			$albumLightboxPictures = array();
			$i = 0;
			
			foreach($arrElements as $element)
			{
				if($i == 0)
				{
					$objTemplate->albumID = $album['id'];
					$objTemplate->href = str_replace(' ', '%20', $element);
					$objTemplate->lbvCheck = (version_compare(VERSION.'.'.BUILD, '2.11.0', '>='));
				}
				else
				{
					// Define image template
					$objImageTemplate = new FrontendTemplate('pa2_photo');
									
					// Set vars
					$objImageTemplate->albumID = $album['id'];
					$objImageTemplate->href = str_replace(' ', '%20', $element);
					$objImageTemplate->show = false;
					$objImageTemplate->lbvCheck = (version_compare(VERSION.'.'.BUILD, '2.11.0', '>='));
					
					// Add an image
					if ($element!='' && is_file(TL_ROOT . '/' . $element))
					{
						// Set image array
						$arrImage = array();
						$arrImage['size'] = serialize(array(0, 0, 'crop'));
						$arrImage['imagemargin'] = serialize(array('bottom'=>'', 'left'=>'', 'right'=>'', 'top'=>'', 'unit'=>''));
						$arrImage['singleSRC'] = 'system/modules/photoalbums2/html/blank.gif';
						$arrImage['alt'] = substr(strrchr($element, '/'), 1);
						
						$this->addImageToTemplate($objImageTemplate, $arrImage);
						
						// Add link title to template
						$objImageTemplate->title = substr(strrchr($element, '/'), 1);
					}
					
					// Add image template to parent template
					$albumLightboxPictures[] = $objImageTemplate->parse();
				}
				
				$i++;
			}
			
			$objTemplate->albumLightboxPictures = $albumLightboxPictures;
		}
		
		return $objTemplate;
	}
}

?>