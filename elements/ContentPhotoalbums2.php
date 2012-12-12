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
		
		return parent::generate();
	}


	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		$objPhotoViewParser = new \Pa2PhotoViewParser($this->Template, $this->pa2Album);
		$this->Template = $objPhotoViewParser->getViewParserTemplate();
	}
}
