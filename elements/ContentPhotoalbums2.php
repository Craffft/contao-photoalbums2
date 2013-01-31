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
 * Class ContentPhotoalbums2
 *
 * @copyright  Daniel Kiesel 2012-2013
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class ContentPhotoalbums2 extends \ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'pa2_wrap';


	/**
	 * Subtemplate
	 * @var string
	 */
	protected $strSubtemplate = 'pa2_image';


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
		$this->pa2ImagesMetaFields = deserialize($this->pa2ImagesMetaFields);
		$this->pa2TimeFilterStart = deserialize($this->pa2TimeFilterStart);
		$this->pa2TimeFilterEnd = deserialize($this->pa2TimeFilterEnd);

		// Set true and false on checkboxes
		$this->pa2ImagesShowHeadline = ($this->pa2ImagesShowHeadline == 1) ? true : false;
		$this->pa2ImagesShowTitle = ($this->pa2ImagesShowTitle == 1) ? true : false;
		$this->pa2ImagesShowTeaser = ($this->pa2ImagesShowTeaser == 1) ? true : false;

		if (TL_MODE == 'BE')
		{
			$this->pa2ImagesShowHeadline = false;
			$this->pa2ImagesShowTitle = false;
			$this->pa2ImagesShowTeaser = false;
		}

		return parent::generate();
	}


	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		// Import CSS files
		$objPa2 = new \Pa2();
		$objPa2->addCssFile();

		// Import view parser
		$objImageViewParser = new \Pa2ImageViewParser($this->Template, $this->pa2Album);
		$this->Template = $objImageViewParser->getViewParserTemplate();
	}
}
