<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2014 Leo Feyer
 *
 * @package    photoalbums2
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @license    LGPL
 * @copyright  Daniel Kiesel 2012-2014
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
