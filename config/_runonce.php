<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2012 Leo Feyer
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
		
		$arrSqlStatements = array(
			"ALTER TABLE  `tl_content` CHANGE  `pa2PhotosTemplate`  `pa2ImagesTemplate` varchar(64) NOT NULL default ''",
			"ALTER TABLE  `tl_content` CHANGE  `pa2NumberOfPhotos`  `pa2NumberOfImages` smallint(5) unsigned NOT NULL default '0'",
			"ALTER TABLE  `tl_content` CHANGE  `pa2PhotosPerPage`  `pa2ImagesPerPage` smallint(5) unsigned NOT NULL default '24'",
			"ALTER TABLE  `tl_content` CHANGE  `pa2PhotosPerRow`  `pa2ImagesPerRow` smallint(5) unsigned NOT NULL default '2'",
			"ALTER TABLE  `tl_content` CHANGE  `pa2PhotosShowHeadline`  `pa2ImagesShowHeadline` char(1) NOT NULL default ''",
			"ALTER TABLE  `tl_content` CHANGE  `pa2PhotosShowTitle`  `pa2ImagesShowTitle` char(1) NOT NULL default ''",
			"ALTER TABLE  `tl_content` CHANGE  `pa2PhotosShowTeaser`  `pa2ImagesShowTeaser` char(1) NOT NULL default ''",
			"ALTER TABLE  `tl_content` CHANGE  `pa2PhotosImageSize`  `pa2ImagesImageSize` varchar(64) NOT NULL default ''",
			"ALTER TABLE  `tl_content` CHANGE  `pa2PhotosImageMargin`  `pa2ImagesImageMargin` varchar(128) NOT NULL default ''",
			"ALTER TABLE  `tl_content` CHANGE  `pa2PhotosMetaFields`  `pa2ImagesMetaFields` blob NULL",
			
			"ALTER TABLE  `tl_module` CHANGE  `pa2PreviewPic`  `pa2PreviewImage` varchar(64) NOT NULL default ''",
			"ALTER TABLE  `tl_module` CHANGE  `pa2PhotosTemplate`  `pa2ImagesTemplate` varchar(64) NOT NULL default ''",
			"ALTER TABLE  `tl_module` CHANGE  `pa2NumberOfPhotos`  `pa2NumberOfImages` smallint(5) unsigned NOT NULL default '0'",
			"ALTER TABLE  `tl_module` CHANGE  `pa2PhotosPerPage`  `pa2ImagesPerPage` smallint(5) unsigned NOT NULL default '24'",
			"ALTER TABLE  `tl_module` CHANGE  `pa2PhotosPerRow`  `pa2ImagesPerRow` smallint(5) unsigned NOT NULL default '2'",
			"ALTER TABLE  `tl_module` CHANGE  `pa2PhotosShowHeadline`  `pa2ImagesShowHeadline` char(1) NOT NULL default ''",
			"ALTER TABLE  `tl_module` CHANGE  `pa2PhotosShowTitle`  `pa2ImagesShowTitle` char(1) NOT NULL default ''",
			"ALTER TABLE  `tl_module` CHANGE  `pa2PhotosShowTeaser`  `pa2ImagesShowTeaser` char(1) NOT NULL default ''",
			"ALTER TABLE  `tl_module` CHANGE  `pa2PhotosImageSize`  `pa2ImagesImageSize` varchar(64) NOT NULL default ''",
			"ALTER TABLE  `tl_module` CHANGE  `pa2PhotosImageMargin`  `pa2ImagesImageMargin` varchar(128) NOT NULL default ''",
			"ALTER TABLE  `tl_module` CHANGE  `pa2PhotosMetaFields`  `pa2ImagesMetaFields` blob NULL",
			
			"ALTER TABLE  `tl_photoalbums2_album` CHANGE  `pictures`  `images` blob NULL",
			"ALTER TABLE  `tl_photoalbums2_album` CHANGE  `preview_pic_check`  `preview_image_check` varchar(64) NOT NULL default ''",
			"ALTER TABLE  `tl_photoalbums2_album` CHANGE  `preview_image_check`  `preview_image_type` varchar(64) NOT NULL default ''",
			"ALTER TABLE  `tl_photoalbums2_album` CHANGE  `preview_pic`  `preview_image` varchar(255) NOT NULL default ''",
			"ALTER TABLE  `tl_photoalbums2_album` CHANGE  `pic_sort_check`  `image_sort_check` varchar(64) NOT NULL default ''",
			"ALTER TABLE  `tl_photoalbums2_album` CHANGE  `image_sort_check`  `image_sort_type` varchar(64) NOT NULL default ''",
			"ALTER TABLE  `tl_photoalbums2_album` CHANGE  `pic_sort`  `image_sort` blob NULL",
			
			"ALTER TABLE  `tl_user_group` CHANGE  `photoalbums`  `photoalbums2s` blob NULL",
			"ALTER TABLE  `tl_user_group` CHANGE  `photoalbump`  `photoalbums2p` blob NULL",
			
			"ALTER TABLE  `tl_user` CHANGE  `photoalbums`  `photoalbums2s` blob NULL",
			"ALTER TABLE  `tl_user` CHANGE  `photoalbump`  `photoalbums2p` blob NULL",
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

?>