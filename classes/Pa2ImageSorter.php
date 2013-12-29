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
	 * @param array $arrIds
	 * @param array $arrCustomIds
	 * @return void
	 */
	public function __construct($strSortKey, $arrIds, $arrCustomIds)
	{
		if ($strSortKey == '')
		{
			return false;
		}

		if (!is_array($arrIds))
		{
			return false;
		}

		if (!is_array($arrCustomIds))
		{
			$arrCustomIds = $arrIds;
		}

		// Set vars
		$this->strSortKey = $strSortKey;
		$this->arrIds = $arrIds;
		$this->arrCustomIds = $arrCustomIds;
	}


	/**
	 * getSortedIds function.
	 *
	 * @access public
	 * @return array
	 */
	public function getSortedIds()
	{
		$arrIds = $this->arrIds;
		$strSortKey = $this->strSortKey;
		$strSortDirection = 'ASC';

		if (preg_match('#^([^_]*)_([a-zA-Z]{3,4})$#', $this->strSortKey, $arrMatches))
		{
			$strSortKey = $arrMatches[1];
			$strSortDirection = $arrMatches[2];
		}
		else if ($this->strSortKey == 'custom')
		{
			$arrIds = $this->arrCustomIds;
		}

		$objImageSorter = new \ImageSorter($arrIds);
		$objImageSorter->sortImagesBy($strSortKey, $strSortDirection);
		$arrIds = $objImageSorter->getImageIds();

		return $arrIds;
	}
}
