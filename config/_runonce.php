<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2014 Leo Feyer
 *
 * @package    photoalbums2
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @license    LGPL
 * @copyright  Daniel Kiesel 2012-2014
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
		if ($db->fieldExists('pa2PhotosTemplate', 'tl_content'))
		{
			$db->execute("ALTER TABLE `tl_content` CHANGE `pa2PhotosTemplate` `pa2ImagesTemplate` varchar(64) NOT NULL default ''");
		}

		if ($db->fieldExists('pa2NumberOfPhotos', 'tl_content'))
		{
			$db->execute("ALTER TABLE `tl_content` CHANGE `pa2NumberOfPhotos` `pa2NumberOfImages` smallint(5) unsigned NOT NULL default '0'");
		}

		if ($db->fieldExists('pa2PhotosPerPage', 'tl_content'))
		{
			$db->execute("ALTER TABLE `tl_content` CHANGE `pa2PhotosPerPage` `pa2ImagesPerPage` smallint(5) unsigned NOT NULL default '24'");
		}

		if ($db->fieldExists('pa2PhotosPerRow', 'tl_content'))
		{
			$db->execute("ALTER TABLE `tl_content` CHANGE `pa2PhotosPerRow` `pa2ImagesPerRow` smallint(5) unsigned NOT NULL default '2'");
		}

		if ($db->fieldExists('pa2PhotosShowHeadline', 'tl_content'))
		{
			$db->execute("ALTER TABLE `tl_content` CHANGE `pa2PhotosShowHeadline` `pa2ImagesShowHeadline` char(1) NOT NULL default ''");
		}

		if ($db->fieldExists('pa2PhotosShowTitle', 'tl_content'))
		{
			$db->execute("ALTER TABLE `tl_content` CHANGE `pa2PhotosShowTitle` `pa2ImagesShowTitle` char(1) NOT NULL default ''");
		}

		if ($db->fieldExists('pa2PhotosShowTeaser', 'tl_content'))
		{
			$db->execute("ALTER TABLE `tl_content` CHANGE `pa2PhotosShowTeaser` `pa2ImagesShowTeaser` char(1) NOT NULL default ''");
		}

		if ($db->fieldExists('pa2PhotosImageSize', 'tl_content'))
		{
			$db->execute("ALTER TABLE `tl_content` CHANGE `pa2PhotosImageSize` `pa2ImagesImageSize` varchar(64) NOT NULL default ''");
		}

		if ($db->fieldExists('pa2PhotosImageMargin', 'tl_content'))
		{
			$db->execute("ALTER TABLE `tl_content` CHANGE `pa2PhotosImageMargin` `pa2ImagesImageMargin` varchar(128) NOT NULL default ''");
		}

		if ($db->fieldExists('pa2PhotosMetaFields', 'tl_content'))
		{
			$db->execute("ALTER TABLE `tl_content` CHANGE `pa2PhotosMetaFields` `pa2ImagesMetaFields` blob NULL");
		}

		if ($db->fieldExists('pa2PreviewPic', 'tl_module'))
		{
			$db->execute("ALTER TABLE `tl_module` CHANGE `pa2PreviewPic` `pa2PreviewImage` varchar(64) NOT NULL default ''");
		}

		if ($db->fieldExists('pa2PhotosTemplate', 'tl_module'))
		{
			$db->execute("ALTER TABLE `tl_module` CHANGE `pa2PhotosTemplate` `pa2ImagesTemplate` varchar(64) NOT NULL default ''");
		}

		if ($db->fieldExists('pa2NumberOfPhotos', 'tl_module'))
		{
			$db->execute("ALTER TABLE `tl_module` CHANGE `pa2NumberOfPhotos` `pa2NumberOfImages` smallint(5) unsigned NOT NULL default '0'");
		}

		if ($db->fieldExists('pa2PhotosPerPage', 'tl_module'))
		{
			$db->execute("ALTER TABLE `tl_module` CHANGE `pa2PhotosPerPage` `pa2ImagesPerPage` smallint(5) unsigned NOT NULL default '24'");
		}

		if ($db->fieldExists('pa2PhotosPerRow', 'tl_module'))
		{
			$db->execute("ALTER TABLE `tl_module` CHANGE `pa2PhotosPerRow` `pa2ImagesPerRow` smallint(5) unsigned NOT NULL default '2'");
		}

		if ($db->fieldExists('pa2PhotosShowHeadline', 'tl_module'))
		{
			$db->execute("ALTER TABLE `tl_module` CHANGE `pa2PhotosShowHeadline` `pa2ImagesShowHeadline` char(1) NOT NULL default ''");
		}

		if ($db->fieldExists('pa2PhotosShowTitle', 'tl_module'))
		{
			$db->execute("ALTER TABLE `tl_module` CHANGE `pa2PhotosShowTitle` `pa2ImagesShowTitle` char(1) NOT NULL default ''");
		}

		if ($db->fieldExists('pa2PhotosShowTeaser', 'tl_module'))
		{
			$db->execute("ALTER TABLE `tl_module` CHANGE `pa2PhotosShowTeaser` `pa2ImagesShowTeaser` char(1) NOT NULL default ''");
		}

		if ($db->fieldExists('pa2PhotosImageSize', 'tl_module'))
		{
			$db->execute("ALTER TABLE `tl_module` CHANGE `pa2PhotosImageSize` `pa2ImagesImageSize` varchar(64) NOT NULL default ''");
		}

		if ($db->fieldExists('pa2PhotosImageMargin', 'tl_module'))
		{
			$db->execute("ALTER TABLE `tl_module` CHANGE `pa2PhotosImageMargin` `pa2ImagesImageMargin` varchar(128) NOT NULL default ''");
		}

		if ($db->fieldExists('pa2PhotosMetaFields', 'tl_module'))
		{
			$db->execute("ALTER TABLE `tl_module` CHANGE `pa2PhotosMetaFields` `pa2ImagesMetaFields` blob NULL");
		}

		if ($db->fieldExists('pictures', 'tl_photoalbums2_album'))
		{
			$db->execute("ALTER TABLE `tl_photoalbums2_album` CHANGE `pictures` `images` blob NULL");
		}

		if ($db->fieldExists('preview_pic_check', 'tl_photoalbums2_album'))
		{
			$db->execute("ALTER TABLE `tl_photoalbums2_album` CHANGE `preview_pic_check` `preview_image_check` varchar(64) NOT NULL default ''");
		}

		if ($db->fieldExists('preview_image_check', 'tl_photoalbums2_album'))
		{
			$db->execute("ALTER TABLE `tl_photoalbums2_album` CHANGE `preview_image_check` `previewImageType` varchar(64) NOT NULL default ''");
		}

		if ($db->fieldExists('preview_pic', 'tl_photoalbums2_album'))
		{
			$db->execute("ALTER TABLE `tl_photoalbums2_album` CHANGE `preview_pic` `preview_image` varchar(255) NOT NULL default ''");
		}

		if ($db->fieldExists('preview_image', 'tl_photoalbums2_album'))
		{
			$db->execute("ALTER TABLE `tl_photoalbums2_album` CHANGE `preview_image` `previewImage` varchar(255) NOT NULL default ''");
		}

		if ($db->fieldExists('pic_sort_check', 'tl_photoalbums2_album'))
		{
			$db->execute("ALTER TABLE `tl_photoalbums2_album` CHANGE `pic_sort_check` `image_sort_check` varchar(64) NOT NULL default ''");
		}

		if ($db->fieldExists('image_sort_check', 'tl_photoalbums2_album'))
		{
			$db->execute("ALTER TABLE `tl_photoalbums2_album` CHANGE `image_sort_check` `imageSortType` varchar(64) NOT NULL default ''");
		}

		if ($db->fieldExists('pic_sort', 'tl_photoalbums2_album'))
		{
			$db->execute("ALTER TABLE `tl_photoalbums2_album` CHANGE `pic_sort` `image_sort` blob NULL");
		}

		if ($db->fieldExists('image_sort', 'tl_photoalbums2_album'))
		{
			$db->execute("ALTER TABLE `tl_photoalbums2_album` CHANGE `image_sort` `imageSort` blob NULL");
		}

		if ($db->fieldExists('photoalbums', 'tl_user_group'))
		{
			$db->execute("ALTER TABLE `tl_user_group` CHANGE `photoalbums` `photoalbums2s` blob NULL");
		}

		if ($db->fieldExists('photoalbump', 'tl_user_group'))
		{
			$db->execute("ALTER TABLE `tl_user_group` CHANGE `photoalbump` `photoalbums2p` blob NULL");
		}

		if ($db->fieldExists('photoalbums', 'tl_user'))
		{
			$db->execute("ALTER TABLE `tl_user` CHANGE `photoalbums` `photoalbums2s` blob NULL");
		}

		if ($db->fieldExists('photoalbump', 'tl_user'))
		{
			$db->execute("ALTER TABLE `tl_user` CHANGE `photoalbump` `photoalbums2p` blob NULL");
		}


		// Translation fields
		if ($db->fieldExists('event', 'tl_photoalbums2_album'))
		{
			$db->execute("ALTER TABLE `tl_photoalbums2_album` CHANGE `event` `event` int(10) unsigned NOT NULL default '0'");
		}

		if ($db->fieldExists('place', 'tl_photoalbums2_album'))
		{
			$db->execute("ALTER TABLE `tl_photoalbums2_album` CHANGE `place` `place` int(10) unsigned NOT NULL default '0'");
		}

		if ($db->fieldExists('photographer', 'tl_photoalbums2_album'))
		{
			$db->execute("ALTER TABLE `tl_photoalbums2_album` CHANGE `photographer` `photographer` int(10) unsigned NOT NULL default '0'");
		}

		if ($db->fieldExists('description', 'tl_photoalbums2_album'))
		{
			$db->execute("ALTER TABLE `tl_photoalbums2_album` CHANGE `description` `description` int(10) unsigned NOT NULL default '0'");
		}

		if ($db->fieldExists('pa2Teaser', 'tl_content'))
		{
			$db->execute("ALTER TABLE `tl_content` CHANGE `pa2Teaser` `pa2Teaser` int(10) unsigned NOT NULL default '0'");
		}

		if ($db->fieldExists('pa2Teaser', 'tl_module'))
		{
			$db->execute("ALTER TABLE `tl_module` CHANGE `pa2Teaser` `pa2Teaser` int(10) unsigned NOT NULL default '0'");
		}


		// UUIDs
		if ($db->fieldExists('previewImage', 'tl_photoalbums2_album'))
		{
			$db->execute("ALTER TABLE `tl_photoalbums2_album` CHANGE `previewImage` `previewImage` binary(16) NULL");
		}


		/**
		 * Add UUIDs support
		 */
		if ($objAlbum !== null)
		{
			$objAlbum->reset();

			while ($objAlbum->next())
			{
				// Handle preview image
				if (is_numeric($objAlbum->previewImage) && $objAlbum->previewImage > 0)
				{
					$objFile = \FilesModel::findByPk($objAlbum->previewImage);

					if ($objFile !== null)
					{
						$objAlbum->previewImage = $objFile->uuid;
					}
				}

				// Handle image sort
				$imageSort = deserialize($objAlbum->imageSort);

				if (is_array($imageSort) && count($imageSort) > 0)
				{
					foreach ($imageSort as $k => $v)
					{
						if (is_numeric($v) && $v > 0)
						{
							$objFile = \FilesModel::findByPk($v);

							if ($objFile !== null)
							{
								$imageSort[$k] = $objFile->uuid;
							}
						}
					}
				}

				$objAlbum->imageSort = serialize($imageSort);

				// Save album
				$objAlbum->save();
			}
		}
	}
}


/**
 * Instantiate controller
 */
$objPhotoalbums2Runonce = new Photoalbums2Runonce();
$objPhotoalbums2Runonce->run();
