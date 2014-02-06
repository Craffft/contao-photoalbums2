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
 * Class Photoalbums2Runonce
 *
 * @copyright  Daniel Kiesel 2012-2014
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class runonce extends \System
{

    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Disable debug mode
        $GLOBALS['TL_CONFIG']['debugMode'] = false;

        // Load required translation_fields classes
        \ClassLoader::addNamespace('TranslationFields');
        \ClassLoader::addClass('TranslationFields\Updater', 'system/modules/translation_fields/classes/Updater.php');
        \ClassLoader::addClass('TranslationFields\TranslationFieldsWidgetHelper', 'system/modules/translation_fields/classes/TranslationFieldsWidgetHelper.php');
        \ClassLoader::addClass('TranslationFields\TranslationFieldsModel', 'system/modules/translation_fields/models/TranslationFieldsModel.php');
        \ClassLoader::register();

        // Import
        $this->import('Database');
    }

    /**
     * run function.
     *
     * @access public
     * @return void
     */
    public function run()
    {
        /**
         * Create new translation fields table, if it does not exist
         */
        if (!$this->Database->tableExists('tl_translation_fields')) {
            $arrSqlStatements = array();
            $arrSqlStatements[] = "CREATE TABLE `tl_translation_fields` (";
            $arrSqlStatements[] = "`id` int(10) unsigned NOT NULL auto_increment,";
            $arrSqlStatements[] = "`tstamp` int(10) unsigned NOT NULL default '0',";
            $arrSqlStatements[] = "`fid` int(10) unsigned NOT NULL default '0',";
            $arrSqlStatements[] = "`language` varchar(5) NOT NULL default '',";
            $arrSqlStatements[] = "`content` text NOT NULL,";
            $arrSqlStatements[] = "PRIMARY KEY  (`id`),";
            $arrSqlStatements[] = "UNIQUE KEY `fid_language` (`fid`, `language`),";
            $arrSqlStatements[] = "KEY `fid` (`fid`)";
            $arrSqlStatements[] = ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

            $this->Database->query(implode(' ', $arrSqlStatements));
        }

        /**
         * SQL statements
         */
        if ($this->Database->fieldExists('pa2PhotosTemplate', 'tl_content')) {
            $this->Database->query("ALTER TABLE `tl_content` CHANGE `pa2PhotosTemplate` `pa2ImagesTemplate` varchar(64) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('pa2NumberOfPhotos', 'tl_content')) {
            $this->Database->query("ALTER TABLE `tl_content` CHANGE `pa2NumberOfPhotos` `pa2NumberOfImages` smallint(5) unsigned NOT NULL default '0'");
        }

        if ($this->Database->fieldExists('pa2PhotosPerPage', 'tl_content')) {
            $this->Database->query("ALTER TABLE `tl_content` CHANGE `pa2PhotosPerPage` `pa2ImagesPerPage` smallint(5) unsigned NOT NULL default '24'");
        }

        if ($this->Database->fieldExists('pa2PhotosPerRow', 'tl_content')) {
            $this->Database->query("ALTER TABLE `tl_content` CHANGE `pa2PhotosPerRow` `pa2ImagesPerRow` smallint(5) unsigned NOT NULL default '2'");
        }

        if ($this->Database->fieldExists('pa2PhotosShowHeadline', 'tl_content')) {
            $this->Database->query("ALTER TABLE `tl_content` CHANGE `pa2PhotosShowHeadline` `pa2ImagesShowHeadline` char(1) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('pa2PhotosShowTitle', 'tl_content')) {
            $this->Database->query("ALTER TABLE `tl_content` CHANGE `pa2PhotosShowTitle` `pa2ImagesShowTitle` char(1) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('pa2PhotosShowTeaser', 'tl_content')) {
            $this->Database->query("ALTER TABLE `tl_content` CHANGE `pa2PhotosShowTeaser` `pa2ImagesShowTeaser` char(1) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('pa2PhotosImageSize', 'tl_content')) {
            $this->Database->query("ALTER TABLE `tl_content` CHANGE `pa2PhotosImageSize` `pa2ImagesImageSize` varchar(64) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('pa2PhotosImageMargin', 'tl_content')) {
            $this->Database->query("ALTER TABLE `tl_content` CHANGE `pa2PhotosImageMargin` `pa2ImagesImageMargin` varchar(128) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('pa2PhotosMetaFields', 'tl_content')) {
            $this->Database->query("ALTER TABLE `tl_content` CHANGE `pa2PhotosMetaFields` `pa2ImagesMetaFields` blob NULL");
        }

        if ($this->Database->fieldExists('pa2PreviewPic', 'tl_module')) {
            $this->Database->query("ALTER TABLE `tl_module` CHANGE `pa2PreviewPic` `pa2PreviewImage` varchar(64) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('pa2PhotosTemplate', 'tl_module')) {
            $this->Database->query("ALTER TABLE `tl_module` CHANGE `pa2PhotosTemplate` `pa2ImagesTemplate` varchar(64) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('pa2NumberOfPhotos', 'tl_module')) {
            $this->Database->query("ALTER TABLE `tl_module` CHANGE `pa2NumberOfPhotos` `pa2NumberOfImages` smallint(5) unsigned NOT NULL default '0'");
        }

        if ($this->Database->fieldExists('pa2PhotosPerPage', 'tl_module')) {
            $this->Database->query("ALTER TABLE `tl_module` CHANGE `pa2PhotosPerPage` `pa2ImagesPerPage` smallint(5) unsigned NOT NULL default '24'");
        }

        if ($this->Database->fieldExists('pa2PhotosPerRow', 'tl_module')) {
            $this->Database->query("ALTER TABLE `tl_module` CHANGE `pa2PhotosPerRow` `pa2ImagesPerRow` smallint(5) unsigned NOT NULL default '2'");
        }

        if ($this->Database->fieldExists('pa2PhotosShowHeadline', 'tl_module')) {
            $this->Database->query("ALTER TABLE `tl_module` CHANGE `pa2PhotosShowHeadline` `pa2ImagesShowHeadline` char(1) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('pa2PhotosShowTitle', 'tl_module')) {
            $this->Database->query("ALTER TABLE `tl_module` CHANGE `pa2PhotosShowTitle` `pa2ImagesShowTitle` char(1) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('pa2PhotosShowTeaser', 'tl_module')) {
            $this->Database->query("ALTER TABLE `tl_module` CHANGE `pa2PhotosShowTeaser` `pa2ImagesShowTeaser` char(1) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('pa2PhotosImageSize', 'tl_module')) {
            $this->Database->query("ALTER TABLE `tl_module` CHANGE `pa2PhotosImageSize` `pa2ImagesImageSize` varchar(64) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('pa2PhotosImageMargin', 'tl_module')) {
            $this->Database->query("ALTER TABLE `tl_module` CHANGE `pa2PhotosImageMargin` `pa2ImagesImageMargin` varchar(128) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('pa2PhotosMetaFields', 'tl_module')) {
            $this->Database->query("ALTER TABLE `tl_module` CHANGE `pa2PhotosMetaFields` `pa2ImagesMetaFields` blob NULL");
        }

        if ($this->Database->fieldExists('pictures', 'tl_photoalbums2_album')) {
            $this->Database->query("ALTER TABLE `tl_photoalbums2_album` CHANGE `pictures` `images` blob NULL");
        }

        if ($this->Database->fieldExists('preview_pic_check', 'tl_photoalbums2_album')) {
            $this->Database->query("ALTER TABLE `tl_photoalbums2_album` CHANGE `preview_pic_check` `preview_image_check` varchar(64) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('preview_image_check', 'tl_photoalbums2_album')) {
            $this->Database->query("ALTER TABLE `tl_photoalbums2_album` CHANGE `preview_image_check` `previewImageType` varchar(64) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('preview_pic', 'tl_photoalbums2_album')) {
            $this->Database->query("ALTER TABLE `tl_photoalbums2_album` CHANGE `preview_pic` `preview_image` varchar(255) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('preview_image', 'tl_photoalbums2_album')) {
            $this->Database->query("ALTER TABLE `tl_photoalbums2_album` CHANGE `preview_image` `previewImage` varchar(255) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('pic_sort_check', 'tl_photoalbums2_album')) {
            $this->Database->query("ALTER TABLE `tl_photoalbums2_album` CHANGE `pic_sort_check` `image_sort_check` varchar(64) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('image_sort_check', 'tl_photoalbums2_album')) {
            $this->Database->query("ALTER TABLE `tl_photoalbums2_album` CHANGE `image_sort_check` `imageSortType` varchar(64) NOT NULL default ''");
        }

        if ($this->Database->fieldExists('pic_sort', 'tl_photoalbums2_album')) {
            $this->Database->query("ALTER TABLE `tl_photoalbums2_album` CHANGE `pic_sort` `image_sort` blob NULL");
        }

        if ($this->Database->fieldExists('image_sort', 'tl_photoalbums2_album')) {
            $this->Database->query("ALTER TABLE `tl_photoalbums2_album` CHANGE `image_sort` `imageSort` blob NULL");
        }

        if ($this->Database->fieldExists('photoalbums', 'tl_user_group')) {
            $this->Database->query("ALTER TABLE `tl_user_group` CHANGE `photoalbums` `photoalbums2s` blob NULL");
        }

        if ($this->Database->fieldExists('photoalbump', 'tl_user_group')) {
            $this->Database->query("ALTER TABLE `tl_user_group` CHANGE `photoalbump` `photoalbums2p` blob NULL");
        }

        if ($this->Database->fieldExists('photoalbums', 'tl_user')) {
            $this->Database->query("ALTER TABLE `tl_user` CHANGE `photoalbums` `photoalbums2s` blob NULL");
        }

        if ($this->Database->fieldExists('photoalbump', 'tl_user')) {
            $this->Database->query("ALTER TABLE `tl_user` CHANGE `photoalbump` `photoalbums2p` blob NULL");
        }

        /**
         * Added translation fields
         */
        \TranslationFields\Updater::convertTranslationField('tl_photoalbums2_album', 'event');
        \TranslationFields\Updater::convertTranslationField('tl_photoalbums2_album', 'place');
        \TranslationFields\Updater::convertTranslationField('tl_photoalbums2_album', 'photographer');
        \TranslationFields\Updater::convertTranslationField('tl_photoalbums2_album', 'description');
        \TranslationFields\Updater::convertTranslationField('tl_content', 'pa2Teaser');
        \TranslationFields\Updater::convertTranslationField('tl_module', 'pa2Teaser');

        /**
         * Add UUIDs support
         */
        \Database\Updater::convertMultiField('tl_photoalbums2_album', 'images');
        \Database\Updater::convertMultiField('tl_photoalbums2_album', 'imageSort');
        \Database\Updater::convertSingleField('tl_photoalbums2_album', 'previewImage');
    }
}

/**
 * Instantiate controller
 */
$objPhotoalbums2Runonce = new Photoalbums2Runonce();
$objPhotoalbums2Runonce->run();
