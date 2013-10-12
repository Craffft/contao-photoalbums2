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
 * Class Photoalbums2Runonce
 *
 * @copyright  Daniel Kiesel 2012-2013
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class Photoalbums2Runonce extends \Controller
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

		$this->import((TL_MODE=='BE' ? 'BackendUser' : 'FrontendUser'), 'User');
	}


	/**
	 * run function.
	 *
	 * @access public
	 * @return void
	 */
	public function run()
	{
		$db = \Database::getInstance();


		/**
		 * Create new translation fields table, if it does not exist
		 */
		if (!$db->tableExists('tl_translation_fields'))
		{
			$arrSqlStatements = array();
			$arrSqlStatements .= "CREATE TABLE `tl_translation_fields` (";
			$arrSqlStatements .= "`id` int(10) unsigned NOT NULL auto_increment,";
			$arrSqlStatements .= "`tstamp` int(10) unsigned NOT NULL default '0',";
			$arrSqlStatements .= "`fid` int(10) unsigned NOT NULL default '0',";
			$arrSqlStatements .= "`language` varchar(5) NOT NULL default '',";
			$arrSqlStatements .= "`content` text NOT NULL,";
			$arrSqlStatements .= "PRIMARY KEY  (`id`),";
			$arrSqlStatements .= "UNIQUE KEY `fid_language` (`fid`, `language`),";
			$arrSqlStatements .= "KEY `fid` (`fid`)";
			$arrSqlStatements .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

			$db->execute(implode(' ', $arrSqlStatements));
		}


		/**
		 * Added translation fields
		 */
		$objAlbum = \Photoalbums2AlbumModel::findAll();
		$objContent = \ContentModel::findAll();
		$objModule = \ModuleModel::findAll();

		if ($objAlbum !== null)
		{
			while ($objAlbum->next())
			{
				if (strlen($objAlbum->event) > 0 && !is_numeric($objAlbum->event))
				{
					$objAlbum->event = \TranslationFieldsWidgetHelper::saveValuesAndReturnFid(\TranslationFieldsWidgetHelper::addValueToAllLanguages($objAlbum->event));
				}

				if (strlen($objAlbum->place) > 0 && !is_numeric($objAlbum->place))
				{
					$objAlbum->place = \TranslationFieldsWidgetHelper::saveValuesAndReturnFid(\TranslationFieldsWidgetHelper::addValueToAllLanguages($objAlbum->place));
				}

				if (strlen($objAlbum->photographer) > 0 && !is_numeric($objAlbum->photographer))
				{
					$objAlbum->photographer = \TranslationFieldsWidgetHelper::saveValuesAndReturnFid(\TranslationFieldsWidgetHelper::addValueToAllLanguages($objAlbum->photographer));
				}

				if (strlen($objAlbum->description) > 0 && !is_numeric($objAlbum->description))
				{
					$objAlbum->description = \TranslationFieldsWidgetHelper::saveValuesAndReturnFid(\TranslationFieldsWidgetHelper::addValueToAllLanguages($objAlbum->description));
				}

				// Save
				$objAlbum->save();
			}
		}

		if ($objContent !== null)
		{
			while ($objContent->next())
			{
				if (strlen($objContent->pa2Teaser) > 0 && !is_numeric($objContent->pa2Teaser))
				{
					$objContent->pa2Teaser = \TranslationFieldsWidgetHelper::saveValuesAndReturnFid(\TranslationFieldsWidgetHelper::addValueToAllLanguages($objContent->pa2Teaser));
				}

				// Save
				$objContent->save();
			}
		}

		if ($objModule !== null)
		{
			while ($objModule->next())
			{
				if (strlen($objModule->pa2Teaser) > 0 && !is_numeric($objModule->pa2Teaser))
				{
					$objModule->pa2Teaser = \TranslationFieldsWidgetHelper::saveValuesAndReturnFid(\TranslationFieldsWidgetHelper::addValueToAllLanguages($objModule->pa2Teaser));
				}

				// Save
				$objModule->save();
			}
		}


		/**
		 * SQL statements
		 */
		$arrSqlStatements = array(
			"ALTER TABLE `tl_content` CHANGE `pa2PhotosTemplate` `pa2ImagesTemplate` varchar(64) NOT NULL default ''",
			"ALTER TABLE `tl_content` CHANGE `pa2NumberOfPhotos` `pa2NumberOfImages` smallint(5) unsigned NOT NULL default '0'",
			"ALTER TABLE `tl_content` CHANGE `pa2PhotosPerPage` `pa2ImagesPerPage` smallint(5) unsigned NOT NULL default '24'",
			"ALTER TABLE `tl_content` CHANGE `pa2PhotosPerRow` `pa2ImagesPerRow` smallint(5) unsigned NOT NULL default '2'",
			"ALTER TABLE `tl_content` CHANGE `pa2PhotosShowHeadline` `pa2ImagesShowHeadline` char(1) NOT NULL default ''",
			"ALTER TABLE `tl_content` CHANGE `pa2PhotosShowTitle` `pa2ImagesShowTitle` char(1) NOT NULL default ''",
			"ALTER TABLE `tl_content` CHANGE `pa2PhotosShowTeaser` `pa2ImagesShowTeaser` char(1) NOT NULL default ''",
			"ALTER TABLE `tl_content` CHANGE `pa2PhotosImageSize` `pa2ImagesImageSize` varchar(64) NOT NULL default ''",
			"ALTER TABLE `tl_content` CHANGE `pa2PhotosImageMargin` `pa2ImagesImageMargin` varchar(128) NOT NULL default ''",
			"ALTER TABLE `tl_content` CHANGE `pa2PhotosMetaFields` `pa2ImagesMetaFields` blob NULL",

			"ALTER TABLE `tl_module` CHANGE `pa2PreviewPic` `pa2PreviewImage` varchar(64) NOT NULL default ''",
			"ALTER TABLE `tl_module` CHANGE `pa2PhotosTemplate` `pa2ImagesTemplate` varchar(64) NOT NULL default ''",
			"ALTER TABLE `tl_module` CHANGE `pa2NumberOfPhotos` `pa2NumberOfImages` smallint(5) unsigned NOT NULL default '0'",
			"ALTER TABLE `tl_module` CHANGE `pa2PhotosPerPage` `pa2ImagesPerPage` smallint(5) unsigned NOT NULL default '24'",
			"ALTER TABLE `tl_module` CHANGE `pa2PhotosPerRow` `pa2ImagesPerRow` smallint(5) unsigned NOT NULL default '2'",
			"ALTER TABLE `tl_module` CHANGE `pa2PhotosShowHeadline` `pa2ImagesShowHeadline` char(1) NOT NULL default ''",
			"ALTER TABLE `tl_module` CHANGE `pa2PhotosShowTitle` `pa2ImagesShowTitle` char(1) NOT NULL default ''",
			"ALTER TABLE `tl_module` CHANGE `pa2PhotosShowTeaser` `pa2ImagesShowTeaser` char(1) NOT NULL default ''",
			"ALTER TABLE `tl_module` CHANGE `pa2PhotosImageSize` `pa2ImagesImageSize` varchar(64) NOT NULL default ''",
			"ALTER TABLE `tl_module` CHANGE `pa2PhotosImageMargin` `pa2ImagesImageMargin` varchar(128) NOT NULL default ''",
			"ALTER TABLE `tl_module` CHANGE `pa2PhotosMetaFields` `pa2ImagesMetaFields` blob NULL",

			"ALTER TABLE `tl_photoalbums2_album` CHANGE `pictures` `images` blob NULL",

			"ALTER TABLE `tl_photoalbums2_album` CHANGE `preview_pic_check` `preview_image_check` varchar(64) NOT NULL default ''",
			"ALTER TABLE `tl_photoalbums2_album` CHANGE `preview_image_check` `previewImageType` varchar(64) NOT NULL default ''",

			"ALTER TABLE `tl_photoalbums2_album` CHANGE `preview_pic` `preview_image` varchar(255) NOT NULL default ''",
			"ALTER TABLE `tl_photoalbums2_album` CHANGE `preview_image` `previewImage` varchar(255) NOT NULL default ''",

			"ALTER TABLE `tl_photoalbums2_album` CHANGE `pic_sort_check` `image_sort_check` varchar(64) NOT NULL default ''",
			"ALTER TABLE `tl_photoalbums2_album` CHANGE `image_sort_check` `imageSortType` varchar(64) NOT NULL default ''",

			"ALTER TABLE `tl_photoalbums2_album` CHANGE `pic_sort` `image_sort` blob NULL",
			"ALTER TABLE `tl_photoalbums2_album` CHANGE `image_sort` `imageSort` blob NULL",

			"ALTER TABLE `tl_user_group` CHANGE `photoalbums` `photoalbums2s` blob NULL",
			"ALTER TABLE `tl_user_group` CHANGE `photoalbump` `photoalbums2p` blob NULL",

			"ALTER TABLE `tl_user` CHANGE `photoalbums` `photoalbums2s` blob NULL",
			"ALTER TABLE `tl_user` CHANGE `photoalbump` `photoalbums2p` blob NULL",

			// Translation fields
			"ALTER TABLE `tl_photoalbums2_album` CHANGE `event` `event` int(10) unsigned NOT NULL default '0'",
			"ALTER TABLE `tl_photoalbums2_album` CHANGE `place` `place` int(10) unsigned NOT NULL default '0'",
			"ALTER TABLE `tl_photoalbums2_album` CHANGE `photographer` `photographer` int(10) unsigned NOT NULL default '0'",
			"ALTER TABLE `tl_photoalbums2_album` CHANGE `description` `description` int(10) unsigned NOT NULL default '0'",
			"ALTER TABLE `tl_content` CHANGE `pa2Teaser` `pa2Teaser` int(10) unsigned NOT NULL default '0'",
			"ALTER TABLE `tl_module` CHANGE `pa2Teaser` `pa2Teaser` int(10) unsigned NOT NULL default '0'",
		);

		foreach($arrSqlStatements as $strSqlStatement)
		{
			// Execute sql statements
			$stmt = $db->prepare($strSqlStatement);
			$res = $stmt->execute();
		}
	}
}


/**
 * Instantiate controller
 */
$objPhotoalbums2Runonce = new Photoalbums2Runonce();
$objPhotoalbums2Runonce->run();
