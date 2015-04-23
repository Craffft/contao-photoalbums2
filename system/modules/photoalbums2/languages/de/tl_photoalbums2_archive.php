<?php

/**
 * Extension for Contao Open Source CMS
 *
 * Copyright (c) 2012-2014 Daniel Kiesel
 *
 * @package Photoalbums2
 * @link    https://github.com/craffft/contao-photoalbums
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['title'] = array('Titel', 'Geben Sie dem Fotoalben Archiv einen Titel.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['allowComments'] = array('Kommentare aktivieren', 'Besuchern das Kommentieren von Fotoalben erlauben.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['notify'] = array('Benachrichtigung an', 'Bitte legen Sie fest, wer beim Hinzufügen neuer Kommentare benachrichtigt wird.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['sortOrder'] = array('Sortierung', 'Standardmäßig werden Kommentare aufsteigend sortiert, beginnend mit dem ältesten.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['perPage'] = array('Kommentare pro Seite', 'Anzahl an Kommentaren pro Seite. Geben Sie 0 ein, um den automatischen Seitenumbruch zu deaktivieren.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['moderate'] = array('Kommentare moderieren', 'Kommentare erst nach Bestätigung auf der Webseite veröffentlichen.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['bbcode'] = array('BBCode erlauben', 'Besuchern das Formatieren ihrer Kommentare mittels BBCode erlauben.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['requireLogin'] = array('Login zum Kommentieren benötigt', 'Nur angemeldeten Benutzern das Erstellen von Kommentaren erlauben.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['disableCaptcha'] = array('Sicherheitsfrage deaktivieren', 'Wählen Sie diese Option nur, wenn das Erstellen von Kommentaren auf authentifizierte Benutzer beschränkt ist.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['protected'] = array('Archiv schützen', 'Begrenzen Sie hier den Zugriff auf dieses Fotoalben Archiv.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['users'] = array('Mitglieder', 'Wählen Sie hier die Mitglieder aus, die Zugriff auf dieses Fotoalben Archiv haben sollen.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['groups'] = array('Mitglieder Gruppen', 'Wählen Sie hier die Mitglieder Gruppen aus, die Zugriff auf dieses Fotoalben Archiv haben sollen.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['makeFeed'] = array('Feed erstellen', 'Einen RSS- oder Atom-Feed aus dem Fotoarchiv generieren.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['format'] = array('Feed-Format', 'Bitte wählen Sie ein Format.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['language'] = array('Feed-Sprache', 'Bitte geben Sie die Sprache der Seite gemäß des ISO-639 Standards ein (z.B. <em>de</em>, <em>de-ch</em>).');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['modulePage'] = array('Modul URL', 'Bitte geben Sie hier die URL zur Detailseite, welche das Fotoalben-Modul nutzt, an.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['maxItems'] = array('Maximale Anzahl an Alben', 'Hier können Sie die Anzahl der Alben limitieren. Geben Sie 0 ein, um alle zu exportieren.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['feedBase'] = array('Basis-URL', 'Bitte geben Sie die Basis-URL mit Protokoll (z.B. <em>http://</em>) ein.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['alias'] = array('Feed-Alias', 'Hier können Sie einen eindeutigen Dateinamen (ohne Endung) eingeben. Die XML-Datei wird automatisch im Wurzelverzeichnis Ihrer Contao-Installation erstellt, z.B. als <em>name.xml</em>.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['description'] = array('Feed-Beschreibung', 'Bitte geben Sie eine kurze Beschreibung des Fotoarchiv-Feeds ein.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['tstamp'] = array('Änderungsdatum', 'Datum und Uhrzeit der letzten Änderung');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['title_legend'] = 'Titel';
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['comments_legend'] = 'Kommentare';
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['protected_legend'] = 'Zugriffsschutz';
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['feed_legend'] = 'RSS/Atom-Feed';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['notify_admin'] = 'Systemadministrator';
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['notify_author'] = 'Autor des Beitrags';
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['notify_both'] = 'Autor und Systemadministrator';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['new'] = array('Neues Fotoalben Archiv', 'Neues Fotoalben Archiv erstellen');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['edit'] = array('Fotoalben Archiv bearbeiten', 'Fotoalben Archiv ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['editheader'] = array('Einstellungen des Fotoalben Archivs bearbeiten', 'Einstellungen des Fotoalben Archivs ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['copy'] = array('Fotoalben Archiv duplizieren', 'Fotoalben Archiv ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['delete'] = array('Fotoalben Archiv löschen', 'Fotoalben Archiv ID %s löschen');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['show'] = array('Fotoalben Archiv anzeigen', 'Fotoalben Archiv ID %s anzeigen');
