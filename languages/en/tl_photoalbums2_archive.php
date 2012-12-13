<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
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
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['title'] = array('Title', 'Please enter the title of the image album archive.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['allowComments'] = array('Enable comments', 'Allow visitors to comment albums.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['notify'] = array('Notify', 'Please choose who to notify when comments are added.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['sortOrder'] = array('Sort order', 'By default, comments are sorted ascending, starting with the oldest one.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['perPage'] = array('Comments per page', 'Number of comments per page. Set to 0 to disable pagination.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['moderate'] = array('Moderate comments', 'Approve comments before they are published on the website.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['bbcode'] = array('Allow BBCode', 'Allow visitors to format their comments with BBCode.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['requireLogin'] = array('Require login to comment', 'Allow only authenticated users to create comments.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['disableCaptcha'] = array('Disable the security question', 'Use this option only if you have limited comments to authenticated users.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['protected'] = array('Protect archive', 'Restrict here the access to the image album archive.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['users'] = array('Members', 'Choose the members who have access to the image album archive.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['groups'] = array('Member groups', 'Choose the member groups who have access to the image album archive.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['makeFeed'] = array('Generate feed', 'Generate an RSS or Atom feed from the imagearchive.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['format'] = array('Feed format', 'Please choose a feed format.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['language'] = array('Feed language', 'Please enter the feed language according to the ISO-639 standard (e.g. <em>en</em> or <em>en-us</em>).');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['modulePage'] = array('Module URL', 'Please enter the URL of details page, which uses the module to image albums.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['maxItems'] = array('Maximum number of items', 'Here you can limit the number of feed items. Set to 0 to export all.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['feedBase'] = array('Base URL', 'Please enter the base URL with protocol (e.g. <em>http://</em>).');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['alias'] = array('Feed alias', 'Here you can enter a unique filename (without extension). The XML feed file will be auto-generated in the root directory of your Contao installation, e.g. as <em>name.xml</em>.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['description'] = array('Feed description', 'Please enter a short description of the image archive feed.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['tstamp'] = array('Revision date', 'Date and time of the latest revision');


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['title_legend'] = 'Title';
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['comments_legend'] = 'Comments';
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['protected_legend'] = 'Access protection';
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['feed_legend'] = 'RSS/Atom feed';


/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['notify_admin'] = 'System administrator';
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['notify_author'] = 'Author of the news item';
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['notify_both'] = 'Author and system administrator';


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['new'] = array('Create new image album archive', 'Create a new image album archive');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['edit'] = array('Edit image album archive', 'Edit the image album archive ID %s');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['copy'] = array('Copy image album archive', 'Copy image album archive ID %s');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['delete'] = array('Delete image album archive', 'Delete image album archive ID %s');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['show'] = array('Show details of the image album archive', 'Show details of the image album archive ID %s');

?>