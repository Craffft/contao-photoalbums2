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
 * Class ModulePhotoalbums2
 *
 * @copyright  Daniel Kiesel 2012-2014
 * @author     Daniel Kiesel <daniel@craffft.de>
 * @package    photoalbums2
 */
class ModulePhotoalbums2 extends \Module
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
     * Elements
     * @var array
     */
    private $arrItems = array();

    /**
     * Number of
     * @var int
     */
    private $intMaxItems;

    /**
     * Per page
     * @var int
     */
    private $intItemsPerPage;

    /**
     * Empty
     * @var string
     */
    private $empty = '';

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
            $objTemplate->wildcard = '### PHOTOALBUMS 2 MODULE ###';

            return $objTemplate->parse();
        }

        // Set Pa2 Type
        $this->pa2type = 'MOD';

        // Deserialize vars
        $this->groups = deserialize($this->groups);
        $this->pa2Archives = deserialize($this->pa2Archives);
        $this->pa2AlbumSort = deserialize($this->pa2AlbumSort);
        $this->pa2AlbumsMetaFields = deserialize($this->pa2AlbumsMetaFields);
        $this->pa2ImagesMetaFields = deserialize($this->pa2ImagesMetaFields);
        $this->pa2TimeFilterStart = deserialize($this->pa2TimeFilterStart);
        $this->pa2TimeFilterEnd = deserialize($this->pa2TimeFilterEnd);

        // Set true and false on checkboxes
        $this->pa2ImagesShowHeadline = ($this->pa2ImagesShowHeadline == 1) ? true : false;
        $this->pa2ImagesShowTitle = ($this->pa2ImagesShowTitle == 1) ? true : false;
        $this->pa2ImagesShowTeaser = ($this->pa2ImagesShowTeaser == 1) ? true : false;
        $this->pa2AlbumsShowHeadline = ($this->pa2AlbumsShowHeadline == 1) ? true : false;
        $this->pa2AlbumsShowTitle = ($this->pa2AlbumsShowTitle == 1) ? true : false;
        $this->pa2AlbumsShowTeaser = ($this->pa2AlbumsShowTeaser == 1) ? true : false;
        $this->pa2AlbumLightbox = ($this->pa2Mode == 'pa2_only_album_view') ? true : false;
        $this->pa2DetailPage = ($this->pa2Mode == 'pa2_with_detail_page') ? $this->pa2DetailPage : '';

        // Set the item from the auto_item parameter
        if ($GLOBALS['TL_CONFIG']['useAutoItem'] && isset($_GET['auto_item'])) {
            \Input::setGet('album', \Input::get('auto_item'));
        }

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
        // Show albums
        elseif (!\Input::get('album') && ($this->pa2DetailPage == '' || ($this->pa2DetailPage != '' && $this->pa2DetailPage != $objPage->id))) {
            $this->prepareAlbums();
        }
        // Go to detail page (images)
        elseif (\Input::get('album')) {
            $this->goToDetailPage();
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

    /**
     * prepareImages function.
     *
     * @access protected
     * @return void
     */
    protected function prepareImages()
    {
        $objImageViewParser = new \Pa2ImageViewParser($this->Template);
        $this->Template = $objImageViewParser->getViewParserTemplate();
    }

    /**
     * prepareAlbums function.
     *
     * @access protected
     * @return void
     */
    protected function prepareAlbums()
    {
        $objAlbumViewParser = new \Pa2AlbumViewParser($this->Template);
        $this->Template = $objAlbumViewParser->getViewParserTemplate();
    }

    /**
     * goToDetailPage function.
     *
     * @access public
     * @return void
     */
    public function goToDetailPage()
    {
        global $objPage;

        // Do not redirect if current and redirect page are the same
        if ($objPage->id == $this->pa2DetailPage) {
            return;
        }

        // Get detail page and redirect url
        $objDetailPage = $this->getPageDetails($this->pa2DetailPage);
        $strUrl = $this->generateFrontendUrl($objDetailPage->row(), sprintf(($GLOBALS['TL_CONFIG']['useAutoItem'] ?  '/%s' : '/album/%s'), \Input::get('album')), $objDetailPage->language);

        if ((\Input::get('page') != '') && (\Input::get('page') != NULL) && is_numeric(\Input::get('page'))) {
            $strUrl .= '?page='.\Input::get('page');
        }

        // Redirect to detail page
        $this->redirect($strUrl);
    }

    /**
     * goToOverviewPage function.
     *
     * @access public
     * @return void
     */
    public function goToOverviewPage()
    {
        global $objPage;

        // Do not redirect if current and redirect page are the same
        if ($objPage->id == $this->pa2OverviewPage) {
            return;
        }

        // Get page and redirect url
        $objRedirectPage = \PageModel::findByPk($this->pa2OverviewPage);
        $strUrl = $this->generateFrontendUrl($objRedirectPage->row());

        // Redirect to overview page
        $this->redirect($strUrl);
    }

    /**
     * goToRootPage function.
     *
     * @access public
     * @return void
     */
    public function goToRootPage()
    {
        global $objPage;

        // Do not index or cache the page if no album has been specified
        $objPage->noSearch = 1;
        $objPage->cache = 0;

        // Get root page and redirect url
        $objRootPage = $this->getPageDetails($objPage->rootId);
        $strUrl = $this->generateFrontendUrl($objRootPage->row());

        // Locate to root page
        $this->redirect($strUrl);
    }
}
