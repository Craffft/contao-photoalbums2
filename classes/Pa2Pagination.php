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
 * Class Pa2Pagination
 *
 * @copyright  Daniel Kiesel 2012-2013
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class Pa2Pagination extends \Controller
{
	/**
	 * arrItems
	 *
	 * (default value: array())
	 *
	 * @var array
	 * @access public
	 */
	public $arrItems = array();


	/**
	 * intMaxItems
	 *
	 * (default value: 0)
	 *
	 * @var int
	 * @access public
	 */
	public $intMaxItems = 0;


	/**
	 * intItemsPerPage
	 *
	 * (default value: 0)
	 *
	 * @var int
	 * @access public
	 */
	public $intItemsPerPage = 0;


	/**
	 * intTotalItems
	 *
	 * (default value: 0)
	 *
	 * @var int
	 * @access public
	 */
	public $intTotalItems = 0;


	/**
	 * varPagination
	 *
	 * (default value: '')
	 *
	 * @var string
	 * @access public
	 */
	public $varPagination = '';


	/**
	 * __construct function.
	 *
	 * @access public
	 * @param array $arrItems
	 * @param int $intMaxItems (default: 0)
	 * @param int $intItemsPerPage (default: 0)
	 * @return void
	 */
	public function __construct($arrItems, $intMaxItems = 0, $intItemsPerPage = 0)
	{
		if (!is_array($arrItems) || count($arrItems) < 1)
		{
			return false;
		}

		if (!is_numeric($intMaxItems))
		{
			return false;
		}

		if (!is_numeric($intItemsPerPage))
		{
			return false;
		}

		$intTotalItems = count($arrItems);

		$this->arrItems = $arrItems;
		$this->intMaxItems = $intMaxItems;
		$this->intItemsPerPage = $intItemsPerPage;
		$this->intTotalItems = $intTotalItems;
		$this->page = $this->Input->get('page') ? $this->Input->get('page') : 1;

		$this->compile();
	}


	/**
	 * compile function.
	 *
	 * @access protected
	 * @return void
	 */
	protected function compile()
	{
		// Maximum number of items
		if ($this->intMaxItems > 0)
		{
			$limit = $this->intMaxItems;
		}

		if ($this->intItemsPerPage > 0 && (!isset($limit) || $this->intMaxItems > $this->intItemsPerPage))
		{
			// Adjust the overall limit
			if (isset($limit))
			{
				$this->intTotalItems = min($limit, $this->intTotalItems);
			}

			// Check the maximum page number
			if ($this->page > ($this->intTotalItems/$this->intItemsPerPage))
			{
				$this->page = ceil($this->intTotalItems/$this->intItemsPerPage);
			}

			// Limit and offset
			$limit = $this->intItemsPerPage;
			$offset = (max($this->page, 1) - 1) * $this->intItemsPerPage;

			// Overall limit
			if ($offset + $limit > $this->intTotalItems)
			{
				$limit = $this->intTotalItems - $offset;
			}

			// Add the pagination menu
			$objPagination = new \Pagination($this->intTotalItems, $this->intItemsPerPage);
			$this->varPagination = $objPagination->generate("\n  ");

			// Filter albums by pagination
			$arrItemFilter = array();

			for ($i=$offset; ($offset+$limit) > $i; $i++)
			{
				$arrItemFilter[] = $this->arrItems[$i];
			}

			$this->arrItems = $arrItemFilter;
		}
	}


	/**
	 * getItems function.
	 *
	 * @access public
	 * @return array
	 */
	public function getItems()
	{
		return $this->arrItems;
	}


	/**
	 * getTotalItems function.
	 *
	 * @access public
	 * @return int
	 */
	public function getTotalItems()
	{
		return $this->intTotalItems;
	}


	/**
	 * getPagination function.
	 *
	 * @access public
	 * @return mixed
	 */
	public function getPagination()
	{
		return $this->varPagination;
	}
}
