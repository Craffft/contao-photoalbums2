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
 * Class Pa2PhotoViewParser
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 */
class Pa2PhotoViewParser extends \Pa2ViewParser
{
	/**
	 * objAlbum
	 * 
	 * @var object
	 * @access private
	 */
	private $objAlbum;
	
	
	/**
	 * arrItems
	 * 
	 * @var array
	 * @access private
	 */
	private $arrItems = array();
	
	
	/**
	 * arrAllItems
	 * 
	 * @var array
	 * @access private
	 */
	private $arrAllItems = array();
	
	
	/**
	 * generate function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function generate()
	{
		$this->strEmptyText = $GLOBALS['TL_LANG']['MSC']['photosEmpty'];
		
		$this->Template->intMaxItems      = $this->Template->pa2NumberOfPhotos;
		$this->Template->intItemsPerPage  = $this->Template->pa2PhotosPerPage;
		$this->Template->intItemsPerRow   = $this->Template->pa2PhotosPerRow;
		$this->Template->strSubtemplate   = $this->Template->pa2PhotosTemplate;
		
		// Image params 
		$this->Template->size             = $this->Template->pa2PhotosImageSize;
		$this->Template->imagemargin      = $this->Template->pa2PhotosImageMargin;
		
		$this->Template->showHeadline     = $this->Template->pa2PhotosShowHeadline;
		$this->Template->showTitle  	  = $this->Template->pa2PhotosShowTitle;
		$this->Template->showTeaser       = $this->Template->pa2PhotosShowTeaser;
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
		// Get album id
		$objPa2Album = new \Pa2Album($this->Input->get('album'), $this->Template->getData());
		$objAlbum = $objPa2Album->getAlbums();
		$objAlbum = $objAlbum->current();
		
		// If there are no photos, show empty template with a message
		if(count($objAlbum->arrSortedPicIds) < 1)
		{
			$this->setEmptyTemplate();
			return;
		}
		
		// Add comments module
		$this->addComments($objAlbum);
		
		// Set arrItems and objAlbum
		$this->arrItems = $objAlbum->arrSortedPicIds;
		$this->objAlbum = $objAlbum;
		
		// Pagination
		$objPa2Pagination = new \Pa2Pagination($this->arrItems, $this->Template->intMaxItems, $this->Template->intItemsPerPage);
		$this->arrAllItems = $this->arrItems;
		$this->arrItems = $objPa2Pagination->getItems();
		$this->Template->pagination = $objPa2Pagination->getPagination();
		$this->Template->totalItems = $objPa2Pagination->getTotalItems();
		
		// Call parsePhotos
		$this->parsePhotos();
	}
	
	
	/**
	 * parsePhotos function.
	 * 
	 * @access private
	 * @return void
	 */
	private function parsePhotos()
	{
		if(!is_object($this->objAlbum) || !is_array($this->arrItems) || count($this->arrItems) < 1)
		{
			$this->setEmptyTemplate();
			return;
		}
		
		global $objPage;
		
		// Set album object
		$objAlbum = $this->objAlbum;
		
		// Add to template
		$this->Template->title           = strip_tags($objAlbum->title);
		$this->Template->alt             = strip_tags($objAlbum->title);
		$this->Template->showTitle       = ($this->Template->title != '' ? $this->Template->showTitle : false);
		$this->Template->cssClass       .= ($this->Template->cssClass == '') ? $objAlbum->cssClass : ' ' . $objAlbum->cssClass;
		$this->Template->event           = $objAlbum->event;
		$this->Template->place           = $objAlbum->place;
		$this->Template->photographer    = $objAlbum->photographer;
		$this->Template->description     = $objAlbum->description;
		
		// Call template methods
		$this->Template = $this->addDateToTemplate($this->Template, $objAlbum->startdate, $objAlbum->enddate);
		$this->Template = $this->addMetaFieldsToTemplate($this->Template);
		
		// Define useful vars
		$arrItems = array();
		$total = $this->Template->totalItems;
		$i = 0;
		$strIndividualId = $this->generateIndividualId();
		
		foreach($this->arrAllItems as $k => $v)
		{
			// Generate subtemplate object
			$objSubtemplate = new \FrontendTemplate($this->Template->strSubtemplate);
			$objSubtemplate->setData($this->Template->getData());
			
			// Get new object from Pa2Picture
			$objPa2Picture = new \Pa2Picture($v);
			$objPicture = $objPa2Picture->getPicture();
			
			// Show this image not in the photoalbum
			$objSubtemplate->title       = $objPicture->name;
			$objSubtemplate->alt         = $objPicture->name;
			$objSubtemplate->show        = false;
			$objSubtemplate->elementID   = $i;
			$objSubtemplate->albumID     = $objAlbum->id . '_' . $strIndividualId;
			$objSubtemplate->href        = str_replace(' ', '%20', $objPicture->path);
			
			// If show element
			if (in_array($v, $this->arrItems))
			{
				// Call template methods
				$objSubtemplate = $objPa2Picture->addPictureToTemplate($objSubtemplate);
				$objSubtemplate = $this->addClassesAndStyles($objSubtemplate, $total, $i);
				$objSubtemplate = $this->addSpecificClassesToTemplate($objSubtemplate, $i, 'detail');
				
				// Show this image in the photoalbum
				$objSubtemplate->show = true;
				
				$i++;
			}
			else
			{
				// Set image array
				$arrImage = array();
				$arrImage['size'] = serialize(array(0, 0, 'crop'));
				$arrImage['imagemargin'] = serialize(array('bottom'=>'', 'left'=>'', 'right'=>'', 'top'=>'', 'unit'=>''));
			    $arrImage['singleSRC'] = 'system/modules/photoalbums2/html/blank.gif';
				$arrImage['alt'] = substr(strrchr($element, '/'), 1);
				
				// Add picture to template
				$objSubtemplate = $objPa2Picture->addPictureToTemplate($objSubtemplate, $arrImage);
			}
			
			// Parse subtemplate
			$arrItems[] = $objSubtemplate->parse();
		}
		
		$this->Template->items = $arrItems;
	}
}
