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
 * Class Pa2Empty
 *
 * @copyright  Daniel Kiesel 2012 
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
	 * arrItems
	 * 
	 * @var array
	 * @access private
	 */
	private $arrItems;
	
	
	/**
	 * strMessage
	 * 
	 * @var string
	 * @access private
	 */
	private $strMessage;
	
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param array $arrItems
	 * @param string $strMessage
	 * @return void
	 */
	public function __construct($arrItems, $strMessage)
	{
		$this->arrItems = $arrItems;
		$this->strMessage = $strMessage;
	}
	
	
	/**
	 * run function.
	 * 
	 * @access public
	 * @return object
	 */
	public function run()
	{
		if(is_array($this->arrItems) && count($this->arrItems) > 0)
		{
			return null;
		}
		
		$this->Template = new \FrontendTemplate('mod_photoalbums2_empty');
		$this->Template->empty = $this->strMessage;
		
		return $this->Template;
	}
}
