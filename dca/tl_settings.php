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
 * Extend palette
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{photoalbums2_legend},pa2HidePreviewImageInBackend';


/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['pa2HidePreviewImageInBackend'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['pa2HidePreviewImageInBackend'],
	'inputType'               => 'checkbox'
);
