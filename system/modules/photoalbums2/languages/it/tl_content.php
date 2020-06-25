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
$GLOBALS['TL_LANG']['tl_content']['pa2Album']                     = array('Album fotografici', 'Seleziona l\'album fotografico desiderato.');

$GLOBALS['TL_LANG']['tl_content']['pa2ImageViewTemplate']         = array('Template album fotografico', 'Seleziona qui il modello per la visualizzazione delle foto.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesTemplate']            = array('Template immagini', 'Seleziona qui il modello per l\'elemento foto. Questo è usato per ogni foto nella vista foto.');
$GLOBALS['TL_LANG']['tl_content']['pa2NumberOfImages']            = array('Numero totale di foto', 'Qui puoi impostare il numero totale di foto. Immettere 0 per visualizzare tutto.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesPerPage']             = array('Foto per pagina', 'Il numero di foto per pagina. Immettere 0 per disabilitare la paginazione.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesShowHeadline']        = array('Mostra intestazione', 'Seleziona questa casella per mostrare l\'intestazione del modulo nell\'album fotografico.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesShowTitle']           = array('Mostra il titolo dell\'album nella visualizzazione foto', 'Seleziona questa casella per mostrare il titolo dell\'album fotografico.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesShowTeaser']          = array('Mostra testo introduttivo nella visualizzazione foto', 'Seleziona questa casella per visualizzare il testo di anteprima nella vista foto.');

$GLOBALS['TL_LANG']['tl_content']['pa2ImagesImageSize']           = array('Dimensioni imamgini', 'Qui puoi impostare le dimensioni dell\'immagine e la modalità di ridimensionamento.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesImageMargin']         = array('Spaziatura immagine', 'Qui puoi inserire i margini dell\'immagine.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesPerRow']              = array('Immagini per riga', 'Specifica quante foto devono essere visualizzate per riga.');

$GLOBALS['TL_LANG']['tl_content']['pa2ImagesShowMetaDescriptions'] = array('Mostra meta descrizioni nella visualizzazione foto', 'Seleziona questa casella per mostrare le descrizioni dei meta campi nell\'album fotografico.');
$GLOBALS['TL_LANG']['tl_content']['pa2ImagesMetaFields']          = array('Meta campi in ambum fotografico', 'Seleziona i metacampi da visualizzare nell\'album fotografico');

$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilter']                = array('Filtro date', 'Qui hai la possibilità di filtrare gli album fotografici in base alle date.');
$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilterStart']           = array('Periodo inizio', 'Immettere qui il valore iniziale del periodo da filtrare. Ad esempio, se inserisci 10 giorni, gli album degli ultimi 10 giorni verranno visualizzati nel frontend. Per iniziare da oggi, inserisci il numero "0".');
$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilterEnd']             = array('Periodo fine', 'TImmettere qui il valore finale del periodo da filtrare. Ad esempio, se inserisci 10 giorni nel primo campo e 5 giorni in questo campo, gli album verranno visualizzati nel frontend da 10 giorni a 5 giorni fa. Per impostare la fine del periodo su oggi, immettere il numero "0".');

$GLOBALS['TL_LANG']['tl_content']['pa2Teaser']                    = array('Testo introduttivo', 'Qui puoi definire un testo introduttivo. Assicurati che il testo introduttivo sia visualizzato solo se hai attivato l\'apposita funzione nel modulo.');

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_content']['config_legend']                = 'Configurazione';
$GLOBALS['TL_LANG']['tl_content']['pa2Template_legend']           = 'Template Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['pa2Image_legend']              = 'Impostazioni foto';
$GLOBALS['TL_LANG']['tl_content']['pa2Meta_legend']               = 'Impostazioni Meta Dati';
$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilter_legend']         = 'Filtro date';
$GLOBALS['TL_LANG']['tl_content']['pa2Other_legend']              = 'Altro';
