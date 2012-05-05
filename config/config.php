<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
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
	'icon'			=> 'system/modules/photoalbums2/html/icon.gif',
	'stylesheet'	=> 'system/modules/photoalbums2/html/style.css'
);


/**
 * Frontend Modules
 */
$GLOBALS['FE_MOD']['photoalbums2_legend']['photoalbums2'] = 'ModulePhotoalbums2';


/**
 * Add permissions
 */
$GLOBALS['TL_PERMISSIONS'][] = 'photoalbums';
$GLOBALS['TL_PERMISSIONS'][] = 'photoalbump';
 
?>