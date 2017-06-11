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
 * Class Pa2ImageViewParser
 *
 * @copyright  Daniel Kiesel 2012-2014
 * @author     Daniel Kiesel <daniel@craffft.de>
 * @package    photoalbums2
 */
class Pa2ImageViewParser extends \Pa2ViewParser
{
    /**
     * intAlbumId
     *
     * @var mixed
     * @access private
     */
    private $intAlbumId;

    /**
     * objAlbum
     *
     * @var object
     * @access private
     */
    private $objAlbum;

    /**
     * arrItems
     *
     * @var array
     * @access private
     */
    private $arrItems = array();

    /**
     * arrAllItems
     *
     * @var array
     * @access private
     */
    private $arrAllItems = array();

    /**
     * __construct function.
     *
     * @access public
     * @param  object $objTemplate
     * @param  int $intAlbumId
     * @return void
     */
    public function __construct($objTemplate, $intAlbumId = 0)
    {
        if (is_numeric($intAlbumId) && $intAlbumId > 0) {
            $this->intAlbumId = $intAlbumId;
        }

        parent::__construct($objTemplate);
    }

    /**
     * generate function.
     *
     * @access protected
     * @return void
     */
    protected function generate()
    {
        $this->Template->intMaxItems = $this->Template->pa2NumberOfImages;
        $this->Template->intItemsPerPage = $this->Template->pa2ImagesPerPage;
        $this->Template->intItemsPerRow = $this->Template->pa2ImagesPerRow;
        $this->Template->strTemplate = (strlen($this->Template->pa2ImageViewTemplate) > 0 ? $this->Template->pa2ImageViewTemplate : 'pa2_wrap');
        $this->Template->strSubtemplate = (strlen($this->Template->pa2ImagesTemplate) > 0 ? $this->Template->pa2ImagesTemplate : 'pa2_image');
        $this->Template->showMetaDescriptions = $this->Template->pa2ImagesShowMetaDescriptions;
        $this->Template->arrMetaFields = $this->Template->pa2ImagesMetaFields;

        // Image params
        $this->Template->size = $this->Template->pa2ImagesImageSize;
        $this->Template->imagemargin = $this->Template->pa2ImagesImageMargin;

        $this->Template->showHeadline = $this->Template->pa2ImagesShowHeadline;
        $this->Template->showTitle = $this->Template->pa2ImagesShowTitle;
        $this->Template->showTeaser = $this->Template->pa2ImagesShowTeaser;
        $this->Template->teaser = $this->cleanRteOutput(\TranslationFields::translateValue($this->Template->pa2Teaser));
        $this->Template->showHeadline = ($this->Template->headline != '' ? $this->Template->showHeadline : false);
        $this->Template->showTeaser = ($this->Template->teaser != '' ? $this->Template->showTeaser : false);

        parent::generate();
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

        // Generate new template object
        $objTemplate = new \FrontendTemplate($this->Template->strTemplate);
        $objTemplate->setData($this->Template->getData());
        $this->Template = $objTemplate;

        // Get album id
        $objPa2Album = new \Pa2Album($this->getAlbumIdOrAlias(), $this->Template->getData());
        $objAlbum = $objPa2Album->getAlbums();

        // If there is no album
        if (!is_object($objAlbum) || $objAlbum === null) {
            $this->setEmptyTemplate($GLOBALS['TL_LANG']['MSC']['albumNotFound']);

            return;
        }

        // If there are no images
        if (count($objAlbum->arrSortedImageUuids) < 1) {
            $this->setEmptyTemplate($GLOBALS['TL_LANG']['MSC']['imagesNotFound']);

            return;
        }

        // Get only the current object
        $objAlbum = $objAlbum->current();

        // Do this only in the Frontend
        if (TL_MODE == 'FE' && in_array($this->Template->pa2type, array('MOD', 'MOD_VIEW'))) {
            // Overwrite the page title
            if ($objAlbum->title != '') {
                $objPage->pageTitle = strip_tags(strip_insert_tags($objAlbum->title));
            }

            // Overwrite the page description
            if ($objAlbum->description != '') {
                $objPage->description = $this->prepareMetaDescription($objAlbum->description);
            }

            // Add comments module
            $this->addComments($objAlbum);
        }

        // Set arrItems and objAlbum
        $this->arrItems = $objAlbum->arrSortedImageUuids;
        $this->objAlbum = $objAlbum;

        // Pagination
        $objPa2Pagination = new \Pa2Pagination($this->arrItems, $this->Template->intMaxItems,
            $this->Template->intItemsPerPage);
        $this->arrAllItems = $this->arrItems;
        $this->arrItems = $objPa2Pagination->getItems();
        $this->Template->pagination = $objPa2Pagination->getPagination();
        $this->Template->totalItems = $objPa2Pagination->getTotalItems();

        // Call parseImages
        $this->parseImages();
    }

    /**
     * getAlbumIdOrAlias function.
     *
     * @access protected
     * @return mixed
     */
    protected function getAlbumIdOrAlias()
    {
        $varValue = $this->intAlbumId;

        if (!is_numeric($varValue) || $varValue < 1) {
            $varValue = $this->Input->get('album');
        }

        return $varValue;
    }

    /**
     * parseImages function.
     *
     * @access private
     * @return void
     */
    private function parseImages()
    {
        // If there is no album
        if (!is_object($this->objAlbum)) {
            $this->setEmptyTemplate($GLOBALS['TL_LANG']['MSC']['albumNotFound']);

            return;
        }

        // If there are no images
        if (!is_array($this->arrItems) || count($this->arrItems) < 1) {
            $this->setEmptyTemplate($GLOBALS['TL_LANG']['MSC']['imagesNotFound']);

            return;
        }

        global $objPage;

        // Set album object
        $objAlbum = $this->objAlbum;

        // Add to template
        $this->Template->title = strip_tags($objAlbum->title);
        $this->Template->alt = strip_tags($objAlbum->title);
        $this->Template->showTitle = ($this->Template->title != '' ? $this->Template->showTitle : false);
        $this->Template->cssClass .= ($this->Template->cssClass == '') ? $objAlbum->cssClass : ' ' . $objAlbum->cssClass;
        $this->Template->event = $objAlbum->event;
        $this->Template->place = $objAlbum->place;
        $this->Template->photographer = $objAlbum->photographer;
        $this->Template->description = $objAlbum->description;
        $this->Template->numberOfAllImages = count($objAlbum->arrSortedImageUuids);

        // Generate the backlink
        $this->generateBacklink();

        // Call template methods
        $this->Template = $this->addDateToTemplate($this->Template, $objAlbum->startdate, $objAlbum->enddate);
        $this->Template = $this->addMetaFieldsToTemplate($this->Template);

        // Define useful vars
        $arrItems = array();
        $total = $this->Template->totalItems;
        $i = 0;
        $strIndividualId = $this->generateIndividualId();

        foreach ($this->arrAllItems as $k => $v) {
            // Generate subtemplate object
            $objSubtemplate = new \FrontendTemplate($this->Template->strSubtemplate);
            $objSubtemplate->setData($this->Template->getData());

            // Get new object from Pa2Image
            $objPa2Image = new \Pa2Image($v);
            $objImage = $objPa2Image->getPa2Image();

            // Show this image not in the album
            $objSubtemplate->title = $this->getImageTitle($objImage);
            $objSubtemplate->alt = $this->getImageTitle($objImage);
            $objSubtemplate->show = false;
            $objSubtemplate->elementID = $i;
            $objSubtemplate->albumID = $objAlbum->id . '_' . $strIndividualId;
            $objSubtemplate->href = str_replace(' ', '%20', $objImage->path);

            // If show element
            if (in_array($v, $this->arrItems)) {
                // Set arrImage if is not set or no array
                if (!is_array($objSubtemplate->arrImage)) {
                    $objSubtemplate->arrImage = array();
                }

                // Call template methods
                $objSubtemplate = $objPa2Image->addPa2ImageToTemplate($objSubtemplate, $objSubtemplate->arrImage);
                $objSubtemplate = $this->addSpecificClassesToTemplate($objSubtemplate, $i);

                // Show this image in the album
                $objSubtemplate->show = true;

                $i++;
            } else {
                // Set image array
                $arrImage = array();
                $arrImage['size'] = serialize(array(0, 0, 'crop'));
                $arrImage['imagemargin'] = serialize(array(
                    'bottom' => '',
                    'left'   => '',
                    'right'  => '',
                    'top'    => '',
                    'unit'   => '',
                ));
                $arrImage['singleSRC'] = 'system/modules/photoalbums2/assets/blank.gif';
                $arrImage['alt'] = substr(strrchr($element, '/'), 1);

                // Add image to template
                $objSubtemplate = $objPa2Image->addPa2ImageToTemplate($objSubtemplate, $arrImage);
            }

            // Parse subtemplate
            $arrItems[] = $objSubtemplate->parse();
        }

        $this->Template->items = $arrItems;
    }

    /**
     * generateBacklink function.
     *
     * @access protected
     * @return void
     */
    protected function generateBacklink()
    {
        if (TL_MODE != 'FE' || $this->Template->pa2type == 'CE') {
            return;
        }

        global $objPage;

        // Import
        $this->Import('Session');

        // Get session vars
        $intPageNumber = $this->Session->get('pa2PageNumber_' . $this->Template->id);
        $intPageId = $this->Session->get('pa2PageId_' . $this->Template->id);

        // Set backlink via overview page id
        if (is_numeric($this->Template->pa2OverviewPage) && $this->Template->pa2OverviewPage > 0) {
            $intPageId = $this->Template->pa2OverviewPage;
        }

        // Check and correct session vars
        $intPageNumber = (is_numeric($intPageNumber) ? $intPageNumber : 1);
        $intPageId = (is_numeric($intPageId) ? $intPageId : $objPage->id);

        // Get page object by id
        $objPageDetails = \PageModel::findByPk($intPageId);

        if ($objPageDetails !== null) {
            $objPageDetails = $this->getPageDetails($objPageDetails->id);

            // Set template vars
            $referer = $this->generateFrontendUrl(
                $objPageDetails->row(),
                '',
                $objPageDetails->language
            );
            $referer .= ($intPageNumber > 1 ? '?page=' . $intPageNumber : '');
            $this->Template->referer = $referer;
            $this->Template->back = $GLOBALS['TL_LANG']['PA2']['goBack'];
        }
    }
}
