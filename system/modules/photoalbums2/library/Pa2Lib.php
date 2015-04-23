<?php

/**
 * Extension for Contao Open Source CMS
 *
 * Copyright (c) 2012-2014 Daniel Kiesel
 *
 * @package Photoalbums2
 * @link    https://github.com/craffft/contao-photoalbums
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Namespace
 */
namespace Photoalbums2;

/**
 * Class Pa2Archive
 *
 * @copyright  Daniel Kiesel 2012-2014
 * @author     Daniel Kiesel <daniel@craffft.de>
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
     * @param  mixed $varValue
     * @param  array $arrData
     * @return void
     */
    public function __construct($varValue, $arrData)
    {
        if (is_numeric($varValue)) {
            $this->arrItems = array($varValue);
        } elseif (is_array($varValue)) {
            $this->arrItems = $varValue;
        }

        if (is_array($arrData)) {
            $this->arrData = $arrData;
        }

        $this->sortOut();
    }

    /**
     * __set function.
     *
     * @access public
     * @param  string $strKey
     * @param  mixed  $varValue
     * @return void
     */
    public function __set($strKey, $varValue)
    {
        switch ($strKey) {
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
     * @param  string $strKey
     * @return mixed
     */
    public function __get($strKey)
    {
        switch ($strKey) {
            case 'items':
                return $this->arrItems;
                break;
        }

        if (isset($this->arrData[$strKey])) {
            return $this->arrData[$strKey];
        }

        return null;
    }

    /**
     * __isset function.
     *
     * @access public
     * @param  string $strKey
     * @return bool
     */
    public function __isset($strKey)
    {
        switch ($strKey) {
            case 'items':
                return isset($this->arrItems);
                break;

            default:
                return isset($this->arrData[$strKey]);
                break;
        }
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
