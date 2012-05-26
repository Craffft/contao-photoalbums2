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
	function parseAlbums($objTemplate, $arrAlbums, $arrVars)
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
			$objSubTemplate = new FrontendTemplate($arrVars['strSubtemplate']);
			$objSubTemplate->setData($arrVars['arrData']);
			
			// Define perRow
			$objSubTemplate = $this->pa2PerRow($objSubTemplate, $total, $i, $arrVars['pa2PerRow']);
			
			// Define date
			$objSubTemplate = $this->pa2BuildDate($objSubTemplate, $album['startdate'], $album['enddate']);
			
			// Define metaFields
			$objSubTemplate = $this->pa2MetaFields($objSubTemplate, $arrVars['pa2MetaFields']);
			
			// Add an image
			if ($album['pic_preview']!='' && is_file(TL_ROOT . '/' . $album['pic_preview']))
			{
				$arrImage = array();
				$arrImage['size'] = $arrVars['pa2ImageSize'];
				$arrImage['imagemargin'] = $arrVars['pa2ImageMargin'];
				$arrImage['singleSRC'] = $album['pic_preview'];
				$arrImage['alt'] = strip_tags($album['title']);

				$this->addImageToTemplate($objSubTemplate, $arrImage);
			}
			
			// Add imgName to template
			$objSubTemplate->imgName = strip_tags($album['title']);
			
			// Add array
			$arrLink = array(
				'id' => $objPage->id,
				'alias' => $objPage->alias
			);
			
			if(!empty($arrVars['pa2DetailPage']) && is_numeric($arrVars['pa2DetailPage']))
			{
				$objDetailPage = $this->getPageDetails($arrVars['pa2DetailPage']);
				
				$arrLink['id'] = $objDetailPage->id;
				$arrLink['alias'] = $objDetailPage->alias;
			}
			
			$objSubTemplate->title = $album['title'];
			$objSubTemplate->alias = $album['alias'];
			$objSubTemplate->event = $album['event'];
			$objSubTemplate->place = $album['place'];
			$objSubTemplate->photographer = $album['photographer'];
			$objSubTemplate->description = $album['description'];
			$objSubTemplate->href = $this->generateFrontendUrl($arrLink, '/album/' . $album['alias']);
			
			// Parse template
			$arrElements[] = $objSubTemplate->parse();
		}
		
		// Add items to template
		$objTemplate->items = $arrElements;
		
		return $objTemplate;
	}
}

?>