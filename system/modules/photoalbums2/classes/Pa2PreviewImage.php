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
 * Class Pa2PreviewImage
 *
 * @copyright  Daniel Kiesel 2012-2014
 * @author     Daniel Kiesel <daniel@craffft.de>
 * @package    photoalbums2
 */
class Pa2PreviewImage extends \Controller
{
    /**
     * uuid
     *
     * @var string
     * @access private
     */
    private $uuid;

    /**
     * objAlbum
     *
     * @var object
     * @access private
     */
    private $objAlbum;

    /**
     * objPreviewImage
     *
     * @var object
     * @access private
     */
    private $objPreviewImage;

    /**
     * __construct function.
     *
     * @access public
     * @param  object $objAlbum
     * @param  string $type
     * @return void
     */
    public function __construct($objAlbum, $type)
    {
        if (is_numeric($objAlbum)) {
            $objAlbum = \Photoalbums2AlbumModel::findByPk($objAlbum);
        }

        if (!is_object($objAlbum)) {
            return false;
        }

        $this->objAlbum = $objAlbum;
        $this->type = $type;

        $this->setPreviewImageId();
    }

    /**
     * getPreviewImage function.
     *
     * @access private
     * @return void
     */
    private function setPreviewImageId()
    {
        $uuid = null;

        switch ($this->type) {
            case 'use_album_options':
                $uuid = $this->getPreviewImageByAlbumType();
                break;

            case 'no_preview_images':
                $uuid = null;
                break;

            case 'random_images':
                $uuid = $this->getRandomPreviewImage();
                break;

            case 'first_image':
                $uuid = $this->getFirstPreviewImage();
                break;

            case 'random_images_at_no_preview_images':
                if ($this->objAlbum->previewImageType === 'no_preview_image') {
                    $uuid = $this->getRandomPreviewImage();
                } else {
                    $uuid = $this->getPreviewImageByAlbumType();
                }
                break;

            case 'first_image_at_no_preview_images':
                if ($this->objAlbum->previewImageType === 'no_preview_image') {
                    $uuid = $this->getFirstPreviewImage();
                } else {
                    $uuid = $this->getPreviewImageByAlbumType();
                }
                break;
        }

        $this->uuid = $uuid;
    }

    private function getPreviewImageByAlbumType()
    {
        $uuid = null;

        switch ($this->objAlbum->previewImageType) {
            case 'no_preview_image':
                $uuid = null;
                break;

            case 'random_preview_image':
                $uuid = $this->getRandomPreviewImage();
                break;

            case 'first_preview_image':
                $uuid = $this->getFirstPreviewImage();
                break;

            case 'select_preview_image':
                $uuid = $this->objAlbum->previewImage;
                break;
        }

        return $uuid;
    }

    /**
     * getPreviewImageUuid function.
     *
     * @access public
     * @return int
     */
    public function getPreviewImageUuid()
    {
        return $this->uuid;
    }

    /**
     * getPreviewImage function.
     *
     * @access public
     * @return object
     */
    public function getPreviewImage()
    {
        if (is_object($this->objPreviewImage)) {
            return $this->objPreviewImage;
        }

        // Get preview image as FilesModel object
        $this->objPreviewImage = \FilesModel::findByUuid($this->uuid);

        return $this->objPreviewImage;
    }

    /**
     * getRandomPreviewImage function.
     *
     * @access protected
     * @return int
     */
    protected function getRandomPreviewImage()
    {
        $arrImages = $this->getAlbumImagesUuid();

        if (count($arrImages) > 0) {
            return $arrImages[mt_rand(0, count($arrImages) - 1)];
        }

        return null;
    }

    /**
     * getFirstPreviewImage function.
     *
     * @access protected
     * @return int
     */
    protected function getFirstPreviewImage()
    {
        $arrImages = $this->getAlbumImagesUuid();

        if (count($arrImages) > 0) {
            return $arrImages[0];
        }

        return null;
    }

    /**
     * @return array
     */
    private function getAlbumImagesUuid()
    {
        if (count($this->objAlbum->images) < 1) {
            return array();
        }

        // Deserialize
        $this->objAlbum->images = deserialize($this->objAlbum->images);

        // Get all image ids and save them in the images array
        $objImageSorter = new \ImageSorter(
            $this->objAlbum->images,
            $GLOBALS['TL_DCA']['tl_photoalbums2_album']['fields']['images']['eval']['extensions']
        );

        $this->objAlbum->images = $objImageSorter->getImageUuids();

        if (count($this->objAlbum->images) < 1) {
            return array();
        }

        return $this->objAlbum->images;
    }
}
