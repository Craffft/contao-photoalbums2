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
 * Class ContentPhotoalbums2 
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 */
class ContentPhotoalbums2 extends \ContentElement
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
	protected $strSubtemplate = 'pa2_photo';
	
	
	/**
	 * generate function.
	 * 
	 * @access public
	 * @return void
	 */
	public function generate()
	{
		// Deserialize vars
		$this->groups = deserialize($this->groups);
		$this->pa2PhotosMetaFields = deserialize($this->pa2PhotosMetaFields);
		$this->pa2TimeFilterStart = deserialize($this->pa2TimeFilterStart);
		$this->pa2TimeFilterEnd = deserialize($this->pa2TimeFilterEnd);
		
		// Set true and false on checkboxes
		$this->pa2PhotosShowHeadline = ($this->pa2PhotosShowHeadline == 1) ? true : false;
		$this->pa2PhotosShowTitle = ($this->pa2PhotosShowTitle == 1) ? true : false;
		$this->pa2PhotosShowTeaser = ($this->pa2PhotosShowTeaser == 1) ? true : false;
		
		// Get unsorted pictures
		$this->import('PicSortWizard');
		$this->loadDataContainer('tl_photoalbums2_album');
		$this->pictures = $this->PicSortWizard->getUnsortedPictures($this->pictures, $GLOBALS['TL_DCA']['tl_photoalbums2_album']['fields']['pictures']['eval']['extensions']);
		
		return parent::generate();
	}


	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		global $objPage;
		
		$this->preparePhotos();
		
		// Add photoalbums2 css file
		$this->Pa2->addCssFile();
		
		// Add Subtemplate to Template
		$this->Template->strSubtemplate = $this->strSubtemplate;
		
		// Get albums
		$total = count($this->arrElements);
		
		// If albums empty
		if ($total < 1 || !$this->arrElements || $this->arrElements == false)
		{
			$this->strTemplate = 'mod_photoalbums2_empty';
			$this->Template = new FrontendTemplate($this->strTemplate);
			$this->Template->setData($this->arrData);
			$this->Template->empty = $this->empty;
			
			return;
		}
		
		// Pagination
		$arrPa2Pagination = $this->Pa2->pa2Pagination($this->arrElements, $this->pa2NumberOf, $this->pa2PerPage, $total);
		$this->arrElements = $arrPa2Pagination['elements'];
		$this->Template->pagination = $arrPa2Pagination['pagination'];
		
		// Add arrVars to Pa2
		$this->Pa2 = $this->addArrVars($this->Pa2);
		
		// Parse photos
		$this->Template = $this->Pa2->parsePhotos($this->Template, $this->arrPhotos, $this->arrElements);
	}
	
	
	/**
	 * preparePhotos function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function preparePhotos()
	{
		// Import Photoalbums2 class
		$this->import('Pa2Photos', 'Pa2');
		
		// Set Subtemplate
		$this->strSubtemplate = $this->pa2PhotosTemplate;
		
		// Add arrVars to Pa2
		$this->Pa2 = $this->addArrVars($this->Pa2);
		
		$this->pa2NumberOf = $this->pa2NumberOfPhotos;
		$this->pa2PerPage = $this->pa2PhotosPerPage;
		
		// Show all photos, if album is in BE shown
		if(TL_MODE == 'BE')
		{
			$this->pa2PerPage = 0;
		}
		
		$this->arrElements = $this->Pa2->getAlbum($this->pa2Album);
		
		$this->arrPhotos = $this->arrElements[0];
		
		$this->arrElements = ($this->arrElements[0]['pic_sort_check'] == 'pic_sort_wizard') ? $this->arrElements[0]['pic_sort'] : $this->Pa2->sortElements($this->arrElements[0]['pictures'], $this->arrElements[0]['pic_sort_check']);
		
		// Save referer from albums page
		if($this->Session->get('pa2_referer') == NULL)
		{
			$referer = $this->Session->get('referer');
			$this->Session->set('pa2_referer', $referer['current']);
		}
		
		$this->Template->referer = $this->Session->get('pa2_referer');
		
		// Empty text
		$this->empty = $GLOBALS['TL_LANG']['MSC']['photosEmpty'];
	}
	
	
	/**
	 * addArrVars function.
	 * 
	 * @access public
	 * @param obj $objPa2
	 * @return obj
	 */
	public function addArrVars($objPa2)
	{
		if(!is_object($objPa2))
		{
			return $objPa2;
		}
		
		// Define arrVars
		$arrVars = array(
			'id'				=> $this->id,
			'strSubtemplate'	=> $this->strSubtemplate,
			'arrData'			=> $this->arrData,
			'pa2Teaser'			=> $this->pa2Teaser
		);
		
		// Add to arrVars
		$arrVars['pa2MetaFields']		= $this->pa2PhotosMetaFields;
		$arrVars['pa2PerRow']			= $this->pa2PhotosPerRow;
		$arrVars['pa2PerPage']			= $this->pa2PhotosPerPage;
		$arrVars['pa2ImageSize']		= $this->pa2PhotosImageSize;
		$arrVars['pa2ImageMargin']		= $this->pa2PhotosImageMargin;
		$arrVars['pa2ShowHeadline']		= $this->pa2PhotosShowHeadline;
		$arrVars['pa2ShowTitle']		= $this->pa2PhotosShowTitle;
		$arrVars['pa2ShowTeaser']		= $this->pa2PhotosShowTeaser;
		
		// Add arrVars to Pa2
		$objPa2->addArrVars($arrVars);
		
		return $objPa2;
	}
}
