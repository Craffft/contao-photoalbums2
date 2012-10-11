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
		$this->Template->metaFields       = ((is_array($this->Template->pa2AlbumsMetaFields) && count($this->Template->pa2AlbumsMetaFields) > 0) ? $this->Template->pa2AlbumsMetaFields : false);
		
		$this->Template->showHeadline     = $this->Template->pa2AlbumsShowHeadline;
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
			
			$objSubtemplate = $this->addClassesAndStyles($objSubtemplate, $total, $i);
			$objSubtemplate = $this->buildDate($objSubtemplate, $objAlbums->startdate, $objAlbums->enddate);
			$objSubtemplate = $this->addSpecificClasses($objSubtemplate, $i, 'overview');
			
			dump($objAlbums->preview_pic);
			exit;
			
			
			$arrItems[] = $objSubTemplate->parse();
			
			$i++;
		}
		
		$objTemplate->items = $arrItems;
		
		/*
		foreach($arrAlbums as $i => $album)
		{
			// Add an image
			if ($album['preview_pic'] !== null && is_file(TL_ROOT . '/' . $album['preview_pic']->path))
			{
				$arrImage = array();
				$arrImage['size'] = $this->arrVars['pa2ImageSize'];
				$arrImage['imagemargin'] = $this->arrVars['pa2ImageMargin'];
				$arrImage['singleSRC'] = $album['preview_pic']->path;
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
				$arrLink['language'] = $objDetailPage->language;
			}
			
			$objSubTemplate->title = $album['title'];
			$objSubTemplate->alias = $album['alias'];
			$objSubTemplate->showTitle = $this->arrVars['pa2ShowTitle'];
			$objSubTemplate->event = $album['event'];
			$objSubTemplate->place = $album['place'];
			$objSubTemplate->photographer = $album['photographer'];
			$objSubTemplate->description = $album['description'];
			$objSubTemplate->href = $this->generateFrontendUrl($arrLink, sprintf(($GLOBALS['TL_CONFIG']['useAutoItem'] ?  '/%s' : '/album/%s'), $album['alias']), $objDetailPage->language);
			$objSubTemplate->class .= ($objSubTemplate->class == '') ? $album['cssClass'] : ' ' . $album['cssClass'];
			
			// Check title
			if($objSubTemplate->title == '')
			{
				$objSubTemplate->showTitle = false;
			}
			
			// If album lightbox is activated the photos will be added to the album template
			$objSubTemplate = $this->albumLightbox($objSubTemplate, $album, $this->arrVars['pa2AlbumLightbox']);
			
			// HOOK: pa2ParseAlbum callback
			if ($objSubTemplate instanceof FrontendTemplate && isset($GLOBALS['TL_HOOKS']['pa2ParseAlbum']) && is_array($GLOBALS['TL_HOOKS']['pa2ParseAlbum']))
			{
				foreach ($GLOBALS['TL_HOOKS']['pa2ParseAlbum'] as $callback)
				{
					$this->import($callback[0]);
					$objSubTemplate = $this->$callback[0]->$callback[1]($objSubTemplate, $this, $i);
				}
			}
			
			// Parse template
			$arrElements[] = $objSubTemplate->parse();
		}
		*/
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
