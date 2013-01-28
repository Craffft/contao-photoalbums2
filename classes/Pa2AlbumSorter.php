<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2012 Leo Feyer
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
 * Class Pa2AlbumSorter
 *
 * @copyright  Daniel Kiesel 2012-2013
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class Pa2AlbumSorter extends \Controller
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
		$strSortKey = $this->strSortKey;
		$strSortDirection = 'ASC';

		if (preg_match('#^([^_]*)_([a-zA-Z]{3,4})$#', $this->strSortKey, $arrMatches))
		{
			$strSortKey = $arrMatches[1];
			$strSortDirection = $arrMatches[2];
		}

		$this->sortBy($strSortKey, $strSortDirection);

		return $this->arrIds;
	}


	/**
	 * sortBy function.
	 * 
	 * @access protected
	 * @param string $strSortKey
	 * @param string $strSortDirection (default: 'ASC')
	 * @return bool
	 */
	protected function sortBy($strSortKey, $strSortDirection = 'ASC')
	{
		if(!is_array($this->arrIds) || count($this->arrIds) < 1)
		{
			return false;
		}

		// Lower and uppercase for attributes
		$strSortKey = strtolower($strSortKey);
		$strSortDirection = strtoupper($strSortDirection);


		/**
		 * SET SORT FIELDS HERE
		 * 
		 * title
		 * startdate
		 * enddate
		 * random
		 * custom
		 */
		if($strSortKey == 'custom')
		{
			$arrIds = array();
			$arrIds = $this->arrCustomIds;

			// Remove all unnecessary ids which are not present in the variable arrIds
			$arrIds = array_intersect($arrIds, $this->arrIds);

			// Merge both arrays
			$arrIds = array_merge($arrIds, $this->arrIds);

			// Remove all duplicate ids which are present more than once
			$arrIds = array_unique($arrIds);

			// Set new arrIds
			$this->arrIds = $arrIds;
		}
		else if($strSortKey == 'random')
		{
			shuffle($this->arrIds);
		}
		else
		{
			$arrSort = array();

			foreach($this->arrIds as $intId)
			{
				$objPa2AlbumModel = \Photoalbums2\Photoalbums2AlbumModel::findByPk($intId);

				switch($strSortKey)
				{
					case 'title':
						$sortType = SORT_STRING;
						$title = '';

						if($objPa2AlbumModel->title != '')
						{
							$title = $objPa2AlbumModel->title;
						}

						$arrSort[$objPa2AlbumModel->id] = $title;
					break;

					case 'startdate':
						$sortType = SORT_NUMERIC;
						$title = '';

						if($objPa2AlbumModel->startdate != '')
						{
							$startdate = $objPa2AlbumModel->startdate;
						}

						$arrSort[$objPa2AlbumModel->id] = $startdate;
					break;

					case 'enddate':
						$sortType = SORT_NUMERIC;
						$title = '';

						if($objPa2AlbumModel->enddate != '')
						{
							$enddate = $objPa2AlbumModel->enddate;
						}

						$arrSort[$objPa2AlbumModel->id] = $enddate;
					break;

					case 'numberofimages':
						$sortType = SORT_NUMERIC;
						$numberofimages = '';

						if($objPa2AlbumModel->images != '')
						{
							$objPa2AlbumModel->images = deserialize($objPa2AlbumModel->images);
							
							if(is_array($objPa2AlbumModel->images))
							{
								$numberofimages = count($objPa2AlbumModel->images);
							}
						}

						$arrSort[$objPa2AlbumModel->id] = $numberofimages;
					break;
				}
			}

			asort($arrSort, $sortType);
			$this->arrIds = array_keys($arrSort);
		}

		if($strSortDirection == 'DESC')
		{
			$this->arrIds = array_reverse($this->arrIds);
		}

		return true;
	}
}
