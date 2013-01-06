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
 * @package    photoalbums2
 * @license    LGPL
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['title'] = array('Titel', 'Geben Sie dem Fotoalbum einen Titel.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['alias'] = array('Alias', 'Der Alias wird automatisch generiert und ist später in der URL zu finden.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['author'] = array('Autor', 'Hier können Sie den Autor des Albums ändern.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['startdate'] = array('Startdatum', 'Tragen Sie hier das Startdatum ein.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['enddate'] = array('Enddatum', 'Tragen Sie hier ein Enddatum ein, wenn die Aufnahmen über mehrere Tage dauerten. Ansonsten lassen Sie dieses Feld einfach leer.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['images'] = array('Fotos', 'Wählen Sie hier die Fotos aus, die in diesem Album angezeigt werden sollen.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['preview_image_type'] = array('Vorschau Foto', 'Wählen Sie hier, wie das Vorschau Foto angezeigt werden soll.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['preview_image'] = array('Vorschau Foto auswählen', 'Wählen Sie hier das Vorschau Foto aus.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['image_sort_type'] = array('Fotos sortieren', 'Wählen Sie hier, wie die Fotos sortiert werden sollen.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['image_sort'] = array('Fotos sortieren', 'Hier können Sie die Fotos sortieren.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['event'] = array('Ereignis', 'Tragen Sie hier das Ereignis ein.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['place'] = array('Aufnahmeort', 'Tragen Sie hier den Aufnahmeort ein.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['photographer'] = array('Fotograf', 'Tragen Sie hier den Fotograf ein.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['description'] = array('Beschreibung', 'Geben Sie hier eine Beschreibung ein.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['protected'] = array('Album schützen', 'Begrenzen Sie hier den Zugriff auf dieses Fotoalbum.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['users'] = array('Mitglieder', 'Wählen Sie hier die Mitglieder aus, die Zugriff auf dieses Fotoalbum haben sollen.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['groups'] = array('Mitglieder Gruppen', 'Wählen Sie hier die Mitglieder Gruppen aus, die Zugriff auf dieses Fotoalbum haben sollen.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['cssClass'] = array('CSS-Klasse', 'Hier können Sie eine oder mehrere Klassen eingeben.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['noComments'] = array('Kommentare deaktivieren', 'Die Kommentarfunktion für dieses Album deaktivieren.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['published'] = array('Veröffentlicht', 'Setzen Sie das Häkchen, um das Fotoalbum zu veröffentlichen.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['start'] = array('Anzeigen ab', 'Das Album erst ab diesem Tag auf der Webseite anzeigen.');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['stop'] = array('Anzeigen bis', 'Das Album nur bis zu diesem Tag auf der Webseite anzeigen.');


/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['title_legend'] = 'Titel';
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['date_legend'] = 'Datum';
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['images_legend'] = 'Fotos';
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['info_legend'] = 'Info';
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['protected_legend'] = 'Album schützen';
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['expert_legend'] = 'Experten-Einstellungen';
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['published_legend'] = 'Veröffentlichen';


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['new']    = array('Neues Fotoalbum', 'Neues Fotoalbum erstellen');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['edit']   = array('Fotoalbum bearbeiten', 'Fotoalbum ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['copy']   = array('Fotoalbum duplizieren', 'Fotoalbum ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['cut']   = array('Fotoalbum verschieben', 'Fotoalbum ID %s verschieben');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['delete'] = array('Fotoalbum löschen', 'Fotoalbum ID %s löschen');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['show']   = array('Details des Fotoalbum anzeigen', 'Details des Fotoalbum ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_photoalbums2_album']['toggle'] = array('Fotoalbum veröffentlichten/unveröffentlichen', 'Fotoalbum ID %s veröffentlichten/unveröffentlichen');

?>