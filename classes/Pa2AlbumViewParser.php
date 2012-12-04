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
 * Class Pa2AlbumViewParser
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 */
class Pa2AlbumViewParser extends \Pa2ViewParser
{
	/**
	 * objAlbums
	 * 
	 * @var object
	 * @access protected
	 */
	protected $objAlbums;
	
	
	/**
	 * generate function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function generate()
	{
		$this->strEmptyText = $GLOBALS['TL_LANG']['MSC']['albumsEmpty'];
		
		$this->Template->intMaxItems      = $this->Template->pa2NumberOfAlbums;
		$this->Template->intItemsPerPage  = $this->Template->pa2AlbumsPerPage;
		$this->Template->intItemsPerRow   = $this->Template->pa2AlbumsPerRow;
		$this->Template->strSubtemplate   = $this->Template->pa2AlbumsTemplate;
		$this->Template->intDetailPage    = $this->Template->pa2DetailPage;
		
		// Image params 
		$this->Template->size             = $this->Template->pa2AlbumsImageSize;
		$this->Template->imagemargin      = $this->Template->pa2AlbumsImageMargin;
		
		$this->Template->metaFields       = ((is_array($this->Template->pa2AlbumsMetaFields) && count($this->Template->pa2AlbumsMetaFields) > 0) ? $this->Template->pa2AlbumsMetaFields : false);
		
		$this->Template->showHeadline     = $this->Template->pa2AlbumsShowHeadline;
		$this->Template->showTitle  	  = $this->Template->pa2AlbumsShowTitle;
		$this->Template->showTeaser       = $this->Template->pa2AlbumsShowTeaser;
		$this->Template->teaser           = $this->cleanRteOutput($this->Template->pa2Teaser);
		$this->Template->showHeadline     = ($this->Template->headline != '' ? $this->Template->showHeadline : false);
		$this->Template->showTeaser       = ($this->Template->teaser != '' ? $this->Template->showTeaser : false);
		
		parent::generate();
	}
	
	
	/**
	 * compile function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function compile()
	{
		$objPa2Archive = new \Pa2Archive($this->Template->pa2Archives, $this->Template->getData());
		$arrAlbums = $objPa2Archive->getAlbumIds();
		
		// If there are no albums, show empty template with a message
		if(count($arrAlbums) < 1)
		{
			$this->setEmptyTemplate();
			return;
		}
		
		// Set the pagination
		$objPa2Pagination = new \Pa2Pagination($arrAlbums, $this->Template->intMaxItems, $this->Template->intItemsPerPage);
		$arrAlbums = $objPa2Pagination->getItems();
		$this->Template->pagination = $objPa2Pagination->getPagination();
		$this->Template->totalItems = $objPa2Pagination->getTotalItems();
		
		// Get albums of this page as object
		$objPa2Album = new \Pa2Album($arrAlbums, $this->Template->getData());
		
		$this->objAlbums = $objPa2Album->getAlbums();
		
		$this->parseAlbums();
	}
	
	
	protected function parseAlbums()
	{
		if(!is_object($this->objAlbums) || $this->objAlbums->count() < 1)
		{
			$this->setEmptyTemplate();
			return;
		}
		
		$arrItems = array();
		$objAlbums = $this->objAlbums;
		$total = $objAlbums->count();
		$i = 0;
		
		while($objAlbums->next())
		{
			// Generate subtemplate object
			$objSubtemplate = new \FrontendTemplate($this->Template->strSubtemplate);
			$objSubtemplate->setData($this->Template->getData());
			
			// Set template variables
			$objSubtemplate->title        = strip_tags($objAlbums->title);
			$objSubtemplate->alt          = strip_tags($objAlbums->title);
			$objSubtemplate->showTitle    = ($objSubtemplate->title != '' ? $objSubtemplate->showTitle : false);
			$objSubtemplate->event        = $objAlbums->event;
			$objSubtemplate->place        = $objAlbums->place;
			$objSubtemplate->photographer = $objAlbums->photographer;
			$objSubtemplate->description  = $objAlbums->description;
			
			// Call template methods
			$objSubtemplate = $this->addClassesAndStyles($objSubtemplate, $total, $i);
			$objSubtemplate = $this->buildDate($objSubtemplate, $objAlbums->startdate, $objAlbums->enddate);
			$objSubtemplate = $this->addSpecificClasses($objSubtemplate, $i, 'overview');
			$objSubtemplate = $this->addLinkToTemplate($objSubtemplate);
			
			// Add preview pic to template
			$objPa2PreviewPic = new \Pa2PreviewPic($objAlbums->current(), $objSubtemplate->pa2PreviewPic);
			$objPa2Picture = new \Pa2Picture($objPa2PreviewPic->getPreviewPicId());
			$objPa2Picture->addPictureToTemplate($objSubtemplate);
			
			// Add album class to the class string
			$objSubtemplate->class .= ($objSubtemplate->class == '') ? $objAlbums->cssClass : ' ' . $objAlbums->cssClass;
			
			// If album lightbox is activated the photos will be added to the album template
			$objSubtemplate = $this->albumLightbox($objSubtemplate, $objAlbums);
			
			$arrItems[] = $objSubtemplate->parse();
			
			$i++;
		}
		
		$this->Template->items = $arrItems;
	}
	
	
	/**
	 * pa2AlbumLightbox function.
	 * 
	 * @access protected
	 * @param object $objTemplate
	 * @param object $objAlbum
	 * @return object
	 */
	protected function albumLightbox($objTemplate, $objAlbum)
	{
		return $objTemplate;
	}
	
	
	/**
	 * getAlbumTemplate function.
	 * 
	 * @access public
	 * @return object
	 */
	public function getAlbumTemplate()
	{
		return $this->Template;
	}
}
