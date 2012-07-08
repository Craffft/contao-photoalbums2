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
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel 
 * @package    photoalbums2 
 * @license    LGPL 
 * @filesource
 */


/**
 * Backend Modules
 */
$GLOBALS['BE_MOD']['content']['photoalbums2'] = array
(
	'tables'		=> array('tl_photoalbums2_archive', 'tl_photoalbums2_album'),
	'icon'			=> 'system/modules/photoalbums2/html/icon.gif'
);


/**
 * Frontend Modules
 */
$GLOBALS['FE_MOD']['photoalbums2_legend']['photoalbums2'] = 'ModulePhotoalbums2';


/**
 * Content Elements
 */
$GLOBALS['TL_CTE']['images']['photoalbums2'] = 'ContentPhotoalbums2';


/**
 * Cron jobs
 */
$GLOBALS['TL_CRON']['daily'][] = array('Pa2', 'generateFeeds');


/**
 * Add permissions
 */
$GLOBALS['TL_PERMISSIONS'][] = 'photoalbums';
$GLOBALS['TL_PERMISSIONS'][] = 'photoalbump';


/**
 * Sort types
 */
$GLOBALS['Pa2']['pa2_sort_types'] = array
(
	'name_asc' => 'name_asc',
	'name_desc' => 'name_desc',
	'date_asc' => 'date_asc',
	'date_desc' => 'date_desc',
	'random' => 'random',
	'pic_sort_wizard' => 'pic_sort_wizard'
);


/**
 * Preview pic types
 */
$GLOBALS['Pa2']['pa2_preview_pic_types'] = array
(
	'no_preview_pic' => 'no_preview_pic',
	'random_preview_pic' => 'random_preview_pic',
	'select_preview_pic' => 'select_preview_pic'
);


/**
 * Preview pic module types
 */
$GLOBALS['Pa2']['pa2_preview_pic_module_types'] = array
(
	'use_album_options' => 'use_album_options',
	'no_preview_pics' => 'no_preview_pics',
	'random_pics' => 'random_pics',
	'random_pics_at_no_preview_pics' => 'random_pics_at_no_preview_pics'
);


/**
 * Meta fields
 */
$GLOBALS['Pa2']['metaFields'] = array('date', 'event', 'place', 'photographer', 'description');

?>