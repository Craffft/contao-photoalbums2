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
 * Extend palette
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{photoalbums2_legend},pa2HidePreviewImageInBackend';

/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['pa2HidePreviewImageInBackend'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['pa2HidePreviewImageInBackend'],
    'inputType'               => 'checkbox',
);
