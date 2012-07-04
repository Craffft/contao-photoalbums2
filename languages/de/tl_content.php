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
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel 
 * @package    photoalbums2 
 * @license    LGPL 
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_content']['pa2Album'] = array('Fotoalbum wählen', 'Bitte wählen Sie Ihr gewünschtes Fotoalbum aus.');

$GLOBALS['TL_LANG']['tl_content']['pa2PhotosTemplate'] = array('Fotos Template', 'Wählen Sie hier das Template für die Fotos aus.');
$GLOBALS['TL_LANG']['tl_content']['pa2NumberOfPhotos'] = array('Gesamtzahl der Fotos', 'Hier können Sie die Gesamtzahl der Fotos festlegen. Geben Sie 0 ein, um alle anzuzeigen.');
$GLOBALS['TL_LANG']['tl_content']['pa2PhotosPerPage'] = array('Fotos pro Seite', 'Die Anzahl an Fotos pro Seite. Geben Sie 0 ein, um den automatischen Seitenumbruch zu deaktivieren.');
$GLOBALS['TL_LANG']['tl_content']['pa2PhotosShowHeadline'] = array('Modul Überschrift in Foto-Ansicht anzeigen', 'Setzen Sie dieses Häkchen, um die Modul Überschrift in der Foto-Ansicht anzuzeigen.');
$GLOBALS['TL_LANG']['tl_content']['pa2PhotosShowTitle'] = array('Alben Titel in Foto-Ansicht anzeigen', 'Setzen Sie dieses Häkchen, um den Titel des Albums in der Foto-Ansicht anzuzeigen.');
$GLOBALS['TL_LANG']['tl_content']['pa2PhotosShowTeaser'] = array('Teaser in Foto-Ansicht anzeigen', 'Setzen Sie dieses Häkchen, um den Teaser in der Foto-Ansicht anzuzeigen.');

$GLOBALS['TL_LANG']['tl_content']['pa2PhotosImageSize'] = array('Foto-Ansicht Bildbreite und Bildhöhe', 'Hier können Sie die Abmessungen des Bildes und den Skalierungsmodus festlegen.');
$GLOBALS['TL_LANG']['tl_content']['pa2PhotosImageMargin'] = array('Foto-Ansicht Bildabstand', 'Hier können Sie den oberen, rechten, unteren und linken Bildabstand eingeben.');
$GLOBALS['TL_LANG']['tl_content']['pa2PhotosPerRow'] = array('Fotos pro Zeile', 'Bitte legen Sie fest, wie viele Fotos pro Zeile angezeigt werden sollen.');

$GLOBALS['TL_LANG']['tl_content']['pa2PhotosMetaFields'] = array('Foto-Ansicht Meta Felder', 'Bitte wählen Sie die Meta Felder aus, die in der Foto-Ansicht ausgegeben werden sollen.');

$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilter'] = array('Zeitfilter', 'Hier haben Sie die Möglichkeit, die Fotoalben über einen vergangenen Zeitraum zu filtern.');
$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilterStart'] = array('Zeitraum von', 'Tragen Sie hier den Startwert des zu filternden Zeitraumes ein. Sollten Sie beispielsweise 10 Tage eintragen, so werden die Alben der vergangenen 10 Tage im Frontend angezeigt. Um von heute aus zu starten, tragen Sie die Zahl "0" ein.');
$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilterEnd'] = array('Zeitraum bis', 'Tragen Sie hier den Endwert des zu filternden Zeitraumes ein. Sollten Sie beispielsweise im ersten Feld 10 Tage und in diesem Feld 5 Tage eintragen, so werden die Alben im Zeitraum von vor 10 Tagen bis von vor 5 Tagen im Frontend angezeigt. Um das Ende des Zeitraumes auf heute zu legen, tragen Sie die Zahl "0" ein.');

$GLOBALS['TL_LANG']['tl_content']['pa2Teaser'] = array('Teaser', 'Hier können Sie einen Teaser definieren. Achten Sie darauf, dass der Teaser nur angezeigt wird, wenn Sie im oberen Teil des Formulars die Ausgabe aktiviert haben.');


/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_content']['config_legend'] = 'Konfiguration';
$GLOBALS['TL_LANG']['tl_content']['pa2Template_legend'] = 'Template Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['pa2Image_legend'] = 'Foto Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['pa2Meta_legend'] = 'Meta Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilter_legend'] = 'Zeitfilter';
$GLOBALS['TL_LANG']['tl_content']['pa2Other_legend'] = 'Sonstiges';

?>