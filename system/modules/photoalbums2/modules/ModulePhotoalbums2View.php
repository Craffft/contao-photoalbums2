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
 * Class ModulePhotoalbums2View
 *
 * @copyright  Daniel Kiesel 2012-2014
 * @author     Daniel Kiesel <daniel@craffft.de>
 * @package    photoalbums2
 */
class ModulePhotoalbums2View extends \ModulePhotoalbums2
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
    protected $strSubtemplate = 'pa2_album';

    /**
     * generate function.
     *
     * @access public
     * @return void
     */
    public function generate()
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### PHOTOALBUMS 2 VIEW MODULE ###';

            return $objTemplate->parse();
        }

        // Set Pa2 Type
        $this->pa2type = 'MOD_VIEW';

        // Set defaults
        $this->pa2DetailPage = '';

        return parent::generate();
    }

    /**
     * compile function.
     *
     * @access protected
     * @return void
     */
    protected function compile()
    {
        global $objPage;

        // Import CSS files
        $objPa2 = new \Pa2();
        $objPa2->addCssFile();

        // Show images
        if (\Input::get('album') && (($this->pa2DetailPage == '') || ($this->pa2DetailPage != '' && ($this->pa2DetailPage == $objPage->id || ($objPage->languageMain != '' && $objPage->languageMain == $this->pa2DetailPage))))) {
            $this->prepareImages();
        }
        // Go to overview page (albums)
        elseif (is_numeric($this->pa2OverviewPage) && $this->pa2OverviewPage > 0 && $objPage->id != $this->pa2OverviewPage) {
            $this->goToOverviewPage();
        }
        // Go to root page
        else {
            $this->goToRootPage();
        }
    }
}
