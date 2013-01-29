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
 * @copyright  Daniel Kiesel 2012-2013
 * @author     Daniel Kiesel
 * @package    photoalbums2
 * @license    LGPL
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_module']['pa2Mode']                      = array('Ansichtsmodus wählen', 'Hier können Sie den Ansichtsmodus des Moduls auswählen.');
$GLOBALS['TL_LANG']['tl_module']['pa2PreviewImage']              = array('Vorschau Foto', 'Hier können Sie die Ausgabe des Vorschau Fotos definieren.');
$GLOBALS['TL_LANG']['tl_module']['pa2DetailPage']                = array('Foto-Ansicht auf einer anderen Seite anzeigen', 'Im Normalfall wird die Alben-Ansicht und die Foto-Ansicht auf der gleichen Seite dargestellt. Manchmal ist es jedoch nötig diese Beiden Seitenansichten auf zwei verschiedenen Seiten darzustellen. Damit Sie dies tun können, wählen Sie hier einfach die Seite aus, auf der die Foto-Ansicht dargestellt werden soll. Danach fügen Sie dieses Modul einmal auf der ausgewählten Seite und einmal auf einer anderen Seite ein. Auf der anderen Seite ist dann die Alben-Ansicht zu sehen.<br>Kleiner Tipp: Es empfiehlt sich den "auto_item-Parameter" zu verwenden.');
$GLOBALS['TL_LANG']['tl_module']['pa2Archives']                  = array('Fotoalben-Archive', 'Bitte wählen Sie ein oder mehrere Fotoalben-Archive.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumSortType']             = array('Alben sortieren', 'Wählen Sie hier die Sortierung der Fotoalben für die Übersichtsseite aus.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumSort']                 = array('Alben sortieren', 'Hier können Sie die Alben individuell sortieren.');

$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsTemplate']            = array('Alben Template', 'Wählen Sie hier das Template für die Alben aus.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesTemplate']            = array('Fotos Template', 'Wählen Sie hier das Template für die Fotos aus.');
$GLOBALS['TL_LANG']['tl_module']['pa2NumberOfAlbums']            = array('Gesamtzahl der Alben', 'Hier können Sie die Gesamtzahl der Alben festlegen. Geben Sie 0 ein, um alle anzuzeigen.');
$GLOBALS['TL_LANG']['tl_module']['pa2NumberOfImages']            = array('Gesamtzahl der Fotos', 'Hier können Sie die Gesamtzahl der Fotos festlegen. Geben Sie 0 ein, um alle anzuzeigen.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsPerPage']             = array('Alben pro Seite', 'Die Anzahl an Alben pro Seite. Geben Sie 0 ein, um den automatischen Seitenumbruch zu deaktivieren.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesPerPage']             = array('Fotos pro Seite', 'Die Anzahl an Fotos pro Seite. Geben Sie 0 ein, um den automatischen Seitenumbruch zu deaktivieren.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowHeadline']        = array('Modul Überschrift in Alben-Ansicht anzeigen', 'Setzen Sie dieses Häkchen, um die Modul Überschrift in der Alben-Ansicht anzuzeigen.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowHeadline']        = array('Modul Überschrift in Foto-Ansicht anzeigen', 'Setzen Sie dieses Häkchen, um die Modul Überschrift in der Foto-Ansicht anzuzeigen.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowTitle']           = array('Alben Titel in Alben-Ansicht anzeigen', 'Setzen Sie dieses Häkchen, um den Titel der Alben in der Alben-Ansicht anzuzeigen.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowTitle']           = array('Alben Titel in Foto-Ansicht anzeigen', 'Setzen Sie dieses Häkchen, um den Titel des Albums in der Foto-Ansicht anzuzeigen.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowTeaser']          = array('Teaser in Alben-Ansicht anzeigen', 'Setzen Sie dieses Häkchen, um den Teaser in der Alben-Ansicht anzuzeigen.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowTeaser']          = array('Teaser in Foto-Ansicht anzeigen', 'Setzen Sie dieses Häkchen, um den Teaser in der Foto-Ansicht anzuzeigen.');

$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsImageSize']           = array('Alben-Ansicht Bildbreite und Bildhöhe', 'Hier können Sie die Abmessungen des Bildes und den Skalierungsmodus festlegen.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesImageSize']           = array('Foto-Ansicht Bildbreite und Bildhöhe', 'Hier können Sie die Abmessungen des Bildes und den Skalierungsmodus festlegen.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsImageMargin']         = array('Alben-Ansicht Bildabstand', 'Hier können Sie den oberen, rechten, unteren und linken Bildabstand eingeben.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesImageMargin']         = array('Foto-Ansicht Bildabstand', 'Hier können Sie den oberen, rechten, unteren und linken Bildabstand eingeben.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsPerRow']              = array('Alben pro Zeile', 'Bitte legen Sie fest, wie viele Alben pro Zeile angezeigt werden sollen.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesPerRow']              = array('Fotos pro Zeile', 'Bitte legen Sie fest, wie viele Fotos pro Zeile angezeigt werden sollen.');

$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowMetaDescriptions'] = array('Meta Beschreibungen in Alben-Ansicht anzeigen', 'Setzen Sie dieses Häkchen, um die Beschreibungen der Meta-Felder in der Alben-Ansicht anzuzeigen.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsMetaFields']          = array('Alben-Ansicht Meta Felder', 'Bitte wählen Sie die Meta Felder aus, die in der Alben-Ansicht ausgegeben werden sollen.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowMetaDescriptions'] = array('Meta Beschreibungen in Foto-Ansicht anzeigen', 'Setzen Sie dieses Häkchen, um die Beschreibungen der Meta-Felder in der Foto-Ansicht anzuzeigen.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesMetaFields']          = array('Foto-Ansicht Meta Felder', 'Bitte wählen Sie die Meta Felder aus, die in der Foto-Ansicht ausgegeben werden sollen.');

$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter']                = array('Zeitfilter', 'Hier haben Sie die Möglichkeit, die Fotoalben über einen vergangenen Zeitraum zu filtern.');
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilterStart']           = array('Zeitraum von vor', 'Tragen Sie hier den Startwert des zu filternden Zeitraumes ein. Sollten Sie beispielsweise 10 Tage eintragen, so werden die Alben der vergangenen 10 Tage im Frontend angezeigt. Um von heute aus zu starten, tragen Sie die Zahl "0" ein.');
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilterEnd']             = array('Zeitraum bis vor', 'Tragen Sie hier den Endwert des zu filternden Zeitraumes ein. Sollten Sie beispielsweise im ersten Feld 10 Tage und in diesem Feld 5 Tage eintragen, so werden die Alben im Zeitraum von vor 10 Tagen bis von vor 5 Tagen im Frontend angezeigt. Um das Ende des Zeitraumes auf heute zu legen, tragen Sie die Zahl "0" ein.');

$GLOBALS['TL_LANG']['tl_module']['pa2Teaser']                    = array('Teaser', 'Hier können Sie einen Teaser definieren. Achten Sie darauf, dass der Teaser nur angezeigt wird, wenn Sie im oberen Teil des Formulars die Ausgabe aktiviert haben.');


/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_module']['pa2Album_legend']              = 'Album Einstellungen';
$GLOBALS['TL_LANG']['tl_module']['pa2Template_legend']           = 'Template Einstellungen';
$GLOBALS['TL_LANG']['tl_module']['pa2Image_legend']              = 'Foto Einstellungen';
$GLOBALS['TL_LANG']['tl_module']['pa2Meta_legend']               = 'Meta Einstellungen';
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter_legend']         = 'Zeitfilter';
$GLOBALS['TL_LANG']['tl_module']['pa2Other_legend']              = 'Sonstiges';

?>