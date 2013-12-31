<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2014 Leo Feyer
 *
 * @package    photoalbums2
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @license    LGPL
 * @copyright  Daniel Kiesel 2012-2014
 */


/**
 * Table tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['config']['onsubmit_callback'][] = array('Pa2Backend', 'checkTimeFilter');
$GLOBALS['TL_DCA']['tl_module']['config']['onsubmit_callback'][] = array('tl_module_photoalbums2', 'handleListAndViewModule');
$GLOBALS['TL_DCA']['tl_module']['config']['onload_callback'][] = array('tl_module_photoalbums2', 'fixPa2Palette');

$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'pa2TimeFilter';
$GLOBALS['TL_DCA']['tl_module']['palettes']['photoalbums2']              = '{title_legend},name,headline,type;
																			{config_legend},pa2Mode';

$GLOBALS['TL_DCA']['tl_module']['palettes']['pa2_on_one_page']           = '{title_legend},name,headline,type;
																			{config_legend},pa2Mode,pa2PreviewImage;
																			{pa2Album_legend},pa2Archives,pa2AlbumSortType,pa2AlbumSort;
																			{pa2Template_legend},pa2AlbumViewTemplate,pa2ImageViewTemplate,pa2AlbumsTemplate,pa2ImagesTemplate,pa2AlbumsShowHeadline,pa2ImagesShowHeadline,pa2AlbumsShowTitle,pa2ImagesShowTitle,pa2AlbumsShowTeaser,pa2ImagesShowTeaser;
																			{pa2Image_legend},pa2AlbumsImageSize,pa2ImagesImageSize,pa2AlbumsImageMargin,pa2ImagesImageMargin,pa2AlbumsPerRow,pa2ImagesPerRow,pa2AlbumsPerPage,pa2ImagesPerPage,pa2NumberOfAlbums,pa2NumberOfImages;
																			{pa2Meta_legend:hide},pa2AlbumsShowMetaDescriptions,pa2ImagesShowMetaDescriptions,pa2AlbumsMetaFields,pa2ImagesMetaFields;
																			{pa2TimeFilter_legend:hide},pa2TimeFilter;
																			{pa2Other_legend:hide},pa2Teaser;
																			{protected_legend:hide},protected;
																			{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['palettes']['pa2_only_album_view']       = '{title_legend},name,headline,type;
																			{config_legend},pa2Mode,pa2PreviewImage;
																			{pa2Album_legend},pa2Archives,pa2AlbumSortType,pa2AlbumSort;
																			{pa2Template_legend},pa2AlbumViewTemplate,pa2AlbumsTemplate,pa2AlbumsShowHeadline,pa2AlbumsShowTitle,pa2AlbumsShowTeaser;
																			{pa2Image_legend},pa2AlbumsImageSize,pa2AlbumsImageMargin,pa2AlbumsPerRow,pa2AlbumsPerPage,pa2NumberOfAlbums;
																			{pa2Meta_legend:hide},pa2AlbumsShowMetaDescriptions,pa2AlbumsMetaFields;
																			{pa2TimeFilter_legend:hide},pa2TimeFilter;
																			{pa2Other_legend:hide},pa2Teaser;
																			{protected_legend:hide},protected;
																			{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['palettes']['pa2_with_detail_page']      = '{title_legend},name,headline,type;
																			{config_legend},pa2Mode,pa2PreviewImage,pa2OverviewPage,pa2DetailPage;
																			{pa2Album_legend},pa2Archives,pa2AlbumSortType,pa2AlbumSort;
																			{pa2Template_legend},pa2AlbumViewTemplate,pa2ImageViewTemplate,pa2AlbumsTemplate,pa2ImagesTemplate,pa2AlbumsShowHeadline,pa2ImagesShowHeadline,pa2AlbumsShowTitle,pa2ImagesShowTitle,pa2AlbumsShowTeaser,pa2ImagesShowTeaser;
																			{pa2Image_legend},pa2AlbumsImageSize,pa2ImagesImageSize,pa2AlbumsImageMargin,pa2ImagesImageMargin,pa2AlbumsPerRow,pa2ImagesPerRow,pa2AlbumsPerPage,pa2ImagesPerPage,pa2NumberOfAlbums,pa2NumberOfImages;
																			{pa2Meta_legend:hide},pa2AlbumsShowMetaDescriptions,pa2ImagesShowMetaDescriptions,pa2AlbumsMetaFields,pa2ImagesMetaFields;
																			{pa2TimeFilter_legend:hide},pa2TimeFilter;
																			{pa2Other_legend:hide},pa2Teaser;
																			{protected_legend:hide},protected;
																			{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['palettes']['photoalbums2list']          = '{title_legend},name,headline,type;
																			{config_legend},pa2PreviewImage,pa2DetailPage;
																			{pa2Album_legend},pa2Archives,pa2AlbumSortType,pa2AlbumSort;
																			{pa2Template_legend},pa2AlbumViewTemplate,pa2AlbumsTemplate,pa2AlbumsShowHeadline,pa2AlbumsShowTitle,pa2AlbumsShowTeaser;
																			{pa2Image_legend},pa2AlbumsImageSize,pa2AlbumsImageMargin,pa2AlbumsPerRow,pa2AlbumsPerPage,pa2NumberOfAlbums;
																			{pa2Meta_legend:hide},pa2AlbumsShowMetaDescriptions,pa2AlbumsMetaFields;
																			{pa2TimeFilter_legend:hide},pa2TimeFilter;
																			{pa2Other_legend:hide},pa2Teaser;
																			{protected_legend:hide},protected;
																			{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['palettes']['photoalbums2view']          = '{title_legend},name,headline,type;
																			{config_legend},pa2OverviewPage;
																			{pa2Album_legend},pa2Archives;
																			{pa2Template_legend},pa2ImageViewTemplate,pa2ImagesTemplate,pa2ImagesShowHeadline,pa2ImagesShowTitle,pa2ImagesShowTeaser;
																			{pa2Image_legend},pa2ImagesImageSize,pa2ImagesImageMargin,pa2ImagesPerRow,pa2ImagesPerPage,pa2NumberOfImages;
																			{pa2Meta_legend:hide},pa2ImagesShowMetaDescriptions,pa2ImagesMetaFields;
																			{pa2TimeFilter_legend:hide},pa2TimeFilter;
																			{pa2Other_legend:hide},pa2Teaser;
																			{protected_legend:hide},protected;
																			{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['subpalettes']['pa2TimeFilter'] = 'pa2TimeFilterStart,pa2TimeFilterEnd';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['name']['eval']['tl_class'] = 'w50';

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2Mode'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2Mode'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('pa2_on_one_page', 'pa2_only_album_view', 'pa2_with_detail_page'),
	'reference'               => &$GLOBALS['TL_LANG']['PA2']['moduleModeTypes'],
	'default'                 => 'pa2_on_one_page',
	'eval'                    => array('submitOnChange'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2PreviewImage'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2PreviewImage'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'default'                 => 'use_album_options',
	'options'                 => $GLOBALS['pa2']['modulePreviewImageTypes'],
	'reference'               => &$GLOBALS['TL_LANG']['PA2']['previewImageModuleTypes'],
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2OverviewPage'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2OverviewPage'],
	'exclude'                 => true,
	'inputType'               => 'pageTree',
	'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2DetailPage'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2DetailPage'],
	'exclude'                 => true,
	'inputType'               => 'pageTree',
	'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2Archives'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2Archives'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options_callback'        => array('tl_module_photoalbums2', 'getPhotoalbums2Archives'),
	'eval'                    => array('mandatory'=>true, 'multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumSortType'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumSortType'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => $GLOBALS['pa2']['albumSortTypes'],
	'reference'               => &$GLOBALS['TL_LANG']['PA2']['albumSortTypes'],
	'eval'                    => array('submitOnChange'=>true),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumSort'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumSort'],
	'exclude'                 => true,
	'inputType'               => 'SortWizard',
	'options_callback'        => array('tl_module_photoalbums2', 'getAlbumSort'),
	'eval'                    => array('reloadButton'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumViewTemplate'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumViewTemplate'],
	'exclude'                 => true,
	'flag'                    => 11,
	'inputType'               => 'select',
	'options_callback'        => array('Pa2Backend', 'getPa2WrapTemplates'),
	'eval'                    => array('chosen'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2ImageViewTemplate'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2ImageViewTemplate'],
	'exclude'                 => true,
	'flag'                    => 11,
	'inputType'               => 'select',
	'options_callback'        => array('Pa2Backend', 'getPa2WrapTemplates'),
	'eval'                    => array('chosen'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsTemplate'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsTemplate'],
	'exclude'                 => true,
	'flag'                    => 11,
	'inputType'               => 'select',
	'options_callback'        => array('Pa2Backend', 'getPa2AlbumTemplates'),
	'eval'                    => array('chosen'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2ImagesTemplate'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2ImagesTemplate'],
	'exclude'                 => true,
	'flag'                    => 11,
	'inputType'               => 'select',
	'options_callback'        => array('Pa2Backend', 'getPa2ImageTemplates'),
	'eval'                    => array('chosen'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsShowHeadline'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowHeadline'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'default'                 => 1,
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2ImagesShowHeadline'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowHeadline'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'default'                 => 1,
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsShowTitle'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowTitle'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'default'                 => 1,
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2ImagesShowTitle'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowTitle'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'default'                 => 1,
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsShowTeaser'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowTeaser'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'default'                 => 1,
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2ImagesShowTeaser'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowTeaser'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'default'                 => 1,
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsImageSize'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsImageSize'],
	'exclude'                 => true,
	'inputType'               => 'imageSize',
	'options'                 => $GLOBALS['TL_CROP'],
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2ImagesImageSize'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2ImagesImageSize'],
	'exclude'                 => true,
	'inputType'               => 'imageSize',
	'options'                 => $GLOBALS['TL_CROP'],
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsImageMargin'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsImageMargin'],
	'exclude'                 => true,
	'inputType'               => 'trbl',
	'options'                 => array('px', '%', 'em', 'pt', 'pc', 'in', 'cm', 'mm'),
	'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(128) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2ImagesImageMargin'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2ImagesImageMargin'],
	'exclude'                 => true,
	'inputType'               => 'trbl',
	'options'                 => array('px', '%', 'em', 'pt', 'pc', 'in', 'cm', 'mm'),
	'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(128) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsPerRow'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsPerRow'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'default'                 => 1,
	'options'                 => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
	'eval'                    => array('mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
	'sql'                     => "smallint(5) unsigned NOT NULL default '1'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2ImagesPerRow'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2ImagesPerRow'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'default'                 => 2,
	'options'                 => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
	'eval'                    => array('mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
	'sql'                     => "smallint(5) unsigned NOT NULL default '2'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsPerPage'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsPerPage'],
	'default'                 => 5,
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'                     => "smallint(5) unsigned NOT NULL default '5'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2ImagesPerPage'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2ImagesPerPage'],
	'default'                 => 24,
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'                     => "smallint(5) unsigned NOT NULL default '24'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2NumberOfAlbums'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2NumberOfAlbums'],
	'default'                 => 0,
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'                     => "smallint(5) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2NumberOfImages'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2NumberOfImages'],
	'default'                 => 0,
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'                     => "smallint(5) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsShowMetaDescriptions'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowMetaDescriptions'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'default'                 => 1,
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2ImagesShowMetaDescriptions'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2ImagesShowMetaDescriptions'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'default'                 => 1,
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsMetaFields'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsMetaFields'],
	'exclude'                 => true,
	'inputType'               => 'checkboxWizard',
	'options'                 => $GLOBALS['pa2']['metaFields'],
	'reference'               => &$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldOptions'],
	'eval'                    => array('multiple'=>true, 'tl_class'=>'w50 cbxes'),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2ImagesMetaFields'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2ImagesMetaFields'],
	'exclude'                 => true,
	'inputType'               => 'checkboxWizard',
	'options'                 => $GLOBALS['pa2']['metaFields'],
	'reference'               => &$GLOBALS['TL_LANG']['PA2']['pa2MetaFieldOptions'],
	'eval'                    => array('multiple'=>true, 'tl_class'=>'w50 cbxes'),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2TimeFilter'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2TimeFilterStart'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilterStart'],
	'exclude'                 => true,
	'inputType'               => 'timePeriod',
	'default'                 => 'days',
	'options'                 => $GLOBALS['pa2']['timeFilterOptions'],
	'reference'               => &$GLOBALS['TL_LANG']['PA2']['pa2TimeFilterOptions'],
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2TimeFilterEnd'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilterEnd'],
	'exclude'                 => true,
	'inputType'               => 'timePeriod',
	'default'                 => 'days',
	'options'                 => $GLOBALS['pa2']['timeFilterOptions'],
	'reference'               => &$GLOBALS['TL_LANG']['PA2']['pa2TimeFilterOptions'],
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2Teaser'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2Teaser'],
	'exclude'                 => true,
	'inputType'               => 'TranslationTextArea',
	'eval'                    => array('rte'=>'tinyFlash', 'tl_class'=>'long'),
	'sql'                     => "int(10) unsigned NOT NULL default '0'"
);


/**
 * Class tl_module_photoalbums2
 *
 * @copyright  Daniel Kiesel 2012-2014
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class tl_module_photoalbums2 extends Pa2Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}


	/**
	 * Get all archives from photoalbums2 and return them as array
	 * @return array
	 */
	public function getPhotoalbums2Archives()
	{
		if (!$this->User->isAdmin && !is_array($this->User->photoalbums2_archive))
		{
			return array();
		}

		$arrArchives = array();
		$objArchives = \Photoalbums2ArchiveModel::findAll(array('order'=>'title'));

		if ($objArchives !== null)
		{
			while ($objArchives->next())
			{
				if ($this->User->isAdmin || $this->User->hasAccess($objArchives->id, 'photoalbums2_archive'))
				{
					$arrArchives[$objArchives->id] = $objArchives->title;
				}
			}
		}

		return $arrArchives;
	}


	/**
	 * getAlbumSort function.
	 *
	 * @access public
	 * @param DataContainer $dc
	 * @return void
	 */
	public function getAlbumSort(DataContainer $dc)
	{
		$arrArchives = array();
		$arrAlbumSort = array();

		// Get chosen archives
		$pa2Archives = deserialize($dc->activeRecord->pa2Archives);

		// Get released archives and albums as object
		$objPa2Archive = new \Pa2Archive($pa2Archives, array());
		$objArchives = $objPa2Archive->getArchives();
		$objAlbums = $objPa2Archive->getAlbums();

		// Get title from archives and add them to array
		if ($objArchives !== null)
		{
			while($objArchives->next())
			{
				$arrArchives[$objArchives->id] = $objArchives->title;
			}
		}

		// Get complete album and archive titles and add them to array
		if ($objAlbums !== null)
		{
			while($objAlbums->next())
			{
				$arrAlbumSort[$objAlbums->id] = $objAlbums->title . ' (' . $arrArchives[$objAlbums->pid] . ')';
			}
		}

		return $arrAlbumSort;
	}


	/**
	 * handleListAndViewModule function.
	 *
	 * @access public
	 * @param \DataContainer $dc
	 * @return void
	 */
	public function handleListAndViewModule(\DataContainer $dc)
	{
		// Check if has active record
		if (!$dc->activeRecord)
		{
			return;
		}

		// Get module object
		$objModule = \ModuleModel::findByPk($dc->id);

		switch ($dc->activeRecord->type)
		{
			case 'photoalbums2list':
				$objModule->pa2Mode = 'pa2_with_detail_page';
				$objModule->pa2OverviewPage = '';
				break;

			case 'photoalbums2view':
				$objModule->pa2Mode = 'pa2_with_detail_page';
				$objModule->pa2DetailPage = '';
				break;
		}

		$objModule->save();
	}


	/**
	 * fixPa2Palette function.
	 *
	 * @access public
	 * @return void
	 */
	public function fixPa2Palette()
	{
		// Get pa2Mode
		$objModule = ModuleModel::findByPk($this->Input->get('id'));
		$pa2Mode = $objModule->pa2Mode;

		// If pa2Mode is not set
		if ($pa2Mode != 'pa2_on_one_page' && $pa2Mode != 'pa2_only_album_view' && $pa2Mode != 'pa2_with_detail_page')
		{
			$pa2Mode = 'pa2_on_one_page';
		}

		// Fix pa2 palette
		$GLOBALS['TL_DCA']['tl_module']['palettes']['photoalbums2'] = $GLOBALS['TL_DCA']['tl_module']['palettes'][$pa2Mode];

		// Fix pa2 field position via mode
		switch ($pa2Mode)
		{
			case 'pa2_only_album_view':
				$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsTemplate']['eval']['tl_class'] = 'w50 clr';
				$GLOBALS['TL_DCA']['tl_module']['fields']['pa2NumberOfAlbums']['eval']['tl_class'] = 'w50 clr';
				$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsPerPage']['eval']['tl_class'] = 'w50 clr';
				$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsPerRow']['eval']['tl_class'] = 'w50 clr';
				$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsShowHeadline']['eval']['tl_class'] = 'w50 clr';
				$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsShowTitle']['eval']['tl_class'] = 'w50 clr';
				$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsShowTeaser']['eval']['tl_class'] = 'w50 clr';
				$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsImageSize']['eval']['tl_class'] = 'w50 clr';
				$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsImageMargin']['eval']['tl_class'] = 'w50 clr';
				$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsShowMetaDescriptions']['eval']['tl_class'] = 'w50 clr';
				$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsMetaFields']['eval']['tl_class'] = 'w50 cbxes clr';
				break;
		}

		// Fix pa2 field position via type
		switch ($objModule->type)
		{
			case 'photoalbums2list':
				$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsMetaFields']['eval']['tl_class'] = 'w50 cbxes clr';
				break;

			case 'photoalbums2view':
				$GLOBALS['TL_DCA']['tl_module']['fields']['pa2ImagesMetaFields']['eval']['tl_class'] = 'w50 cbxes clr';
				break;
		}

		// Remove fields from palette
		if ($objModule->pa2AlbumSortType != 'custom')
		{
			$this->removeFromPalette('tl_module', 'photoalbums2', 'pa2AlbumSort');
		}
	}
}
