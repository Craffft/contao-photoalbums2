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
 * Class Pa2TimeFilter
 *
 * @copyright  Daniel Kiesel 2012-2013
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class Pa2TimeFilter extends \Controller
{
	/**
	 * intFilterStart
	 *
	 * (default value: null)
	 *
	 * @var int
	 * @access private
	 */
	private $intFilterStart = null;


	/**
	 * intFilterEnd
	 *
	 * (default value: null)
	 *
	 * @var int
	 * @access private
	 */
	private $intFilterEnd = null;


	/**
	 * __construct function.
	 *
	 * @access public
	 * @param array $arrFilterStart
	 * @param array $arrFilterEnd
	 * @return void
	 */
	public function __construct($arrFilterStart, $arrFilterEnd)
	{
		if ($this->checkFilterVar($arrFilterStart) && $this->checkFilterVar($arrFilterEnd))
		{
			$this->setFilterTimestamp($arrFilterStart);
			$this->setFilterTimestamp($arrFilterEnd, true);
		}
	}


	/**
	 * checkFilterVar function.
	 *
	 * @access protected
	 * @param array $var
	 * @return bool
	 */
	protected function checkFilterVar($var)
	{
		if (is_array($var) && isset($var['unit']) && isset($var['value']) && is_numeric($var['value']))
		{
			return true;
		}

		return false;
	}


	/**
	 * setFilterTimestamp function.
	 *
	 * @access protected
	 * @param array $arrData
	 * @param bool $typeEnd (default: false)
	 * @return void
	 */
	protected function setFilterTimestamp($arrData, $typeEnd = false)
	{
		// If use vars are not setted
		if (!isset($arrData['unit']) || !isset($arrData['value']))
		{
			return null;
		}

		// Get date vars
		$day = date('j', time());
		$month = date('n', time());
		$year = date('Y', time());

		switch ($arrData['unit'])
		{
		case 'days':
			$intTs = mktime(0, 0, 0, $month, $day+($typeEnd ? 1 : 0)-$arrData['value'], $year);
			break;

		case 'weeks':
			$intTs = mktime(0, 0, 0, $month, $day+($typeEnd ? 7 : 0)-($arrData['value']*7)-(date('N', time())-1), $year);
			break;

		case 'months':
			$intTs = mktime(0, 0, 0, $month+($typeEnd ? 1 : 0)-$arrData['value'], 1, $year);
			break;

		case 'years':
			$intTs = mktime(0, 0, 0, 1, 1, $year+($typeEnd ? 1 : 0)-$arrData['value']);
			break;

		default:
			$intTs = null;
			break;
		}

		if ($typeEnd === true)
		{
			$this->intFilterEnd = $intTs;
		}
		else
		{
			$this->intFilterStart = $intTs;
		}
	}


	/**
	 * doFilter function.
	 *
	 * @access public
	 * @param int $dateStart
	 * @param int $dateEnd
	 * @return bool
	 */
	public function doFilter($dateStart, $dateEnd)
	{
		if (!(($this->intFilterStart <= $dateStart && $dateStart < $this->intFilterEnd) || ($this->intFilterStart <= $dateEnd && $dateEnd < $this->intFilterEnd)))
		{
			return true;
		}

		return false;
	}


	/**
	 * getFilterStart function.
	 *
	 * @access public
	 * @return int
	 */
	public function getFilterStart()
	{
		return $this->intFilterStart;
	}


	/**
	 * getFilterEnd function.
	 *
	 * @access public
	 * @return int
	 */
	public function getFilterEnd()
	{
		return $this->intFilterEnd;
	}
}
