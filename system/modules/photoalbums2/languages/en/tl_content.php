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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_content']['pa2Album']                     = array('Select album', 'Please select your favourite album.');

$GLOBALS['TL_LANG']['tl_content']['pa2ImageViewTemplate']         = array('Image view template', 'Here you can select the template for the image view.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesTemplate']            = array('Image element template', 'Here you can select the template for the image element. This is used in the image view for each image.');
$GLOBALS['TL_LANG']['tl_content']['pa2NumberOfImages']            = array('Total number of images', 'Here you can specify the total number of images. Enter 0 to display all.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesPerPage']             = array('Images per Page', 'The number of images per page. Enter 0 to disable the automatic page break.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesShowHeadline']        = array('Show the module title in the image view', 'Set this checkbox to display the module title in the image view.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesShowTitle']           = array('Show the album title in the image view', 'Set this checkbox to display the module title in the image view.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesShowTeaser']          = array('Teaser in Foto-Ansicht anzeigen', 'Setzen Sie dieses Häkchen, um den Teaser in der Foto-Ansicht anzuzeigen.');

$GLOBALS['TL_LANG']['tl_content']['pa2ImagesImageSize']           = array('Image view image dimensions', 'Here you can set the image dimensions and the resize mode.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesImageMargin']         = array('Image view image margin', 'Here you can enter the top, right, bottom and left margin and the unit.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesPerRow']              = array('Images per row', 'Please enter the number of images to display per row');

$GLOBALS['TL_LANG']['tl_content']['pa2ImagesShowMetaDescriptions'] = array('Show meta descriptions in image view', 'Set this checkbox to show the descriptions from the meta fields in the image view.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesMetaFields']          = array('Foto-Ansicht Meta Felder', 'Please select the meta fields to display in the image view.');

$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilter']                = array('Time filter', 'Here you have the option of the image albums for a period previous filter.');
$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilterStart']           = array('Period of', 'Enter the starting value of the period to be filtered. Example, if you enter 10 days, so the albums of the past 10 days are shown in the frontend. To start from today, enter the number "0".');
$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilterEnd']             = array('Period up', 'Enter here the final value of the period to be filtered. For example, you should enter in the first field 10 days and in this field 5 days, the albums are displayed in the period before 10 days from 5 days before the front end. To add to the end of the period to today, enter the number "0".');

$GLOBALS['TL_LANG']['tl_content']['pa2Teaser']                    = array('Teaser', 'Here you can define a teaser. Make sure that the teaser is displayed only if you selected in the upper part of the form the output.');

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_content']['config_legend']                = 'Configuration';
$GLOBALS['TL_LANG']['tl_content']['pa2Template_legend']           = 'Template settings';
$GLOBALS['TL_LANG']['tl_content']['pa2Image_legend']              = 'Image settings';
$GLOBALS['TL_LANG']['tl_content']['pa2Meta_legend']               = 'Meta settings';
$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilter_legend']         = 'Time filter settings';
$GLOBALS['TL_LANG']['tl_content']['pa2Other_legend']              = 'Other';
