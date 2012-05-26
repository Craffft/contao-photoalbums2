<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
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
$GLOBALS['TL_LANG']['tl_module']['pa2Archives'] = array('Fotoalben-Archive', 'Bitte wählen Sie ein oder mehrere Fotoalben-Archive.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsTemplate'] = array('Alben Template', 'Wählen Sie hier das Template für die Alben aus.');
$GLOBALS['TL_LANG']['tl_module']['pa2PhotosTemplate'] = array('Fotos Template', 'Wählen Sie hier das Template für die Fotos aus.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsPerPage'] = array('Alben pro Seite', 'Die Anzahl an Alben pro Seite. Geben Sie 0 ein, um den automatischen Seitenumbruch zu deaktivieren.');
$GLOBALS['TL_LANG']['tl_module']['pa2PhotosPerPage'] = array('Fotos pro Seite', 'Die Anzahl an Fotos pro Seite. Geben Sie 0 ein, um den automatischen Seitenumbruch zu deaktivieren.');
$GLOBALS['TL_LANG']['tl_module']['pa2NumberOfAlbums'] = array('Gesamtzahl der Alben', 'Hier können Sie die Gesamtzahl der Alben festlegen. Geben Sie 0 ein, um alle anzuzeigen.');
$GLOBALS['TL_LANG']['tl_module']['pa2NumberOfPhotos'] = array('Gesamtzahl der Fotos', 'Hier können Sie die Gesamtzahl der Fotos festlegen. Geben Sie 0 ein, um alle anzuzeigen.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsImageSize'] = array('Alben-Ansicht Bildbreite und Bildhöhe', 'Hier können Sie die Abmessungen des Bildes und den Skalierungsmodus festlegen.');
$GLOBALS['TL_LANG']['tl_module']['pa2PhotosImageSize'] = array('Foto-Ansicht Bildbreite und Bildhöhe', 'Hier können Sie die Abmessungen des Bildes und den Skalierungsmodus festlegen.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsImageMargin'] = array('Alben-Ansicht Bildabstand', 'Hier können Sie den oberen, rechten, unteren und linken Bildabstand eingeben.');
$GLOBALS['TL_LANG']['tl_module']['pa2PhotosImageMargin'] = array('Foto-Ansicht Bildabstand', 'Hier können Sie den oberen, rechten, unteren und linken Bildabstand eingeben.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsPerRow'] = array('Alben pro Zeile', 'Bitte legen Sie fest, wie viele Alben pro Zeile angezeigt werden sollen.');
$GLOBALS['TL_LANG']['tl_module']['pa2PhotosPerRow'] = array('Fotos pro Zeile', 'Bitte legen Sie fest, wie viele Fotos pro Zeile angezeigt werden sollen.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsMetaFields'] = array('Alben-Ansicht Meta Felder', 'Bitte wählen Sie die Meta Felder aus, die in der Alben-Ansicht ausgegeben werden sollen.');
$GLOBALS['TL_LANG']['tl_module']['pa2PhotosMetaFields'] = array('Foto-Ansicht Meta Felder', 'Bitte wählen Sie die Meta Felder aus, die in der Foto-Ansicht ausgegeben werden sollen.');
$GLOBALS['TL_LANG']['tl_module']['pa2DetailPage'] = array('Foto-Ansicht auf einer anderen Seite anzeigen', 'Im Normalfall wird die Alben-Ansicht und die Foto-Ansicht auf der gleichen Seite dargestellt. Manchmal ist es jedoch nötig diese Beiden Seitenansichten auf zwei verschiedenen Seiten darzustellen. Damit Sie dies tun können, wählen Sie hier einfach die Seite aus, auf der die Foto-Ansicht dargestellt werden soll. Danach fügen Sie dieses Modul einmal auf der ausgewählten Seite und einmal auf einer anderen Seite ein. Auf der anderen Seite ist dann die Alben-Ansicht zu sehen.<br>Kleiner Tipp: Es empfiehlt sich den "auto_item-Parameter" zu verwenden.');
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter'] = array('Zeitfilter', 'Hier haben Sie die Möglichkeit, die Fotoalben über einen vergangenen Zeitraum zu filtern.');
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilterStart'] = array('Zeitraum von', 'Tragen Sie hier den Startwert des zu filternden Zeitraumes ein. Sollten Sie beispielsweise 10 Tage eintragen, so werden die Alben der vergangenen 10 Tage im Frontend angezeigt. Um von heute aus zu starten, tragen Sie die Zahl "0" ein.');
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilterEnd'] = array('Zeitraum bis', 'Tragen Sie hier den Endwert des zu filternden Zeitraumes ein. Sollten Sie beispielsweise im ersten Feld 10 Tage und in diesem Feld 5 Tage eintragen, so werden die Alben im Zeitraum von vor 10 Tagen bis von vor 5 Tagen im Frontend angezeigt. Um das Ende des Zeitraumes auf heute zu legen, tragen Sie die Zahl "0" ein.');


/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_module']['pa2Image_legend'] = 'Foto Einstellungen';
$GLOBALS['TL_LANG']['tl_module']['pa2Meta_legend'] = 'Meta Einstellungen';
$GLOBALS['TL_LANG']['tl_module']['pa2PageView_legend'] = 'Seitenansicht Einstellungen';
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter_legend'] = 'Zeitfilter Einstellungen';

$GLOBALS['TL_LANG']['tl_module']['pa2MetaFields_options']['date'] = 'Aufnahmedatum';
$GLOBALS['TL_LANG']['tl_module']['pa2MetaFields_options']['event'] = 'Ereignis';
$GLOBALS['TL_LANG']['tl_module']['pa2MetaFields_options']['place'] = 'Aufnahmeort';
$GLOBALS['TL_LANG']['tl_module']['pa2MetaFields_options']['photographer'] = 'Fotograf';
$GLOBALS['TL_LANG']['tl_module']['pa2MetaFields_options']['description'] = 'Beschreibung';

$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter_options']['seconds'] = 'Sekunde(n)';
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter_options']['minutes'] = 'Minute(n)';
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter_options']['hours'] = 'Stunde(n)';
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter_options']['days'] = 'Tag(e)';
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter_options']['weeks'] = 'Woche(n)';
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter_options']['months'] = 'Monat(e)';
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter_options']['years'] = 'Jahr(e)';

?>