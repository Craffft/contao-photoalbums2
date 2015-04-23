<?php

/**
 * Extension for Contao Open Source CMS
 *
 * Copyright (c) 2012-2014 Daniel Kiesel
 *
 * @package Photoalbums2
 * @link    https://github.com/craffft/contao-photoalbums
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Extend default palette
 */
$GLOBALS['TL_DCA']['tl_user_group']['palettes']['default'] = str_replace('fop;', 'fop;{photoalbums2_legend},photoalbums2s,photoalbums2p;', $GLOBALS['TL_DCA']['tl_user_group']['palettes']['default']);

/**
 * Add fields to tl_user_group
 */
$GLOBALS['TL_DCA']['tl_user_group']['fields']['photoalbums2s'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_user']['photoalbums2s'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'foreignKey'              => 'tl_photoalbums2_archive.title',
    'eval'                    => array('multiple' => true),
    'sql'                     => "blob NULL",
);

$GLOBALS['TL_DCA']['tl_user_group']['fields']['photoalbums2p'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_user']['photoalbums2p'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'options'                 => array('create', 'delete'),
    'reference'               => &$GLOBALS['TL_LANG']['MSC'],
    'eval'                    => array('multiple' => true),
    'sql'                     => "blob NULL",
);
