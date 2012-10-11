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
 * Class Pa2Archive 
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 */
abstract class Pa2Lib extends \Controller
{
	/**
	 * arrItems
	 * 
	 * (default value: array())
	 * 
	 * @var array
	 * @access protected
	 */
	protected $arrItems = array();
	
	
	/**
	 * arrData
	 * 
	 * (default value: array())
	 * 
	 * @var array
	 * @access protected
	 */
	protected $arrData = array();
	
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param array or id $arrItems
	 * @return void
	 */
	public function __construct($arrItems, $arrData)
	{
		if(is_numeric($arrItems))
		{
			$this->arrItems = array($arrItems);
		}
		else if(is_array($arrItems))
		{
			$this->arrItems = $arrItems;
		}
		
		if(is_array($arrData))
		{
			$this->arrData = $arrData;
		}
		
		$this->sortOut();
	}
	
	
	/**
	 * sortOut function.
	 * 
	 * @access protected
	 * @abstract
	 * @return void
	 */
	abstract protected function sortOut();
}