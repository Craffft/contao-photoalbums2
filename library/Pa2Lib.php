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
 * Class Pa2Archive
 *
 * @copyright  Daniel Kiesel 2012-2014
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
	 * @access private
	 */
	private $arrItems = array();


	/**
	 * arrData
	 *
	 * (default value: array())
	 *
	 * @var array
	 * @access private
	 */
	private $arrData = array();


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
	 * __set function.
	 *
	 * @access public
	 * @param string $strKey
	 * @param mixed $varValue
	 * @return void
	 */
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'items':
				$this->arrItems = $varValue;
				break;

			default:
				$this->arrData[$strKey] = $varValue;
				break;
		}
	}


	/**
	 * __get function.
	 *
	 * @access public
	 * @param string $strKey
	 * @return mixed
	 */
	public function __get($strKey)
	{
		switch ($strKey)
		{
			case 'items':
				return $this->arrItems;
				break;
		}

		if (isset($this->arrData[$strKey]))
		{
			return $this->arrData[$strKey];
		}

		return null;
	}


	/**
	 * getData function.
	 *
	 * @access public
	 * @return array
	 */
	public function getData()
	{
		return $this->arrData;
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
