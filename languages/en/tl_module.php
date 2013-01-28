<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2013 Leo Feyer
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
 * @copyright  Fabian Eisele 2012
 * @author     Fabian Eisele
 * @package    photoalbums2 - Language pack
 * @license    LGPL
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_module']['pa2Mode']               = array('Select view mode', 'Here you can select the view mode of the module.');
$GLOBALS['TL_LANG']['tl_module']['pa2PreviewImage']       = array('Preview image', 'Here you can define the output of the preview image.');
$GLOBALS['TL_LANG']['tl_module']['pa2DetailPage']         = array('Image view on another page', 'Normally, the album view and the image view are on the same page. If it is necessary to use different pages, choose here the page for the image view.<br>Please use the "auto_item"-parameter.');
$GLOBALS['TL_LANG']['tl_module']['pa2Archives']           = array('Image album archive', 'Please choose one or more image album archives.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumSortType']      = array('Sort albums', 'Here you can select the order of photo albums for the summary page.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumSort']          = array('Sort albums', 'Here you can sort the albums individually.');

$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsTemplate']     = array('Album Layout', 'Please choose here the layout of the album.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesTemplate']     = array('Image Layout', 'Please choose here the layout of the images.');
$GLOBALS['TL_LANG']['tl_module']['pa2NumberOfAlbums']     = array('Total number of albums', 'Here you can specify the total number of albums. Enter 0 to display all.');
$GLOBALS['TL_LANG']['tl_module']['pa2NumberOfImages']     = array('Total number of images', 'Here you can specify the total number of images. Enter 0 to display all.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsPerPage']      = array('Albums per page', 'The number of albums per page. Enter 0 to disable the automatic page break.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesPerPage']      = array('Images per Page', 'The number of images per page. Enter 0 to disable the automatic page break.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowHeadline'] = array('Show the module title in the album view', 'Set this checkbox to display the module title in the album view.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowHeadline'] = array('Show the module title in the image view', 'Set this checkbox to display the module title in the image view.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowTitle']    = array('Show the album title in the album view', 'Set this checkbox to display the album title in the album view.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowTitle']    = array('Show the album title in the image view', 'Set this checkbox to display the module title in the image view.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowTeaser']   = array('Show the teaser in the album view', 'Set this checkbox to display the teaser in the album view.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowTeaser']   = array('Show the teaser in the image view', 'Set this checkbox to display the teaser in the image view.');

$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsImageSize']    = array('Album view image dimensions', 'Here you can set the image dimensions and the resize mode.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesImageSize']    = array('Image view image dimensions', 'Here you can set the image dimensions and the resize mode.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsImageMargin']  = array('Album view image margin', 'Here you can enter the top, right, bottom and left margin and the unit.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesImageMargin']  = array('Image view image margin', 'Here you can enter the top, right, bottom and left margin and the unit.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsPerRow']       = array('Albums per row', 'Please enter the number of albums to display per row');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesPerRow']       = array('Images per row', 'Please enter the number of images to display per row');

$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsMetaFields']   = array('Album view meta fields', 'Please select the meta fields to display in the album view.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesMetaFields']   = array('Image view meta fields', 'Please select the meta fields to display in the image view.');

$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter']         = array('Time filter', 'Here you have the option of the image albums for a period previous filter.');
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilterStart']    = array('Period of', 'Enter the starting value of the period to be filtered. Example, if you enter 10 days, so the albums of the past 10 days are shown in the frontend. To start from today, enter the number "0".');
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilterEnd']      = array('Period up', 'Enter here the final value of the period to be filtered. For example, you should enter in the first field 10 days and in this field 5 days, the albums are displayed in the period before 10 days from 5 days before the front end. To add to the end of the period to today, enter the number "0".');

$GLOBALS['TL_LANG']['tl_module']['pa2Teaser']             = array('Teaser', 'Here you can define a teaser. Make sure that the teaser is displayed only if you selected in the upper part of the form the output.');


/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_module']['pa2Album_legend']       = 'Album settings';
$GLOBALS['TL_LANG']['tl_module']['pa2Template_legend']    = 'Template settings';
$GLOBALS['TL_LANG']['tl_module']['pa2Image_legend']       = 'Image settings';
$GLOBALS['TL_LANG']['tl_module']['pa2Meta_legend']        = 'Meta settings';
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter_legend']  = 'Time filter settings';
$GLOBALS['TL_LANG']['tl_module']['pa2Other_legend']       = 'Other';

?>