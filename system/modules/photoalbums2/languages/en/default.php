<?php

/**
 * Extension for Contao Open Source CMS
 *
 * Copyright (c) 2012-2014 Daniel Kiesel
 *
 * @package Photoalbums2
 * @link    https://github.com/craffft/contao-photoalbums
 * @author  Fabian Eisele
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Content elements
 */
$GLOBALS['TL_LANG']['CTE']['photoalbums2']  = array('Photoalbum', 'Generates a photoalbum.');

/**
 * Miscellaneous
 */
$GLOBALS['TL_LANG']['MSC']['albumsNotFound'] = 'There are no image albums available!';
$GLOBALS['TL_LANG']['MSC']['albumNotFound'] = 'The image album could not be found!';
$GLOBALS['TL_LANG']['MSC']['imagesNotFound'] = 'The image album has no images!';

/**
 * Pa2 miscellaneous
 */
$GLOBALS['TL_LANG']['PA2']['goBack'] = 'Back';

/**
 * Sort types
 */
$GLOBALS['TL_LANG']['PA2']['imageSortTypes']['metatitle_asc'] = array('Meta title (ascending)', 'Meta title (ascending)');
$GLOBALS['TL_LANG']['PA2']['imageSortTypes']['metatitle_desc'] = array('Meta title (descending)', 'Meta title (descending)');
$GLOBALS['TL_LANG']['PA2']['imageSortTypes']['name_asc'] = array('Name (ascending)', 'Name (ascending)');
$GLOBALS['TL_LANG']['PA2']['imageSortTypes']['name_desc'] = array('Name (descending)', 'Name (descending)');
$GLOBALS['TL_LANG']['PA2']['imageSortTypes']['date_asc'] = array('Date (ascending)', 'Date (ascending)');
$GLOBALS['TL_LANG']['PA2']['imageSortTypes']['date_desc'] = array('Date (descending)', 'Date (descending)');
$GLOBALS['TL_LANG']['PA2']['imageSortTypes']['random'] = array('Random output', 'Random output');
$GLOBALS['TL_LANG']['PA2']['imageSortTypes']['custom'] = array('Own sorting', 'Own sorting');

/**
 * Image preview types
 */
$GLOBALS['TL_LANG']['PA2']['albumPreviewImageTypes']['no_preview_image'] = array('No preview image', 'No preview image');
$GLOBALS['TL_LANG']['PA2']['albumPreviewImageTypes']['random_preview_image'] = array('Random preview image', 'Random preview image');
$GLOBALS['TL_LANG']['PA2']['albumPreviewImageTypes']['select_preview_image'] = array('Select preview image', 'Select preview image');

/**
 * Image preview types
 */
$GLOBALS['TL_LANG']['PA2']['previewImageModuleTypes']['use_album_options'] = array('Settings of album take over', 'Settings of album take over');
$GLOBALS['TL_LANG']['PA2']['previewImageModuleTypes']['no_preview_images'] = array('No preview images', 'No preview images');
$GLOBALS['TL_LANG']['PA2']['previewImageModuleTypes']['random_images'] = array('Random preview images', 'Random preview images');
$GLOBALS['TL_LANG']['PA2']['previewImageModuleTypes']['random_images_at_no_preview_images'] = array('Random preview images at an undefined use preview image', 'Random preview images at an undefined use preview image');

/**
 * Mode types
 */
$GLOBALS['TL_LANG']['PA2']['moduleModeTypes']['pa2_on_one_page'] = array('Album overview and image view on one page (default)', 'Represents the album overview and the image view on the same page.');
$GLOBALS['TL_LANG']['PA2']['moduleModeTypes']['pa2_only_album_view'] = array('Use only album overview with lightbox', 'Displays only the album overview. If you click on an album, the lightbox opens and displays all the photos from the photo album.');
$GLOBALS['TL_LANG']['PA2']['moduleModeTypes']['pa2_with_detail_page'] = array('Show album overview and image view on defferent pages', 'Represents the album overview and the image view on different pages. Bind therefore this module in both pages.');

/**
 * Album sort types
 */
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['title_asc'] = array('Name (ascending)', 'Name (ascending)');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['title_desc'] = array('Name (descending)', 'Name (descending)');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['startdate_asc'] = array('Startdate (ascending)', 'Startdate (ascending)');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['startdate_desc'] = array('Startdate (descending)', 'Startdate (descending)');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['enddate_asc'] = array('Enddate (ascending)', 'Enddate (ascending)');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['enddate_desc'] = array('Enddate (descending)', 'Enddate (descending)');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['numberOfImages_asc'] = array('Number of images (ascending)', 'Number of images (ascending)');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['numberOfImages_desc'] = array('Number of images (descending)', 'Number of images (descending)');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['random'] = array('Random output', 'Random output');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['custom'] = array('Own sorting', 'Own sorting');

/**
 * Meta fields
 */
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldOptions']['date'] = 'Capture date';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldOptions']['event'] = 'Event';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldOptions']['place'] = 'Place';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldOptions']['photographer'] = 'Photographer';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldOptions']['description'] = 'Description';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldOptions']['numberOfAllImages'] = 'Number of images';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldDescription']['date'] = 'Capture date: %s';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldDescription']['event'] = 'Event: %s';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldDescription']['place'] = 'Place: %s';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldDescription']['photographer'] = 'Photographer: %s';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldDescription']['description'] = 'Description: %s';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldDescription']['numberOfAllImages'] = array('Quantity: %s image', 'Quantity: %s images');
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldWithoutDescription']['numberOfAllImages'] = array('%s image', '%s images');

/**
 * Time filter
 */
$GLOBALS['TL_LANG']['PA2']['pa2TimeFilterOptions']['seconds'] = 'second(s)';
$GLOBALS['TL_LANG']['PA2']['pa2TimeFilterOptions']['minutes'] = 'minute(s)';
$GLOBALS['TL_LANG']['PA2']['pa2TimeFilterOptions']['hours'] = 'hour(s)';
$GLOBALS['TL_LANG']['PA2']['pa2TimeFilterOptions']['days'] = 'day(s)';
$GLOBALS['TL_LANG']['PA2']['pa2TimeFilterOptions']['weeks'] = 'week(s)';
$GLOBALS['TL_LANG']['PA2']['pa2TimeFilterOptions']['months'] = 'month(s)';
$GLOBALS['TL_LANG']['PA2']['pa2TimeFilterOptions']['years'] = 'year(s)';
