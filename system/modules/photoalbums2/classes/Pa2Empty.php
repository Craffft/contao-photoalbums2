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
 * Class Pa2Empty
 *
 * @copyright  Daniel Kiesel 2012-2014
 * @author     Daniel Kiesel <daniel@craffft.de>
 * @package    photoalbums2
 */
class Pa2Empty extends \Controller
{
    /**
     * Template
     *
     * @var object
     * @access private
     */
    private $Template;

    /**
     * strMessage
     *
     * @var string
     * @access private
     */
    private $strMessage;

    /**
     * arrItems
     *
     * @var array
     * @access private
     */
    private $arrItems;

    /**
     * __construct function.
     *
     * @access public
     * @param  string $strMessage
     * @param  array  $arrItems
     * @return void
     */
    public function __construct($strMessage, $arrItems)
    {
        $this->strMessage = $strMessage;
        $this->arrItems = $arrItems;
    }

    /**
     * run function.
     *
     * @access public
     * @return object
     */
    public function run()
    {
        if (is_array($this->arrItems) && count($this->arrItems) > 0) {
            return null;
        }

        // Send a 404 header
        header('HTTP/1.1 404 Not Found');
        $this->Template = new \FrontendTemplate('pa2_empty');
        $this->Template->empty = $this->strMessage;

        return $this->Template;
    }
}
