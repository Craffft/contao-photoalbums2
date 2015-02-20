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
 * Class ContentPhotoalbums2
 *
 * @copyright  Daniel Kiesel 2012-2014
 * @author     Daniel Kiesel <daniel@craffft.de>
 * @package    photoalbums2
 */
class ContentPhotoalbums2 extends \ContentElement
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'pa2_wrap';

    /**
     * Subtemplate
     * @var string
     */
    protected $strSubtemplate = 'pa2_image';

    /**
     * generate function.
     *
     * @access public
     * @return void
     */
    public function generate()
    {
        // Set Pa2 Type
        $this->pa2type = 'CE';

        // Deserialize vars
        $this->groups = deserialize($this->groups);
        $this->pa2ImagesMetaFields = deserialize($this->pa2ImagesMetaFields);
        $this->pa2TimeFilterStart = deserialize($this->pa2TimeFilterStart);
        $this->pa2TimeFilterEnd = deserialize($this->pa2TimeFilterEnd);

        // Set true and false on checkboxes
        $this->pa2ImagesShowHeadline = ($this->pa2ImagesShowHeadline == 1) ? true : false;
        $this->pa2ImagesShowTitle = ($this->pa2ImagesShowTitle == 1) ? true : false;
        $this->pa2ImagesShowTeaser = ($this->pa2ImagesShowTeaser == 1) ? true : false;

        if (TL_MODE == 'BE') {
            $this->pa2ImagesShowHeadline = false;
            $this->pa2ImagesShowTitle = false;
            $this->pa2ImagesShowTeaser = false;
            $this->pa2ImagesPerRow = 1;
            $this->pa2ImagesPerPage = 0;
            $this->pa2NumberOfImages = 0;
            $this->pa2ImagesImageSize = serialize(array(50, 31, 'center_center'));
            $this->pa2ImagesImageMargin = serialize(array(
                'bottom' => 6,
                'left' => '',
                'right' => 6,
                'top' => '',
                'unit' => 'px',
            ));
        }

        return parent::generate();
    }

    /**
     * Generate the content element
     */
    protected function compile()
    {
        // Import CSS files
        $objPa2 = new \Pa2();
        $objPa2->addCssFile();

        // Import view parser
        $objImageViewParser = new \Pa2ImageViewParser($this->Template, $this->pa2Album);
        $this->Template = $objImageViewParser->getViewParserTemplate();
    }
}
