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
 * Table tl_layout
 */

// Add field to palette
$GLOBALS['TL_DCA']['tl_layout']['palettes']['default'] = str_replace('skipTinymce', 'skipPhotoalbums2,skipTinymce', $GLOBALS['TL_DCA']['tl_layout']['palettes']['default']);

// Define field
$GLOBALS['TL_DCA']['tl_layout']['fields']['skipPhotoalbums2'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['skipPhotoalbums2'],
    'default'                 => '',
    'exclude'                 => true,
    'inputType'               => 'checkbox'
);

?>