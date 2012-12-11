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
 * Class ModulePhotoalbums2 
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 */
class ModulePhotoalbums2 extends \Module
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
	 * Elements
	 * @var array
	 */
	private $arrItems = array();


	/**
	 * Number of
	 * @var int
	 */
	private $intMaxItems;


	/**
	 * Per page
	 * @var int
	 */
	private $intItemsPerPage;


	/**
	 * Empty
	 * @var string
	 */
	private $empty = '';
	
	
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
			$objTemplate = new \BackendTemplate('be_wildcard');
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
		
		// Set true and false on checkboxes
		$this->pa2PhotosShowHeadline = ($this->pa2PhotosShowHeadline == 1) ? true : false;
		$this->pa2PhotosShowTitle = ($this->pa2PhotosShowTitle == 1) ? true : false;
		$this->pa2PhotosShowTeaser = ($this->pa2PhotosShowTeaser == 1) ? true : false;
		$this->pa2AlbumsShowHeadline = ($this->pa2AlbumsShowHeadline == 1) ? true : false;
		$this->pa2AlbumsShowTitle = ($this->pa2AlbumsShowTitle == 1) ? true : false;
		$this->pa2AlbumsShowTeaser = ($this->pa2AlbumsShowTeaser == 1) ? true : false;
		$this->pa2AlbumLightbox = ($this->pa2Mode == 'pa2_only_album_view') ? true : false;
		$this->pa2DetailPage = ($this->pa2Mode == 'pa2_with_detail_page') ? $this->pa2DetailPage : '';
		
		// Set the item from the auto_item parameter
		if ($GLOBALS['TL_CONFIG']['useAutoItem'] && isset($_GET['auto_item']))
		{
			$this->Input->setGet('album', $this->Input->get('auto_item'));
		}
		
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
		$objPa2 = new \Pa2New();
		
		// Add photoalbums2 css file
		$objPa2->addCssFile();
		
		// Show photos
		if($this->Input->get('album') && (($this->pa2DetailPage == '') || ($this->pa2DetailPage != '' && ($this->pa2DetailPage == $objPage->id || ($objPage->languageMain != '' && $objPage->languageMain == $this->pa2DetailPage)))))
		{
			$this->preparePhotos();
		}
		// Show albums
		else if(!$this->Input->get('album') && ($this->pa2DetailPage == '' || ($this->pa2DetailPage != '' && $this->pa2DetailPage != $objPage->id)))
		{
			$this->prepareAlbums();
		}
		// Go to detail page (photos)
		else if($this->Input->get('album'))
		{
			$this->goToDetailPage();
		}
		// Go to root page
		else
		{
			$this->goToRootPage();
		}
	}
	
	
	/**
	 * preparePhotos function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function preparePhotos()
	{
		$objPhotoViewParser = new \Pa2PhotoViewParser($this->Template);
		$this->Template = $objPhotoViewParser->getViewParserTemplate();
	}
	
	
	/**
	 * prepareAlbums function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function prepareAlbums()
	{
		$objAlbumViewParser = new \Pa2AlbumViewParser($this->Template);
		$this->Template = $objAlbumViewParser->getViewParserTemplate();
	}
	
	
	/**
	 * goToDetailPage function.
	 * 
	 * @access public
	 * @return void
	 */
	public function goToDetailPage()
	{
		// Get detail page informations
		$objDetailPage = $this->getPageDetails($this->pa2DetailPage);
		
		// Add array
		$arrDetailPage = array(
			'id' => $objDetailPage->id,
			'alias' => $objDetailPage->alias
		);
		
		$linkDetailPage = $this->generateFrontendUrl($arrDetailPage, sprintf(($GLOBALS['TL_CONFIG']['useAutoItem'] ?  '/%s' : '/album/%s'), $this->Input->get('album')), $objDetailPage->language);
		
		if(($this->Input->get('page') != '') && ($this->Input->get('page') != NULL) && is_numeric($this->Input->get('page')))
		{
			$linkDetailPage .= '?page=' . $this->Input->get('page');
		}
		
		// Locate to detail page
		$this->redirect($linkDetailPage);
	}
	
	
	/**
	 * goToRootPage function.
	 * 
	 * @access public
	 * @return void
	 */
	public function goToRootPage()
	{
		global $objPage;
		
		// Do not index or cache the page if no album has been specified
		$objPage->noSearch = 1;
		$objPage->cache = 0;
		
		// Get root page informations
		$objRootPage = $this->getPageDetails($objPage->rootId);
		
		// Add array
		$arrRootPage = array(
		    'id' => $objRootPage->id,
		    'alias' => $objRootPage->alias
		);
		
		$linkRootPage = $this->generateFrontendUrl($arrRootPage);
		
		// Locate to root page
		$this->redirect($linkRootPage);
	}
}
