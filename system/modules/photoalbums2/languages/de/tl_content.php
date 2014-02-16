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
$GLOBALS['TL_LANG']['tl_content']['pa2Album']                     = array('Fotoalbum wählen', 'Bitte wählen Sie Ihr gewünschtes Fotoalbum aus.');

$GLOBALS['TL_LANG']['tl_content']['pa2ImageViewTemplate']         = array('Foto-Ansicht Template', 'Wählen Sie hier das Template für die Foto-Ansicht aus.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesTemplate']            = array('Foto-Element Template', 'Wählen Sie hier das Template für das Foto-Element aus. Dieses wird innerhalb der Foto-Ansicht für jedes Foto verwendet.');
$GLOBALS['TL_LANG']['tl_content']['pa2NumberOfImages']            = array('Gesamtzahl der Fotos', 'Hier können Sie die Gesamtzahl der Fotos festlegen. Geben Sie 0 ein, um alle anzuzeigen.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesPerPage']             = array('Fotos pro Seite', 'Die Anzahl an Fotos pro Seite. Geben Sie 0 ein, um den automatischen Seitenumbruch zu deaktivieren.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesShowHeadline']        = array('Modul Überschrift in Foto-Ansicht anzeigen', 'Setzen Sie dieses Häkchen, um die Modul Überschrift in der Foto-Ansicht anzuzeigen.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesShowTitle']           = array('Alben Titel in Foto-Ansicht anzeigen', 'Setzen Sie dieses Häkchen, um den Titel des Albums in der Foto-Ansicht anzuzeigen.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesShowTeaser']          = array('Teaser in Foto-Ansicht anzeigen', 'Setzen Sie dieses Häkchen, um den Teaser in der Foto-Ansicht anzuzeigen.');

$GLOBALS['TL_LANG']['tl_content']['pa2ImagesImageSize']           = array('Foto-Ansicht Bildbreite und Bildhöhe', 'Hier können Sie die Abmessungen des Bildes und den Skalierungsmodus festlegen.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesImageMargin']         = array('Foto-Ansicht Bildabstand', 'Hier können Sie den oberen, rechten, unteren und linken Bildabstand eingeben.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesPerRow']              = array('Fotos pro Zeile', 'Bitte legen Sie fest, wie viele Fotos pro Zeile angezeigt werden sollen.');

$GLOBALS['TL_LANG']['tl_content']['pa2ImagesShowMetaDescriptions'] = array('Meta Beschreibungen in Foto-Ansicht anzeigen', 'Setzen Sie dieses Häkchen, um die Beschreibungen der Meta-Felder in der Foto-Ansicht anzuzeigen.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesMetaFields']          = array('Foto-Ansicht Meta Felder', 'Bitte wählen Sie die Meta Felder aus, die in der Foto-Ansicht ausgegeben werden sollen.');

$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilter']                = array('Zeitfilter', 'Hier haben Sie die Möglichkeit, die Fotoalben über einen vergangenen Zeitraum zu filtern.');
$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilterStart']           = array('Zeitraum von', 'Tragen Sie hier den Startwert des zu filternden Zeitraumes ein. Sollten Sie beispielsweise 10 Tage eintragen, so werden die Alben der vergangenen 10 Tage im Frontend angezeigt. Um von heute aus zu starten, tragen Sie die Zahl "0" ein.');
$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilterEnd']             = array('Zeitraum bis', 'Tragen Sie hier den Endwert des zu filternden Zeitraumes ein. Sollten Sie beispielsweise im ersten Feld 10 Tage und in diesem Feld 5 Tage eintragen, so werden die Alben im Zeitraum von vor 10 Tagen bis von vor 5 Tagen im Frontend angezeigt. Um das Ende des Zeitraumes auf heute zu legen, tragen Sie die Zahl "0" ein.');

$GLOBALS['TL_LANG']['tl_content']['pa2Teaser']                    = array('Teaser', 'Hier können Sie einen Teaser definieren. Achten Sie darauf, dass der Teaser nur angezeigt wird, wenn Sie im oberen Teil des Formulars die Ausgabe aktiviert haben.');

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_content']['config_legend']                = 'Konfiguration';
$GLOBALS['TL_LANG']['tl_content']['pa2Template_legend']           = 'Template Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['pa2Image_legend']              = 'Foto Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['pa2Meta_legend']               = 'Meta Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilter_legend']         = 'Zeitfilter';
$GLOBALS['TL_LANG']['tl_content']['pa2Other_legend']              = 'Sonstiges';
