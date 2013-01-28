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
 * Class Pa2Archive
 *
 * @copyright  Daniel Kiesel 2012-2013
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
	 * @param mixed $varValue
	 * @param array $arrData
	 * @return void
	 */
	public function __construct($varValue, $arrData)
	{
		if (is_numeric($varValue))
		{
			$this->arrItems = array($varValue);
		}
		else if (is_array($varValue))
		{
			$this->arrItems = $varValue;
		}

		if (is_array($arrData))
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
