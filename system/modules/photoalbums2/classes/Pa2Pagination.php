<?php

/**
 * Extension for Contao Open Source CMS
 *
 * Copyright (c) 2012-2014 Daniel Kiesel
 *
 * @package Photoalbums2
 * @link    https://github.com/icodr8/contao-photoalbums
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Namespace
 */
namespace Photoalbums2;

/**
 * Class Pa2Pagination
 *
 * @copyright  Daniel Kiesel 2012-2014
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
     * @access private
     */
    private $arrItems = array();

    /**
     * intMaxItems
     *
     * (default value: 0)
     *
     * @var int
     * @access private
     */
    private $intMaxItems = 0;

    /**
     * intItemsPerPage
     *
     * (default value: 0)
     *
     * @var int
     * @access private
     */
    private $intItemsPerPage = 0;

    /**
     * intTotalItems
     *
     * (default value: 0)
     *
     * @var int
     * @access private
     */
    private $intTotalItems = 0;

    /**
     * varPagination
     *
     * (default value: '')
     *
     * @var string
     * @access private
     */
    private $varPagination = '';

    /**
     * __construct function.
     *
     * @access public
     * @param  array $arrItems
     * @param  int   $intMaxItems     (default: 0)
     * @param  int   $intItemsPerPage (default: 0)
     * @return void
     */
    public function __construct($arrItems, $intMaxItems = 0, $intItemsPerPage = 0)
    {
        if (!is_array($arrItems) || count($arrItems) < 1) {
            return false;
        }

        if (!is_numeric($intMaxItems)) {
            return false;
        }

        if (!is_numeric($intItemsPerPage)) {
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
        if ($this->intMaxItems > 0) {
            $limit = $this->intMaxItems;
        }

        if ($this->intItemsPerPage > 0 && (!isset($limit) || $this->intMaxItems > $this->intItemsPerPage)) {
            // Adjust the overall limit
            if (isset($limit)) {
                $this->intTotalItems = min($limit, $this->intTotalItems);
            }

            // Check the maximum page number
            if ($this->page > ($this->intTotalItems / $this->intItemsPerPage)) {
                $this->page = ceil($this->intTotalItems / $this->intItemsPerPage);
            }

            // Limit and offset
            $limit = $this->intItemsPerPage;
            $offset = (max($this->page, 1) - 1) * $this->intItemsPerPage;

            // Overall limit
            if ($offset + $limit > $this->intTotalItems) {
                $limit = $this->intTotalItems - $offset;
            }

            // Add the pagination menu
            $objPagination = new \Pagination($this->intTotalItems, $this->intItemsPerPage);
            $this->varPagination = $objPagination->generate("\n  ");

            // Filter albums by pagination
            $arrItemFilter = array();

            for ($i = $offset; ($offset + $limit) > $i; $i++) {
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
