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
    'inputType'               => 'checkbox',
    'sql'                     => "char(1) NOT NULL default ''"
);
