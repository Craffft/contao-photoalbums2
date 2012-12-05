<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Fabian Eisele 2012 
 * @author     Fabian Eisele 
 * @package    photoalbums2 - Language pack 
 * @license    LGPL 
 * @filesource
 */


/**
 * Content elements
 */
$GLOBALS['TL_LANG']['CTE']['photoalbums2']  = array('Photoalbum', 'Generates a photoalbum.');


/**
 * Miscellaneous
 */
$GLOBALS['TL_LANG']['MSC']['albumsEmpty'] = 'No photo albums available!';
$GLOBALS['TL_LANG']['MSC']['photosEmpty'] = 'The photo album could not be found!';


/**
 * Sort types
 */
$GLOBALS['TL_LANG']['pa2_sort_types']['metatitle_asc'] = array('Meta title (ascending)', 'Meta title (ascending)');
$GLOBALS['TL_LANG']['pa2_sort_types']['metatitle_desc'] = array('Meta title (descending)', 'Meta title (descending)');
$GLOBALS['TL_LANG']['pa2_sort_types']['name_asc'] = array('Name (ascending)', 'Name (ascending)');
$GLOBALS['TL_LANG']['pa2_sort_types']['name_desc'] = array('Name (descending)', 'Name (descending)');
$GLOBALS['TL_LANG']['pa2_sort_types']['date_asc'] = array('Date (ascending)', 'Date (ascending)');
$GLOBALS['TL_LANG']['pa2_sort_types']['date_desc'] = array('Date (descending)', 'Date (descending)');
$GLOBALS['TL_LANG']['pa2_sort_types']['random'] = array('Random output', 'Random output');
$GLOBALS['TL_LANG']['pa2_sort_types']['custom'] = array('Own sorting', 'Own sorting');


/**
 * Pic preview types
 */
$GLOBALS['TL_LANG']['pa2_preview_pic_types']['no_preview_pic'] = array('No preview photo', 'No preview photo');
$GLOBALS['TL_LANG']['pa2_preview_pic_types']['random_preview_pic'] = array('Random preview photo', 'Random preview photo');
$GLOBALS['TL_LANG']['pa2_preview_pic_types']['select_preview_pic'] = array('Select preview photo', 'Select preview photo');


/**
 * Pic preview types
 */
$GLOBALS['TL_LANG']['pa2_preview_pic_module_types']['use_album_options'] = array('Settings of album take over', 'Settings of album take over');
$GLOBALS['TL_LANG']['pa2_preview_pic_module_types']['no_preview_pics'] = array('No preview photos', 'No preview photos');
$GLOBALS['TL_LANG']['pa2_preview_pic_module_types']['random_pics'] = array('Random preview photos', 'Random preview photos');
$GLOBALS['TL_LANG']['pa2_preview_pic_module_types']['random_pics_at_no_preview_pics'] = array('Random preview pictures at an undefined use preview photo', 'Random preview pictures at an undefined use preview photo');


/**
 * Mode types
 */
$GLOBALS['TL_LANG']['pa2_mode_types']['pa2_on_one_page'] = array('Foto-Ansicht und Alben-Ansicht auf gleicher Seite darstellen (Standard)', 'Wählen Sie diese Einstellung, damit beide Ansichtsarten auf der gleichen Seite dargestellt werden.');
$GLOBALS['TL_LANG']['pa2_mode_types']['pa2_only_album_view'] = array('Nur Album-Ansicht verwenden und Lightbox direkt einbinden', 'Wählen Sie diese Einstellung um nur die Alben-Ansicht zu verwenden. Bei einem Klick auf ein Album öffnet sich dann direkt die Ligabox mit den Bildern aus dem Fotoalbum.');
$GLOBALS['TL_LANG']['pa2_mode_types']['pa2_with_detail_page'] = array('Foto-Ansicht auf einer anderen Seite anzeigen', 'Wählen Sie diese Einstellung, damit die Foto-Ansicht und die Alben-Ansicht auf zwei verschiedenen Seiten dargestellt werden kann.');


/**
 * Meta fields
 */
$GLOBALS['TL_LANG']['pa2']['pa2MetaFields_options']['date'] = 'Capture date';
$GLOBALS['TL_LANG']['pa2']['pa2MetaFields_options']['event'] = 'Event';
$GLOBALS['TL_LANG']['pa2']['pa2MetaFields_options']['place'] = 'Place';
$GLOBALS['TL_LANG']['pa2']['pa2MetaFields_options']['photographer'] = 'Photographer';
$GLOBALS['TL_LANG']['pa2']['pa2MetaFields_options']['description'] = 'Description';


/**
 * Time filter
 */
$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options']['seconds'] = 'second(s)';
$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options']['minutes'] = 'minute(s)';
$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options']['hours'] = 'hour(s)';
$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options']['days'] = 'day(s)';
$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options']['weeks'] = 'week(s)';
$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options']['months'] = 'month(s)';
$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options']['years'] = 'year(s)';

?>