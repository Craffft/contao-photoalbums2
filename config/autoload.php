<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Photoalbums2
 * @link    http://www.contao.org
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
	'Photoalbums2\Pa2Albums'                => 'system/modules/photoalbums2/classes/Pa2Albums.php',
	'Photoalbums2\Pa2Backend'               => 'system/modules/photoalbums2/classes/Pa2Backend.php',
	'Photoalbums2\Pa2Photos'                => 'system/modules/photoalbums2/classes/Pa2Photos.php',

	// Elements
	'Photoalbums2\ContentPhotoalbums2'      => 'system/modules/photoalbums2/elements/ContentPhotoalbums2.php',

	// Models
	'Photoalbums2\Photoalbums2AlbumModel'   => 'system/modules/photoalbums2/models/Photoalbums2AlbumModel.php',
	'Photoalbums2\Photoalbums2ArchiveModel' => 'system/modules/photoalbums2/models/Photoalbums2ArchiveModel.php',

	// Modules
	'Photoalbums2\ModulePhotoalbums2'       => 'system/modules/photoalbums2/modules/ModulePhotoalbums2.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_photoalbums2'       => 'system/modules/photoalbums2/templates',
	'mod_photoalbums2_empty' => 'system/modules/photoalbums2/templates',
	'pa2_album'              => 'system/modules/photoalbums2/templates',
	'pa2_album_fluid'        => 'system/modules/photoalbums2/templates',
	'pa2_photo'              => 'system/modules/photoalbums2/templates',
	'pa2_photo_fluid'        => 'system/modules/photoalbums2/templates',
));
