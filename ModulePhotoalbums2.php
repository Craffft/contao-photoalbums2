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
		
		// Check for detail view
		if ($this->Input->get('items'))
		{
			// Import Photoalbums2 class
			$this->import('Pa2Photos', 'Pa2');
			
			// Set Subtemplate
			$this->strSubtemplate = $this->pa2PhotosTemplate;
			
			$pa2NumberOf = $this->pa2NumberOfPhotos;
			$pa2PerPage = $this->pa2PhotosPerPage;
			$arrElements = $this->Pa2->getAlbum($this->Input->get('items'));
			$arrPhotos = $arrElements[0];
			
			$arrElements = ($arrElements[0]['pic_sort_check'] == 'pic_sort_wizard') ? $arrElements[0]['pic_sort'] : $this->Pa2->sortElements($arrElements[0]['pictures'], $arrElements[0]['pic_sort_check']);
			
			// Go back
			$this->Template->referer = $this->generateFrontendUrl(array('id'=>$objPage->id, 'alias'=>$objPage->alias));
			$this->Template->back = $GLOBALS['TL_LANG']['MSC']['goBack'];
			
			// Empty text
			$empty = $GLOBALS['TL_LANG']['MSC']['photosEmpty'];
		}
		else
		{
			// Import Photoalbums2 class
			$this->import('Pa2Albums', 'Pa2');
			
			// Set Subtemplate
			$this->strSubtemplate = $this->pa2AlbumsTemplate;
			
			// Define vars
			$pa2NumberOf = $this->pa2NumberOfAlbums;
			$pa2PerPage = $this->pa2AlbumsPerPage;
			
			// Sort out 
			$this->pa2Archives = $this->Pa2->sortOutElements($this->pa2Archives);
			$arrElements = $this->Pa2->getAlbums($this->pa2Archives);
			
			// Empty text
			$empty = $GLOBALS['TL_LANG']['MSC']['albumsEmpty'];
		}
		
		// Add photoalbums2 css file
		$this->Pa2->addCssFile();
		
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
		$arrPa2Pagination = $this->Pa2->pa2Pagination($arrElements, $pa2NumberOf, $pa2PerPage, $total);
		$arrElements = $arrPa2Pagination['elements'];
		$this->Template->pagination = $arrPa2Pagination['pagination'];
		
		// Define arrVars
		$arrVars = array(
			'id'				=> $this->id,
			'strSubtemplate'	=> $this->strSubtemplate,
			'arrData'			=> $this->arrData
		);
		
		// Check for detail view
		if ($this->Input->get('items'))
		{
			// Add to arrVars
			$arrVars['pa2MetaFields']	= $this->pa2PhotosMetaFields;
			$arrVars['pa2PerRow']		= $this->pa2PhotosPerRow;
			$arrVars['pa2ImageSize']	= $this->pa2PhotosImageSize;
			$arrVars['pa2ImageMargin']	= $this->pa2PhotosImageMargin;
			
			// Parse photos
			$this->Template = $this->Pa2->parsePhotos($this->Template, $arrPhotos, $arrElements, $arrVars);
		}
		else
		{
			// Add to arrVars
			$arrVars['pa2MetaFields']	= $this->pa2AlbumsMetaFields;
			$arrVars['pa2PerRow']		= $this->pa2AlbumsPerRow;
			$arrVars['pa2ImageSize']	= $this->pa2AlbumsImageSize;
			$arrVars['pa2ImageMargin']	= $this->pa2AlbumsImageMargin;
			
			// Parse albums
			$this->Template = $this->Pa2->parseAlbums($this->Template, $arrElements, $arrVars);
		}
		
		// Set Template vars
		$this->items = $this->Template->items;
	}
}

?>