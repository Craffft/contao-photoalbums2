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
 * Class Pa2ImageSorter
 *
 * @copyright  Daniel Kiesel 2012-2014
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class Pa2ImageSorter extends \Controller
{

	/**
	 * __construct function.
	 *
	 * @access public
	 * @param string $strSortKey
	 * @param array $arrUuids
	 * @param array $arrCustomUuids
	 * @return void
	 */
	public function __construct($strSortKey, $arrUuids, $arrCustomUuids)
	{
		if ($strSortKey == '')
		{
			return false;
		}

		if (!is_array($arrUuids))
		{
			return false;
		}

		if (!is_array($arrCustomUuids))
		{
			$arrCustomUuids = $arrUuids;
		}

		// Set vars
		$this->strSortKey = $strSortKey;
		$this->arrUuids = $arrUuids;
		$this->arrCustomIds = $arrCustomUuids;
	}


	/**
	 * getSortedUuids function.
	 *
	 * @access public
	 * @return array
	 */
	public function getSortedUuids()
	{
		$arrUuids = $this->arrUuids;
		$strSortKey = $this->strSortKey;
		$strSortDirection = 'ASC';

		if (preg_match('#^([^_]*)_([a-zA-Z]{3,4})$#', $this->strSortKey, $arrMatches))
		{
			$strSortKey = $arrMatches[1];
			$strSortDirection = $arrMatches[2];
		}
		else if ($this->strSortKey == 'custom')
		{
			$arrUuids = $this->arrCustomIds;
		}

		$objImageSorter = new \ImageSorter($arrUuids);
		$objImageSorter->sortImagesBy($strSortKey, $strSortDirection);
		$arrUuids = $objImageSorter->getImageUuids();

		return $arrUuids;
	}
}
