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
 * Content elements
 */
$GLOBALS['TL_LANG']['CTE']['photoalbums2']  = array('Fotoalbum', 'Genera un album fotografico.');

/**
 * Miscellaneous
 */
$GLOBALS['TL_LANG']['MSC']['albumsNotFound'] = 'Non ci sono album di immagini disponibili!';
$GLOBALS['TL_LANG']['MSC']['albumNotFound'] = 'L\'album di immagini non è stato trovato!';
$GLOBALS['TL_LANG']['MSC']['imagesNotFound'] = 'L\'album di immagini non contiene immagini!';

/**
 * Pa2 miscellaneous
 */
$GLOBALS['TL_LANG']['PA2']['goBack'] = 'Torna indietro';

/**
 * Image sort types
 */
$GLOBALS['TL_LANG']['PA2']['imageSortTypes']['metatitle_asc'] = array('Meta title (ascendente)', 'Meta title (ascendente)');
$GLOBALS['TL_LANG']['PA2']['imageSortTypes']['metatitle_desc'] = array('Meta title (discendente)', 'Meta title (discendente)');
$GLOBALS['TL_LANG']['PA2']['imageSortTypes']['name_asc'] = array('Nome (ascending)', 'Nome (ascendente)');
$GLOBALS['TL_LANG']['PA2']['imageSortTypes']['name_desc'] = array('Nome (discendente)', 'Nome (discendente)');
$GLOBALS['TL_LANG']['PA2']['imageSortTypes']['date_asc'] = array('Data (ascendente)', 'Data (ascendente)');
$GLOBALS['TL_LANG']['PA2']['imageSortTypes']['date_desc'] = array('Data (descending)', 'Data (descending)');
$GLOBALS['TL_LANG']['PA2']['imageSortTypes']['random'] = array('Casuale', 'Ordine casuale');
$GLOBALS['TL_LANG']['PA2']['imageSortTypes']['custom'] = array('Manuale ', 'Ordine manuale');

/**
 * Image preview types
 */
$GLOBALS['TL_LANG']['PA2']['albumPreviewImageTypes']['no_preview_image'] = array('Nessuna foto', 'Nessuna foto di anteprima');
$GLOBALS['TL_LANG']['PA2']['albumPreviewImageTypes']['random_preview_image'] = array('Casuale', 'Foto di anteprima casuale');
$GLOBALS['TL_LANG']['PA2']['albumPreviewImageTypes']['first_preview_image'] = array('Prima foto', 'Prima foto di anteprima');
$GLOBALS['TL_LANG']['PA2']['albumPreviewImageTypes']['select_preview_image'] = array('Foto specifica', 'Seleziona la foto di anteprima');

/**
 * Image preview types
 */
$GLOBALS['TL_LANG']['PA2']['previewImageModuleTypes']['use_album_options'] = array('Applica impostazioni', 'Applica le impostazioni dall\'album');
$GLOBALS['TL_LANG']['PA2']['previewImageModuleTypes']['no_preview_images'] = array('Nessuna foto', 'Nessuna foto di anteprima');
$GLOBALS['TL_LANG']['PA2']['previewImageModuleTypes']['random_images'] = array('Foto casuale', 'Anteprima casuale delle foto');
$GLOBALS['TL_LANG']['PA2']['previewImageModuleTypes']['random_images_at_no_preview_images'] = array('Immagini casuali senza anteprima', 'Utilizza immagini casuali senza anteprima');
$GLOBALS['TL_LANG']['PA2']['previewImageModuleTypes']['first_image_at_no_preview_images'] = array('Prima immagine senza anteprima ', 'Utilizza la prima immagine senza anteprima');

/**
 * Mode types
 */
$GLOBALS['TL_LANG']['PA2']['moduleModeTypes']['pa2_on_one_page'] = array('Mostra la panoramica dell\'album e la visualizzazione delle foto su una pagina (impostazione predefinita)', 'Visualizza la panoramica dell\'album e la visualizzazione della foto sulla stessa pagina.');
$GLOBALS['TL_LANG']['PA2']['moduleModeTypes']['pa2_only_album_view'] = array('Usa la visualizzazione album solo con lightbox', 'Visualizza solo la panoramica dell\'album. Quando fai clic su un album, la lightbox si apre e mostra tutte le foto dell\'album fotografico..');
$GLOBALS['TL_LANG']['PA2']['moduleModeTypes']['pa2_with_detail_page'] = array('Mostra la panoramica dell\'album e la visualizzazione delle foto su diverse pagine', 'Visualizza la panoramica dell\'album e la visualizzazione delle foto su pagine diverse, per fare ciò integrare questo modulo in entrambe le pagine.');

/**
 * Album sort types
 */
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['title_asc'] = array('Nome (ascendente)', 'Nome (ascendente)');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['title_desc'] = array('Nome (discendente)', 'Nome (discendente)');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['startdate_asc'] = array('Data inizio (ascendente)', 'Data inizio (ascendente)');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['startdate_desc'] = array('Data inizio (discendente)', 'Data inizio (discendente)');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['enddate_asc'] = array('Data fine (ascendente)', 'Enddatum (ascendente)');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['enddate_desc'] = array('Data fine (discendente)', 'Data fine (discendente)');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['numberOfImages_asc'] = array('Numero di immagini (ascendente)', 'Numero di immagini (ascendente)');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['numberOfImages_desc'] = array('Numero di immagini (discendente)', 'Numero di immagini (discendente)');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['random'] = array('Casuale', 'Casuale Ausgabe');
$GLOBALS['TL_LANG']['PA2']['albumSortTypes']['custom'] = array('Manuale', 'ordinamento manuale');

/**
 * Meta fields
 */
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldOptions']['date'] = 'Data';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldOptions']['event'] = 'Evento';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldOptions']['place'] = 'Luogo';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldOptions']['photographer'] = 'Fotografo';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldOptions']['description'] = 'Descrizione';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldOptions']['numberOfAllImages'] = 'Numero foto';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldDescription']['date'] = 'Data: %s';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldDescription']['event'] = 'Evento: %s';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldDescription']['place'] = 'Luogo: %s';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldDescription']['photographer'] = 'Fotografo: %s';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldDescription']['description'] = 'Descrizione: %s';
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldDescription']['numberOfAllImages'] = array('Totale: %s Foto', 'Totale: %s Foto');
$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldWithoutDescription']['numberOfAllImages'] = array('%s Foto', '%s Fotos');

/**
 * Time filter
 */
$GLOBALS['TL_LANG']['PA2']['pa2TimeFilterOptions']['seconds'] = 'Secondi';
$GLOBALS['TL_LANG']['PA2']['pa2TimeFilterOptions']['minutes'] = 'Minuti';
$GLOBALS['TL_LANG']['PA2']['pa2TimeFilterOptions']['hours'] = 'Ore';
$GLOBALS['TL_LANG']['PA2']['pa2TimeFilterOptions']['days'] = 'Giorni';
$GLOBALS['TL_LANG']['PA2']['pa2TimeFilterOptions']['weeks'] = 'Settimane';
$GLOBALS['TL_LANG']['PA2']['pa2TimeFilterOptions']['months'] = 'Mesi';
$GLOBALS['TL_LANG']['PA2']['pa2TimeFilterOptions']['years'] = 'Anni';
