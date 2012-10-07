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
	 * generate function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function generate()
	{
		$this->strEmptyText = $GLOBALS['TL_LANG']['MSC']['albumsEmpty'];
		
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
		/*
		// Set Subtemplate
		$this->strSubtemplate = $this->pa2AlbumsTemplate;
		
		// Define vars
		$this->intMaxItems = $this->pa2NumberOfAlbums;
		$this->intItemsPerPage = $this->pa2AlbumsPerPage;
		
		// Sort out 
		$this->pa2Archives = $this->Pa2->sortOutElements($this->pa2Archives);
		$this->arrItems = $this->Pa2->getAlbums($this->pa2Archives);
		*/
		
		// GET ARCHIVES
		$objAlbums = \Photoalbums2AlbumModel::findAlbumsByMultipleArchives($this->Template->pa2Archives);
		$objAlbums = null;
		if($objAlbums === null)
		{
			$this->setEmptyTemplate();
			return;
		}
		
		// FILTER THEM
		// GET ALL ALBUMS
		// FILTER THEM TOO
		
		$arrItems = array(0, 1, 2, 3);
		
		
		
		dump($this->Template->pa2AlbumsTemplate);
		
		exit;
		
		
		// EMPTY
		// PAGINATION
		// PENIS
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
