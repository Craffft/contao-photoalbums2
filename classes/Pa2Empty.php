<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2014 Leo Feyer
 *
 * @package    photoalbums2
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @license    LGPL
 * @copyright  Daniel Kiesel 2012-2014
 */


/**
 * Namespace
 */
namespace Photoalbums2;


/**
 * Class Pa2Empty
 *
 * @copyright  Daniel Kiesel 2012-2014
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class Pa2Empty extends \Controller
{

	/**
	 * Template
	 *
	 * @var object
	 * @access private
	 */
	private $Template;


	/**
	 * strMessage
	 *
	 * @var string
	 * @access private
	 */
	private $strMessage;


	/**
	 * arrItems
	 *
	 * @var array
	 * @access private
	 */
	private $arrItems;


	/**
	 * __construct function.
	 *
	 * @access public
	 * @param string $strMessage
	 * @param array $arrItems
	 * @return void
	 */
	public function __construct($strMessage, $arrItems)
	{
		$this->strMessage = $strMessage;
		$this->arrItems = $arrItems;
	}


	/**
	 * run function.
	 *
	 * @access public
	 * @return object
	 */
	public function run()
	{
		if (is_array($this->arrItems) && count($this->arrItems) > 0)
		{
			return null;
		}

		// Send a 404 header
		header('HTTP/1.1 404 Not Found');
		$this->Template = new \FrontendTemplate('pa2_empty');
		$this->Template->empty = $this->strMessage;

		return $this->Template;
	}
}
