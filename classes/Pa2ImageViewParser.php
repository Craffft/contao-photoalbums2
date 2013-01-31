<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @package   photoalbums2
 * @author    Daniel Kiesel <https://github.com/icodr8>
 * @license   LGPL
 * @copyright Daniel Kiesel 2012-2013
 */


/**
 * Namespace
 */
namespace Photoalbums2;

/**
 * Class Pa2ImageViewParser
 *
 * @copyright  Daniel Kiesel 2012-2013
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class Pa2ImageViewParser extends \Pa2ViewParser
{
	/**
	 * intAlbumId
	 *
	 * @var mixed
	 * @access private
	 */
	private $intAlbumId;


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
	 * __construct function.
	 *
	 * @access public
	 * @param object $objTemplate
	 * @param int $intAlbumId
	 * @return void
	 */
	public function __construct($objTemplate, $intAlbumId = 0)
	{
		if (is_numeric($intAlbumId) && $intAlbumId > 0)
		{
			$this->intAlbumId = $intAlbumId;
		}

		parent::__construct($objTemplate);
	}


	/**
	 * generate function.
	 *
	 * @access protected
	 * @return void
	 */
	protected function generate()
	{
		$this->strEmptyText = $GLOBALS['TL_LANG']['MSC']['imagesEmpty'];

		$this->Template->intMaxItems            = $this->Template->pa2NumberOfImages;
		$this->Template->intItemsPerPage        = $this->Template->pa2ImagesPerPage;
		$this->Template->intItemsPerRow         = $this->Template->pa2ImagesPerRow;
		$this->Template->strTemplate            = ($this->Template->pa2ImageViewTemplate != '' ? $this->Template->pa2ImageViewTemplate : $this->Template->strTemplate);
		$this->Template->strSubtemplate         = ($this->Template->pa2ImagesTemplate != '' ? $this->Template->pa2ImagesTemplate : $this->Template->strSubtemplate);
		$this->Template->showMetaDescriptions   = $this->Template->pa2ImagesShowMetaDescriptions;
		$this->Template->arrMetaFields          = $this->Template->pa2ImagesMetaFields;

		// Image params
		$this->Template->size                   = $this->Template->pa2ImagesImageSize;
		$this->Template->imagemargin            = $this->Template->pa2ImagesImageMargin;

		$this->Template->showHeadline           = $this->Template->pa2ImagesShowHeadline;
		$this->Template->showTitle              = $this->Template->pa2ImagesShowTitle;
		$this->Template->showTeaser             = $this->Template->pa2ImagesShowTeaser;
		$this->Template->teaser                 = $this->cleanRteOutput($this->Template->pa2Teaser);
		$this->Template->showHeadline           = ($this->Template->headline != '' ? $this->Template->showHeadline : false);
		$this->Template->showTeaser             = ($this->Template->teaser != '' ? $this->Template->showTeaser : false);

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
		// Generate new template object
		$objTemplate = new \FrontendTemplate($this->Template->strTemplate);
		$objTemplate->setData($this->Template->getData());
		$this->Template = $objTemplate;

		// Get album id
		$objPa2Album = new \Pa2Album($this->getAlbumIdOrAlias(), $this->Template->getData());
		$objAlbum = $objPa2Album->getAlbums();

		// If there are no album or images, show empty template with a message
		if (!is_object($objAlbum) || $objAlbum === null || count($objAlbum->arrSortedImageIds) < 1)
		{
			$this->setEmptyTemplate();
			return;
		}

		// Get only the current object
		$objAlbum = $objAlbum->current();

		// Add comments module in Frontend
		if (TL_MODE == 'FE')
		{
			$this->addComments($objAlbum);
		}

		// Set arrItems and objAlbum
		$this->arrItems = $objAlbum->arrSortedImageIds;
		$this->objAlbum = $objAlbum;

		// Pagination
		$objPa2Pagination = new \Pa2Pagination($this->arrItems, $this->Template->intMaxItems, $this->Template->intItemsPerPage);
		$this->arrAllItems = $this->arrItems;
		$this->arrItems = $objPa2Pagination->getItems();
		$this->Template->pagination = $objPa2Pagination->getPagination();
		$this->Template->totalItems = $objPa2Pagination->getTotalItems();

		// Call parseImages
		$this->parseImages();
	}


	/**
	 * getAlbumIdOrAlias function.
	 *
	 * @access protected
	 * @return mixed
	 */
	protected function getAlbumIdOrAlias()
	{
		$varValue = $this->intAlbumId;

		if (!is_numeric($varValue) || $varValue < 1)
		{
			$varValue = $this->Input->get('album');
		}

		return $varValue;
	}


	/**
	 * parseImages function.
	 *
	 * @access private
	 * @return void
	 */
	private function parseImages()
	{
		if (!is_object($this->objAlbum) || !is_array($this->arrItems) || count($this->arrItems) < 1)
		{
			$this->setEmptyTemplate();
			return;
		}

		global $objPage;

		// Set album object
		$objAlbum = $this->objAlbum;

		// Add to template
		$this->Template->title              = strip_tags($objAlbum->title);
		$this->Template->alt                = strip_tags($objAlbum->title);
		$this->Template->showTitle          = ($this->Template->title != '' ? $this->Template->showTitle : false);
		$this->Template->cssClass          .= ($this->Template->cssClass == '') ? $objAlbum->cssClass : ' ' . $objAlbum->cssClass;
		$this->Template->event              = $objAlbum->event;
		$this->Template->place              = $objAlbum->place;
		$this->Template->photographer       = $objAlbum->photographer;
		$this->Template->description        = $objAlbum->description;
		$this->Template->numberOfAllImages  = count($objAlbum->images);
		
		// Generate the backlink
		$this->generateBacklink();

		// Call template methods
		$this->Template = $this->addDateToTemplate($this->Template, $objAlbum->startdate, $objAlbum->enddate);
		$this->Template = $this->addMetaFieldsToTemplate($this->Template);

		// Define useful vars
		$arrItems = array();
		$total = $this->Template->totalItems;
		$i = 0;
		$strIndividualId = $this->generateIndividualId();

		foreach ($this->arrAllItems as $k => $v)
		{
			// Generate subtemplate object
			$objSubtemplate = new \FrontendTemplate($this->Template->strSubtemplate);
			$objSubtemplate->setData($this->Template->getData());

			// Get new object from Pa2Image
			$objPa2Image = new \Pa2Image($v);
			$objImage = $objPa2Image->getPa2Image();

			// Show this image not in the album
			$objSubtemplate->title       = $objImage->name;
			$objSubtemplate->alt         = $objImage->name;
			$objSubtemplate->show        = false;
			$objSubtemplate->elementID   = $i;
			$objSubtemplate->albumID     = $objAlbum->id . '_' . $strIndividualId;
			$objSubtemplate->href        = str_replace(' ', '%20', $objImage->path);

			// If show element
			if (in_array($v, $this->arrItems))
			{
				// Set arrImage if is not set or no array
				if (!is_array($objSubtemplate->arrImage))
				{
					$objSubtemplate->arrImage = array();
				}

				// Call template methods
				$objSubtemplate = $objPa2Image->addPa2ImageToTemplate($objSubtemplate, $objSubtemplate->arrImage);
				$objSubtemplate = $this->addSpecificClassesToTemplate($objSubtemplate, $i);

				// Show this image in the album
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

				// Add image to template
				$objSubtemplate = $objPa2Image->addPa2ImageToTemplate($objSubtemplate, $arrImage);
			}

			// Parse subtemplate
			$arrItems[] = $objSubtemplate->parse();
		}

		$this->Template->items = $arrItems;
	}


	/**
	 * generateBacklink function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function generateBacklink()
	{
		if(TL_MODE != 'FE')
		{
			return;
		}
		
		global $objPage;

		// Import
		$this->Import('Session');

		// Get session vars
		$intPageNumber = $this->Session->get('pa2PageNumber_' . $this->Template->id);
		$intPageId     = $this->Session->get('pa2PageId_' . $this->Template->id);

		// Check and correct session vars
		$intPageNumber = (is_numeric($intPageNumber) ? $intPageNumber : 1);
		$intPageId     = (is_numeric($intPageId) ? $intPageId : $objPage->id);

		// Get page object by id
		$objPage = \PageModel::findByPk($intPageId);
		$objPageDetails = $this->getPageDetails($objPage->id);

		// Set template vars
		$this->Template->referer = $this->generateFrontendUrl($objPage->row(), '', $objPageDetails->language) . ($intPageNumber > 1 ? '?page=' . $intPageNumber : '');
		$this->Template->back    = $GLOBALS['TL_LANG']['MSC']['goBack'];
	}
}
