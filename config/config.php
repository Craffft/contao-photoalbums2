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


// Add BE CSS
if (TL_MODE == 'BE')
{
	$GLOBALS['TL_CSS'][] = 'system/modules/photoalbums2/assets/photoalbums2_be.css';
}

// Backend Modules
$GLOBALS['BE_MOD']['content']['photoalbums2'] = array
(
	'tables' => array('tl_photoalbums2_archive', 'tl_photoalbums2_album'),
	'icon'   => 'system/modules/photoalbums2/assets/icon.gif'
);

// Frontend Modules
$GLOBALS['FE_MOD']['photoalbums2_legend']['photoalbums2'] = 'ModulePhotoalbums2';
$GLOBALS['FE_MOD']['photoalbums2_legend']['photoalbums2list'] = 'ModulePhotoalbums2List';
$GLOBALS['FE_MOD']['photoalbums2_legend']['photoalbums2view'] = 'ModulePhotoalbums2View';

// Content Elements
$GLOBALS['TL_CTE']['media']['photoalbums2'] = 'ContentPhotoalbums2';

// Cron jobs
$GLOBALS['TL_CRON']['daily'][] = array('Pa2', 'generateFeeds');

// Add permissions
$GLOBALS['TL_PERMISSIONS'][] = 'photoalbums2s';
$GLOBALS['TL_PERMISSIONS'][] = 'photoalbums2p';


// Define global pa2
$GLOBALS['pa2'] = array();

// Image sort types
$GLOBALS['pa2']['imageSortTypes'] = array
(
	'metatitle_asc'                      => 'metatitle_asc',
	'metatitle_desc'                     => 'metatitle_desc',
	'name_asc'                           => 'name_asc',
	'name_desc'                          => 'name_desc',
	'date_asc'                           => 'date_asc',
	'date_desc'                          => 'date_desc',
	'random'                             => 'random',
	'custom'                             => 'custom'
);

$GLOBALS['pa2']['albumSortTypes'] = array
(
	'title_asc'                          => 'title_asc',
	'title_desc'                         => 'title_desc',
	'startdate_asc'                      => 'startdate_asc',
	'startdate_desc'                     => 'startdate_desc',
	'enddate_asc'                        => 'enddate_asc',
	'enddate_desc'                       => 'enddate_desc',
	'numberOfImages_asc'                 => 'numberOfImages_asc',
	'numberOfImages_desc'                => 'numberOfImages_desc',
	'random'                             => 'random',
	'custom'                             => 'custom'
);

// Album image preview types
$GLOBALS['pa2']['albumPreviewImageTypes'] = array
(
	'no_preview_image'                   => 'no_preview_image',
	'random_preview_image'               => 'random_preview_image',
	'select_preview_image'               => 'select_preview_image'
);

// Module image preview types
$GLOBALS['pa2']['modulePreviewImageTypes'] = array
(
	'use_album_options'                  => 'use_album_options',
	'no_preview_images'                  => 'no_preview_images',
	'random_images'                      => 'random_images',
	'random_images_at_no_preview_images' => 'random_images_at_no_preview_images'
);

// Time filter options
$GLOBALS['pa2']['timeFilterOptions'] = array('days', 'weeks', 'months', 'years');

// Meta fields
$GLOBALS['pa2']['metaFields'] = array('date', 'event', 'place', 'photographer', 'description', 'numberOfAllImages');
