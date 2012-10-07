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
 * Class Pa2ViewParser
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 */
abstract class Pa2ViewParser extends \Frontend
{
	/**
	 * Template
	 * 
	 * @var mixed
	 * @access protected
	 */
	protected $Template;
	
	
	/**
	 * strEmptyText
	 * 
	 * (default value: '')
	 * 
	 * @var string
	 * @access protected
	 */
	protected $strEmptyText = '';
	
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param object $objTemplate
	 * @return void
	 */
	public function __construct($objTemplate)
	{
		if(!is_object($objTemplate) || !$objTemplate instanceof \Template)
		{
			return false;
		}
		
		$this->Template = $objTemplate;
		
		$this->generate();
		$this->compile();
	}
	
	
	/**
	 * generate function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function generate()
	{
		// Do nothing
	}
	
	
	/**
	 * compile function.
	 * 
	 * @access protected
	 * @abstract
	 * @return void
	 */
	abstract protected function compile();
	
	
	/**
	 * setEmptyTemplate function.
	 * 
	 * @access protected
	 * @param array $arrItems (default: array())
	 * @return void
	 */
	protected function setEmptyTemplate($arrItems = array())
	{
		// If required set empty template
		$objPa2Empty = new \Pa2Empty($arrItems, $this->strEmptyText);
		
		if($objPa2Empty->run() !== null)
		{
			$this->Template = $objPa2Empty->run();
		}
	}
}
