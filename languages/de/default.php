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
 * @copyright  Daniel Kiesel 2012-2013
 * @author     Daniel Kiesel
 * @package    Language
 * @license    LGPL
 * @filesource
 */


/**
 * Content elements
 */
$GLOBALS['TL_LANG']['CTE']['photoalbums2']  = array('Fotoalbum', 'Erzeugt ein Fotoalbum.');


/**
 * Miscellaneous
 */
$GLOBALS['TL_LANG']['MSC']['albumsEmpty'] = 'Es sind keine Fotoalben vorhanden!';
$GLOBALS['TL_LANG']['MSC']['imagesEmpty'] = 'Das Fotoalbum konnte nicht gefunden werden!';


/**
 * Sort types
 */
$GLOBALS['TL_LANG']['pa2_sort_types']['metatitle_asc'] = array('Meta-Titel (aufsteigend)', 'Meta-Titel (aufsteigend)');
$GLOBALS['TL_LANG']['pa2_sort_types']['metatitle_desc'] = array('Meta-Titel (absteigend)', 'Meta-Titel (absteigend)');
$GLOBALS['TL_LANG']['pa2_sort_types']['name_asc'] = array('Name (aufsteigend)', 'Name (aufsteigend)');
$GLOBALS['TL_LANG']['pa2_sort_types']['name_desc'] = array('Name (absteigend)', 'Name (absteigend)');
$GLOBALS['TL_LANG']['pa2_sort_types']['date_asc'] = array('Datum (aufsteigend)', 'Datum (aufsteigend)');
$GLOBALS['TL_LANG']['pa2_sort_types']['date_desc'] = array('Datum (absteigend)', 'Datum (absteigend)');
$GLOBALS['TL_LANG']['pa2_sort_types']['random'] = array('Zufällige Ausgabe', 'Zufällige Ausgabe');
$GLOBALS['TL_LANG']['pa2_sort_types']['custom'] = array('Eigene Sortierung', 'Eigene Sortierung');


/**
 * Image preview types
 */
$GLOBALS['TL_LANG']['pa2_preview_image_types']['no_preview_image'] = array('Kein Vorschau Foto', 'Kein Vorschau Foto');
$GLOBALS['TL_LANG']['pa2_preview_image_types']['random_preview_image'] = array('Zufälliges Vorschau Foto', 'Zufälliges Vorschau Foto');
$GLOBALS['TL_LANG']['pa2_preview_image_types']['select_preview_image'] = array('Vorschau Foto auswählen', 'Vorschau Foto auswählen');


/**
 * Image preview types
 */
$GLOBALS['TL_LANG']['pa2_preview_image_module_types']['use_album_options'] = array('Einstellungen von Album übernehmen', 'Einstellungen von Album übernehmen');
$GLOBALS['TL_LANG']['pa2_preview_image_module_types']['no_preview_images'] = array('Keine Vorschau Fotos anzeigen', 'Keine Vorschau Fotos anzeigen');
$GLOBALS['TL_LANG']['pa2_preview_image_module_types']['random_images'] = array('Zufällige Vorschau Fotos anzeigen', 'Zufällige Vorschau Fotos anzeigen');
$GLOBALS['TL_LANG']['pa2_preview_image_module_types']['random_images_at_no_preview_images'] = array('Zufällige Vorschau Fotos bei nicht definiertem Vorschau Foto verwenden', 'Zufällige Vorschau Fotos bei nicht definiertem Vorschau Foto verwenden');


/**
 * Mode types
 */
$GLOBALS['TL_LANG']['pa2_mode_types']['pa2_on_one_page'] = array('Foto-Ansicht und Alben-Ansicht auf gleicher Seite darstellen (Standard)', 'Wählen Sie diese Einstellung, damit beide Ansichtsarten auf der gleichen Seite dargestellt werden.');
$GLOBALS['TL_LANG']['pa2_mode_types']['pa2_only_album_view'] = array('Nur Album-Ansicht verwenden und Lightbox direkt einbinden', 'Wählen Sie diese Einstellung um nur die Alben-Ansicht zu verwenden. Bei einem Klick auf ein Album öffnet sich dann direkt die Ligabox mit den Bildern aus dem Fotoalbum.');
$GLOBALS['TL_LANG']['pa2_mode_types']['pa2_with_detail_page'] = array('Foto-Ansicht auf einer anderen Seite anzeigen', 'Wählen Sie diese Einstellung, damit die Foto-Ansicht und die Alben-Ansicht auf zwei verschiedenen Seiten dargestellt werden kann.');


/**
 * Meta fields
 */
$GLOBALS['TL_LANG']['pa2']['pa2MetaFields_options']['date'] = 'Aufnahmedatum';
$GLOBALS['TL_LANG']['pa2']['pa2MetaFields_options']['event'] = 'Ereignis';
$GLOBALS['TL_LANG']['pa2']['pa2MetaFields_options']['place'] = 'Aufnahmeort';
$GLOBALS['TL_LANG']['pa2']['pa2MetaFields_options']['photographer'] = 'Fotograf';
$GLOBALS['TL_LANG']['pa2']['pa2MetaFields_options']['description'] = 'Beschreibung';
$GLOBALS['TL_LANG']['pa2']['pa2MetaFields_options']['numberOfAllImages'] = 'Fotoanzahl';
$GLOBALS['TL_LANG']['pa2']['pa2MetaField_description']['date'] = 'Aufnahmedatum: %s';
$GLOBALS['TL_LANG']['pa2']['pa2MetaField_description']['event'] = 'Ereignis: %s';
$GLOBALS['TL_LANG']['pa2']['pa2MetaField_description']['place'] = 'Aufnahmeort: %s';
$GLOBALS['TL_LANG']['pa2']['pa2MetaField_description']['photographer'] = 'Fotograf: %s';
$GLOBALS['TL_LANG']['pa2']['pa2MetaField_description']['description'] = 'Beschreibung: %s';
$GLOBALS['TL_LANG']['pa2']['pa2MetaField_description']['numberOfAllImages'] = 'Anzahl: %s Fotos';


/**
 * Time filter
 */
$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options']['seconds'] = 'Sekunde(n)';
$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options']['minutes'] = 'Minute(n)';
$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options']['hours'] = 'Stunde(n)';
$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options']['days'] = 'Tag(en)';
$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options']['weeks'] = 'Woche(n)';
$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options']['months'] = 'Monat(en)';
$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options']['years'] = 'Jahr(en)';

?>