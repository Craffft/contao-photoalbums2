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
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Pa2'                 => 'system/modules/photoalbums2/classes/Pa2.php',
	'Pa2Albums'           => 'system/modules/photoalbums2/classes/Pa2Albums.php',
	'Pa2Backend'          => 'system/modules/photoalbums2/classes/Pa2Backend.php',
	'Pa2Photos'           => 'system/modules/photoalbums2/classes/Pa2Photos.php',

	// Elements
	'ContentPhotoalbums2' => 'system/modules/photoalbums2/elements/ContentPhotoalbums2.php',

	// Modules
	'ModulePhotoalbums2'  => 'system/modules/photoalbums2/modules/ModulePhotoalbums2.php',
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
