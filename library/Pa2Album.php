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
 * Class Pa2Album
 *
 * @copyright  Daniel Kiesel 2012-2013
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class Pa2Album extends \Pa2Lib
{
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
		if (!is_array($varValue) && !is_numeric($varValue))
		{
			$varValue = $this->getIdByAlias($varValue);
		}

		parent::__construct($varValue, $arrData);
	}


	/**
	 * getIdByAlias function.
	 *
	 * @access protected
	 * @param string $strAlias
	 * @return string
	 */
	protected function getIdByAlias($strAlias)
	{
		$objAlbum = \Photoalbums2AlbumModel::findPublishedByIdOrAlias($strAlias);

		if ($objAlbum !== null)
		{
			if (is_numeric($objAlbum->id))
			{
				if ($objAlbum->id < 1)
				{
					return 0;
				}

				return $objAlbum->id;
			}
		}

		return $strAlias;
	}


	/**
	 * sortOut function.
	 *
	 * @access protected
	 * @return void
	 */
	protected function sortOut()
	{
		if (count($this->arrItems) > 0)
		{
			$this->import('FrontendUser', 'User');

			$objItems = \Photoalbums2AlbumModel::findMultipleByIds($this->arrItems);

			$arrItems = array();

			if($objItems !== null)
			{
				while ($objItems->next())
				{
					if(TL_MODE == 'FE')
					{
						// If not published
						if($objItems->published != 1)
						{
							continue;
						}
	
						// If has access
						if ($this->hasAccess($objItems->current()) === false)
						{
							continue;
						}
					}
	
					$arrItems[] = $objItems->id;
				}
			}

			$this->arrItems = $arrItems;
		}
	}


	protected function hasAccess($objItems)
	{
		if (!is_object($objItems))
		{
			return false;
		}

		// Check album access
		if ($objItems->protected)
		{
			if (!FE_USER_LOGGED_IN)
			{
				return false;
			}

			$arrUsers = deserialize($objItems->users);
			$arrGroups = deserialize($objItems->groups);

			// Check users and groups
			if ((!is_array($arrUsers) || count($arrUsers) < 1 || count(array_intersect($arrUsers, array($this->User->id))) < 1) && (!is_array($arrGroups) || count($arrGroups) < 1 || count(array_intersect($arrGroups, $this->User->groups)) < 1))
			{
				return false;
			}
		}

		// Check if user has no access to archive (parent)
		$objPa2Archive = new \Pa2Archive($objItems->pid, $this->arrData);
		$arrArchiveIds = $objPa2Archive->getArchiveIds();

		if (!is_array($arrArchiveIds) || count($arrArchiveIds) < 1 || !in_array($objItems->pid, $arrArchiveIds))
		{
			return false;
		}

		// Timefilter
		if ($this->arrData['pa2TimeFilter'])
		{
			$objTimeFilter = new Pa2TimeFilter($this->arrData['pa2TimeFilterStart'], $this->arrData['pa2TimeFilterEnd']);

			if ($objTimeFilter->doFilter($objItems->startdate, $objItems->enddate))
			{
				return false;
			}
		}

		return true;
	}


	/**
	 * getAlbumIds function.
	 *
	 * @access public
	 * @return array
	 */
	public function getAlbumIds()
	{
		return $this->arrItems;
	}


	/**
	 * getAlbums function.
	 *
	 * @access public
	 * @return object
	 */
	public function getAlbums()
	{
		if (count($this->arrItems) > 0)
		{
			$objAlbum = \Photoalbums2AlbumModel::findMultipleByIds($this->arrItems);

			if ($objAlbum !== null)
			{
				while ($objAlbum->next())
				{
					// Translate fields
					$objAlbum = \TranslationFields::translateDCObject($objAlbum);

					// Get preview image as Pa2Image object
					$objImage = new \Pa2Image($objAlbum->previewImage);
					$objAlbum->objPreviewImage = $objImage->getPa2Image();

					// Deserialize arrays
					$objAlbum->images = deserialize($objAlbum->images);
					$objAlbum->imageSort = deserialize($objAlbum->imageSort);

					// Set sortedImageIds
					$objPa2ImageSorter = new \Pa2ImageSorter($objAlbum->imageSortType, $objAlbum->images, $objAlbum->imageSort);
					$objAlbum->arrSortedImageIds = $objPa2ImageSorter->getSortedIds();
				}

				$objAlbum->reset();
			}

			return $objAlbum;
		}

		return null;
	}
}
