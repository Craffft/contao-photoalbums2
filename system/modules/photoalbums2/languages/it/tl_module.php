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
$GLOBALS['TL_LANG']['tl_module']['pa2Mode']                      = array('Selezione la modalità visualizzazione', 'Selezionare la modalità di visualizzazione del modulo.');
$GLOBALS['TL_LANG']['tl_module']['pa2PreviewImage']              = array('Anteprima immagine', 'Qui è possibile definire come mostrare l\'anteprima immagine.');
$GLOBALS['TL_LANG']['tl_module']['pa2OverviewPage']              = array('Pagina anteprima album', 'Seelzionare la pagina di anteprima degli album fotografici.');
$GLOBALS['TL_LANG']['tl_module']['pa2DetailPage']                = array('Pagina visualizzazione immagini', 'Selezionare la pagina di visualizzazione delle immagini.');
$GLOBALS['TL_LANG']['tl_module']['pa2Archives']                  = array('Archivi album fotografici', 'Seleziona uno o più album fotografici.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumSortType']             = array('Ordinamento album', 'Qui si può scegliere l\'ordine degli album fotografici nella pagina di anteprima.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumSort']                 = array('Ordine album', 'Qui è possibile ordinare gli album.');

$GLOBALS['TL_LANG']['tl_module']['pa2AlbumViewTemplate']         = array('Template anteprima album', 'Qui è possibile selezionare il template per l\'anteprima  album.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImageViewTemplate']         = array('template immagine', 'Qui è possibile selezionare il modello per la visualizzazione delle immagini.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsTemplate']            = array('Template album', 'Qui è possibile selezionare il template dell\'anteprima dell\'album. Questo template si applica ad ogni singolo album.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesTemplate']            = array('Template elementi immagine', 'Qui è possibile selezionare il template per gli elementi immagine. Questo template è utilizzato per ogni singola immagine.');
$GLOBALS['TL_LANG']['tl_module']['pa2NumberOfAlbums']            = array('Numero totale di album', 'Indicare il numero totale di album. Inserisci 0 per mostrare tutti gli album');
$GLOBALS['TL_LANG']['tl_module']['pa2NumberOfImages']            = array('Numero totale di immagini', 'Qui è possibile specificare il numero di immagini da visualizzare. Inserisci 0 per mostrare tutte le immagini.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsPerPage']             = array('Album per pagina', 'Numero di album per pagina. Inserisci 0 per disabilitare la paginazione.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesPerPage']             = array('Immagini per pagina', 'Numero di immagini per pagina. Inserisci 0 per disabilitare la paginazione.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowHeadline']        = array('Mostra il titolo nell\'elenco album', 'Seleziona questa opzione se si vuole visualizzare il titolo nella pagina degli album.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowHeadline']        = array('Mostra il titolo nella pagina delle immagini', 'Seleziona questa opzione se si vuole visualizzare il titolo nella pagina immagini.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowTitle']           = array('Mostra il titolo dell\album nell\'elenco album', 'Seleziona questa opzione se si desidera visualizzare il titolo dell\'album');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowTitle']           = array('Mostra il titolo dell\album nella pagina immagini', 'Seleziona questa opzione se si desidera visualizzare il titolo nella pagina immagini.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowTeaser']          = array('Mostra il testo introduttivo', 'Selezionare questa opzione per visualizzare il testo introduttivo.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowTeaser']          = array('Mostra il testo introduttivo', 'Selezionare questa opzione per visualizzare il testo introduttivo delle immagini.');

$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsImageSize']           = array('Dimensioni immagini di anteprima', 'Qui è possibile indicare le dimensioni delle miniature delle immagini di anteprima.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesImageSize']           = array('Dimensioni miniature', 'Qui è possibile indicare le dimensioni delle miniature delle immagini.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsImageMargin']         = array('Margini anteprima immagini', 'Indicare i margini dell\'anteprima immagini.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesImageMargin']         = array('Margini immagini', 'Indicare i margini delle immagini.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsPerRow']              = array('Album per riga', 'Indicare il numero di album per riga');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesPerRow']              = array('Immagini per riga', 'Indicare il numero di immagini per riga');

$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowMetaDescriptions'] = array('Mostra i meta dati descriptions nella pagina di anteprima', 'Seleziona questa opzione se si vuole mostrare la descrizione nella pagina di anteprima.');
$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsMetaFields']          = array('Meta dati anteprima album', 'Selezionare i metadati che si vuole mostrare');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowMetaDescriptions'] = array('Mostra i meta dati descriptions nella pagina immagini', 'Seleziona questa opzione se si vuole mostrare la descrizione nella pagina delle immagini.');
$GLOBALS['TL_LANG']['tl_module']['pa2ImagesMetaFields']          = array('Meta Dati', 'Selezionare i metadati che si vuole mostrare.');

$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter']                = array('Filtro temporale', 'Qui è possibile impostare un filtro temporale per gli album.');
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilterStart']           = array('Inizio periodo', 'Inserire il valore iniziale del periodo da filtrare. Esempio, se si inserisce 10, verranno mostrati gli album a partire da 10 giorni fa. Per iniziare da oggi, inserire il numero "0".');
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilterEnd']             = array('Fine periodo', 'Inserire qui il valore finale del periodo da filtrare. Ad esempio se nel periodo iniziale abbiamo inserito 10 ed in questo campo 5 verranno mostrati gli album del periodo tra 10 giorni fa e 5 giorni fa. Per aggiungere alla fine del periodo ad oggi, inserire il numero "0".');

$GLOBALS['TL_LANG']['tl_module']['pa2Teaser']                    = array('Testo di anteprima', 'Inserire qui il testo di anteprima.');

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_module']['pa2Album_legend']              = 'Configurazione';
$GLOBALS['TL_LANG']['tl_module']['pa2Template_legend']           = 'Impostazioni Template';
$GLOBALS['TL_LANG']['tl_module']['pa2Image_legend']              = 'Configurazione immagine';
$GLOBALS['TL_LANG']['tl_module']['pa2Meta_legend']               = 'Configurazione meta dati';
$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter_legend']         = 'Configurazione filtro temporale';
$GLOBALS['TL_LANG']['tl_module']['pa2Other_legend']              = 'Altro';
