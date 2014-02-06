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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_module']['pa2Mode']                      = array('Select view mode', 'Here you can select the view mode of the module.');
$GLOBALS['TL_LANG']['tl_module']['pa2PreviewImage']              = array('Preview image', 'Here you can define the output of the preview image.');
$GLOBALS['TL_LANG']['tl_module']['pa2OverviewPage']              = array('Album overview page', 'Select the album overview page, where you include this module.');
$GLOBALS['TL_LANG']['tl_module']['pa2DetailPage']                = array('Image view page', 'Select the image view page, where you include this module.');
$GLOBALS['TL_LANG']['tl_module']['pa2Archives']                  = array('Image album archive', 'Please choose one or more image album archives.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumSortType']             = array('Sort albums', 'Here you can select the order of photo albums for the summary page.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumSort']                 = array('Sort albums', 'Here you can sort the albums individually.');

$GLOBALS['TL_LANG']['tl_module']['pa2AlbumViewTemplate']         = array('Album overview template', 'Here you can select the template for the album overview.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImageViewTemplate']         = array('Image view template', 'Here you can select the template for the image view.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsTemplate']            = array('Album element template', 'Here you can select the template for the album element. This is used in the album overview for each album.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesTemplate']            = array('Image element template', 'Here you can select the template for the image element. This is used in the image view for each image.');
$GLOBALS['TL_LANG']['tl_module']['pa2NumberOfAlbums']            = array('Total number of albums', 'Here you can specify the total number of albums. Enter 0 to display all.');
$GLOBALS['TL_LANG']['tl_module']['pa2NumberOfImages']            = array('Total number of images', 'Here you can specify the total number of images. Enter 0 to display all.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsPerPage']             = array('Albums per page', 'The number of albums per page. Enter 0 to disable the automatic page break.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesPerPage']             = array('Images per Page', 'The number of images per page. Enter 0 to disable the automatic page break.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowHeadline']        = array('Show the module title in the album overview', 'Set this checkbox to display the module title in the album overview.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowHeadline']        = array('Show the module title in the image view', 'Set this checkbox to display the module title in the image view.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowTitle']           = array('Show the album title in the album overview', 'Set this checkbox to display the album title in the album overview.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowTitle']           = array('Show the album title in the image view', 'Set this checkbox to display the module title in the image view.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowTeaser']          = array('Show the teaser in the album overview', 'Set this checkbox to display the teaser in the album overview.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowTeaser']          = array('Show the teaser in the image view', 'Set this checkbox to display the teaser in the image view.');

$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsImageSize']           = array('Album overview image dimensions', 'Here you can set the image dimensions and the resize mode.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesImageSize']           = array('Image view image dimensions', 'Here you can set the image dimensions and the resize mode.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsImageMargin']         = array('Album overview image margin', 'Here you can enter the top, right, bottom and left margin and the unit.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesImageMargin']         = array('Image view image margin', 'Here you can enter the top, right, bottom and left margin and the unit.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsPerRow']              = array('Albums per row', 'Please enter the number of albums to display per row');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesPerRow']              = array('Images per row', 'Please enter the number of images to display per row');

$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowMetaDescriptions'] = array('Show meta descriptions in album overview', 'Set this checkbox to show the descriptions from the meta fields in the album overview.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsMetaFields']          = array('Album overview meta fields', 'Please select the meta fields to display in the album overview.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowMetaDescriptions'] = array('Show meta descriptions in image view', 'Set this checkbox to show the descriptions from the meta fields in the image view.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesMetaFields']          = array('Image view meta fields', 'Please select the meta fields to display in the image view.');

$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter']                = array('Time filter', 'Here you have the option of the image albums for a period previous filter.');
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilterStart']           = array('Period of', 'Enter the starting value of the period to be filtered. Example, if you enter 10 days, so the albums of the past 10 days are shown in the frontend. To start from today, enter the number "0".');
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilterEnd']             = array('Period up', 'Enter here the final value of the period to be filtered. For example, you should enter in the first field 10 days and in this field 5 days, the albums are displayed in the period before 10 days from 5 days before the front end. To add to the end of the period to today, enter the number "0".');

$GLOBALS['TL_LANG']['tl_module']['pa2Teaser']                    = array('Teaser', 'Here you can define a teaser. Make sure that the teaser is displayed only if you selected in the upper part of the form the output.');


/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_module']['pa2Album_legend']              = 'Album settings';
$GLOBALS['TL_LANG']['tl_module']['pa2Template_legend']           = 'Template settings';
$GLOBALS['TL_LANG']['tl_module']['pa2Image_legend']              = 'Image settings';
$GLOBALS['TL_LANG']['tl_module']['pa2Meta_legend']               = 'Meta settings';
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter_legend']         = 'Time filter settings';
$GLOBALS['TL_LANG']['tl_module']['pa2Other_legend']              = 'Other';
