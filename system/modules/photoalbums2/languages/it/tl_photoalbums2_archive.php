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
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['title'] = array('Titolo', 'Indicare il titolo dell\'album fotografico.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['allowComments'] = array('Abilita commenti', 'Permetti ai visitatori di commentare gli album.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['notify'] = array('Notifica', 'Seleziona a chi mandare una notifica quando sono aggiunti commenti.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['sortOrder'] = array('Ordinamento', 'Di default i commenti sono ordinati in modo che il più vecchio rimanga in testa.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['perPage'] = array('Commenti per pagina', 'Seleziona il numero di commenti per pagina (0= paginazione disabilitata).');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['moderate'] = array('Modera', 'Approva i commenti prima che vengano visualizzati sul sito web.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['bbcode'] = array('Abilita BBCode', 'Abilita i BBCode nei commenti per i visitatori.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['requireLogin'] = array(' Richiedi login', 'Permetti solo agli utenti registrati di inserire commenti.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['disableCaptcha'] = array('Disabilita domanda di sicurezza', 'Seleziona questa opzione se desideri disabilitare la domanda di sicurezza (non raccomandato).');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['protected'] = array('Archivio protetto', 'Mostra questo archivio solo a determinati utenti.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['users'] = array('Membri', 'Qui puoi selezionare i membri abilitati a visualizzare gli album fotografici.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['groups'] = array('Gruppi membri', 'Qui puoi selezionare i gruppi abilitati a visualizzare gli album fotografici.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['makeFeed'] = array('Genera un feed', 'Genera un RSS o Atom feed dall\'archivio delle immagini.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['format'] = array('Formato Feed', 'Selezionare il formato del feed.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['language'] = array('Lingua del feed', 'Inserisci la lingua del feed secondo lo standard ISO-639 (es.: <em>en</em> o <em>en-us</em>).');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['modulePage'] = array('URL Modulo', 'Inserire l\'URL della pagina di dettaglio dell\'album fotografico.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['maxItems'] = array('Massimo numero di elementi', 'Qui puoi limitare il numero del feed. Imposta 0 per esportare tutto.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['feedBase'] = array('URL base', 'Inserisci l\'URL base completo di protocollo (es.: <em>http://</em>).');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['alias'] = array(' Alias del feed', 'Qui puoi inserire il nome univoco del file (senza estensione). Il feed XML sarà auto-generato nella cartella <em>share</em> della tua installazione Contao. es.: <em>share/name.xml</em>.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['description'] = array('Descrizione del feed', 'Qui puoi inserire una breve descrizione del feed.');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['tstamp'] = array('Data revisione', 'Data ed ora dell\'ultima revisione');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['title_legend'] = 'Titolo';
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['comments_legend'] = 'Commenti';
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['protected_legend'] = 'Protezione accesso';
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['feed_legend'] = 'Impostazioni feed';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['notify_admin'] = 'Amministratoire di sistema';
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['notify_author'] = 'Autore dell\'elemento';
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['notify_both'] = 'Autore ed amministratore di sistema';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['new'] = array('Crea un nuovo album fotografico', 'Crea un nuovo album fotografico');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['edit'] = array('Modifica un album fotografico', 'Modifica l\'album fotografico ID %s');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['editheader'] = array('Modifica le impostazioni dell\'album fotografico', 'Modifica le impostazioni dell\'album fotografico ID %s');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['copy'] = array('Copia l\'album fotografico', 'Copia l\'album fotografico ID %s');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['delete'] = array('Elimina l\'album fotografico', 'Elimina l\'album fotografico ID %s');
$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['show'] = array('Mostra i dettagli dell\'album fotografico', 'Mostra i dettagli dell\'album fotografico ID %s');
