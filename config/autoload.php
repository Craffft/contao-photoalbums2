<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2014 Leo Feyer
 *
 * @package Photoalbums2
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Photoalbums2',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Photoalbums2\Pa2'                      => 'system/modules/photoalbums2/classes/Pa2.php',
	'Photoalbums2\Pa2AlbumSorter'           => 'system/modules/photoalbums2/classes/Pa2AlbumSorter.php',
	'Photoalbums2\Pa2AlbumViewParser'       => 'system/modules/photoalbums2/classes/Pa2AlbumViewParser.php',
	'Photoalbums2\Pa2Backend'               => 'system/modules/photoalbums2/classes/Pa2Backend.php',
	'Photoalbums2\Pa2Empty'                 => 'system/modules/photoalbums2/classes/Pa2Empty.php',
	'Photoalbums2\Pa2ImageSorter'           => 'system/modules/photoalbums2/classes/Pa2ImageSorter.php',
	'Photoalbums2\Pa2ImageViewParser'       => 'system/modules/photoalbums2/classes/Pa2ImageViewParser.php',
	'Photoalbums2\Pa2Pagination'            => 'system/modules/photoalbums2/classes/Pa2Pagination.php',
	'Photoalbums2\Pa2PreviewImage'          => 'system/modules/photoalbums2/classes/Pa2PreviewImage.php',
	'Photoalbums2\Pa2TimeFilter'            => 'system/modules/photoalbums2/classes/Pa2TimeFilter.php',
	'Photoalbums2\Pa2ViewParser'            => 'system/modules/photoalbums2/classes/Pa2ViewParser.php',

	// Elements
	'Photoalbums2\ContentPhotoalbums2'      => 'system/modules/photoalbums2/elements/ContentPhotoalbums2.php',

	// Library
	'Photoalbums2\Pa2Album'                 => 'system/modules/photoalbums2/library/Pa2Album.php',
	'Photoalbums2\Pa2Archive'               => 'system/modules/photoalbums2/library/Pa2Archive.php',
	'Photoalbums2\Pa2Image'                 => 'system/modules/photoalbums2/library/Pa2Image.php',
	'Photoalbums2\Pa2Lib'                   => 'system/modules/photoalbums2/library/Pa2Lib.php',

	// Models
	'Photoalbums2\Photoalbums2AlbumModel'   => 'system/modules/photoalbums2/models/Photoalbums2AlbumModel.php',
	'Photoalbums2\Photoalbums2ArchiveModel' => 'system/modules/photoalbums2/models/Photoalbums2ArchiveModel.php',
	'Photoalbums2\UserGroupModel'           => 'system/modules/photoalbums2/models/UserGroupModel.php',

	// Modules
	'Photoalbums2\ModulePhotoalbums2'       => 'system/modules/photoalbums2/modules/ModulePhotoalbums2.php',
	'Photoalbums2\ModulePhotoalbums2List'   => 'system/modules/photoalbums2/modules/ModulePhotoalbums2List.php',
	'Photoalbums2\ModulePhotoalbums2View'   => 'system/modules/photoalbums2/modules/ModulePhotoalbums2View.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'pa2_album'          => 'system/modules/photoalbums2/templates',
	'pa2_album_fluid'    => 'system/modules/photoalbums2/templates',
	'pa2_empty'          => 'system/modules/photoalbums2/templates',
	'pa2_image'          => 'system/modules/photoalbums2/templates',
	'pa2_image_fluid'    => 'system/modules/photoalbums2/templates',
	'pa2_lightbox_image' => 'system/modules/photoalbums2/templates',
	'pa2_wrap'           => 'system/modules/photoalbums2/templates',
));
