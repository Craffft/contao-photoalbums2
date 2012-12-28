<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @package   photoalbums2
 * @author    Daniel Kiesel <https://github.com/icodr8>
 * @license   LGPL
 * @copyright Daniel Kiesel 2012
 */


/**
 * Table tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['config']['onsubmit_callback'][] = array('Pa2Backend', 'checkTimeFilter');
$GLOBALS['TL_DCA']['tl_module']['config']['onload_callback'][] = array('tl_module_photoalbums2', 'fixPa2Palette');
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'pa2TimeFilter';
$GLOBALS['TL_DCA']['tl_module']['palettes']['photoalbums2']     = '{title_legend},name,headline,type;
																			{config_legend},pa2Mode';
$GLOBALS['TL_DCA']['tl_module']['palettes']['pa2_on_one_page']    = '{title_legend},name,headline,type;
																			{config_legend},pa2Mode,pa2PreviewImage,pa2Archives;
																			{pa2Template_legend},pa2AlbumsTemplate,pa2ImagesTemplate,pa2NumberOfAlbums,pa2NumberOfImages,pa2AlbumsPerPage,pa2ImagesPerPage,pa2AlbumsShowHeadline,pa2ImagesShowHeadline,pa2AlbumsShowTitle,pa2ImagesShowTitle,pa2AlbumsShowTeaser,pa2ImagesShowTeaser;
																			{pa2Image_legend},pa2AlbumsPerRow,pa2ImagesPerRow,pa2AlbumsImageSize,pa2ImagesImageSize,pa2AlbumsImageMargin,pa2ImagesImageMargin;
																			{pa2Meta_legend:hide},pa2AlbumsMetaFields,pa2ImagesMetaFields;
																			{pa2TimeFilter_legend:hide},pa2TimeFilter;
																			{pa2Other_legend:hide},pa2Teaser;
																			{protected_legend:hide},protected;
																			{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['pa2_only_album_view']   = '{title_legend},name,headline,type;
																			{config_legend},pa2Mode,pa2PreviewImage,pa2Archives;
																			{pa2Template_legend},pa2AlbumsTemplate,pa2NumberOfAlbums,pa2AlbumsPerPage,pa2AlbumsShowHeadline,pa2AlbumsShowTitle,pa2AlbumsShowTeaser;
																			{pa2Image_legend},pa2AlbumsPerRow,pa2AlbumsImageSize,pa2AlbumsImageMargin;
																			{pa2Meta_legend:hide},pa2AlbumsMetaFields;
																			{pa2TimeFilter_legend:hide},pa2TimeFilter;
																			{pa2Other_legend:hide},pa2Teaser;
																			{protected_legend:hide},protected;
																			{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['pa2_with_detail_page']   = '{title_legend},name,headline,type;
																			{config_legend},pa2Mode,pa2DetailPage,pa2PreviewImage,pa2Archives;
																			{pa2Template_legend},pa2AlbumsTemplate,pa2ImagesTemplate,pa2NumberOfAlbums,pa2NumberOfImages,pa2AlbumsPerPage,pa2ImagesPerPage,pa2AlbumsShowHeadline,pa2ImagesShowHeadline,pa2AlbumsShowTitle,pa2ImagesShowTitle,pa2AlbumsShowTeaser,pa2ImagesShowTeaser;
																			{pa2Image_legend},pa2AlbumsPerRow,pa2ImagesPerRow,pa2AlbumsImageSize,pa2ImagesImageSize,pa2AlbumsImageMargin,pa2ImagesImageMargin;
																			{pa2Meta_legend:hide},pa2AlbumsMetaFields,pa2ImagesMetaFields;
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
	'reference'               => &$GLOBALS['TL_LANG']['pa2_mode_types'],
	'default'                 => 'pa2_on_one_page',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'long'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2DetailPage'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2DetailPage'],
	'exclude'                 => true,
	'inputType'               => 'pageTree',
	'eval'                    => array('fieldType'=>'radio'),
	'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2PreviewImage'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2PreviewImage'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'default'                 => 'use_album_options',
	'options'                 => $GLOBALS['Pa2']['preview_image_types_in_module'],
	'reference'               => &$GLOBALS['TL_LANG']['pa2_preview_image_module_types'],
	'eval'                    => array('tl_class'=>'long'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2Archives'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2Archives'],
	'exclude'                 => true,
	'inputType'               => 'checkboxWizard',
	'options_callback'        => array('tl_module_photoalbums2', 'getPhotoalbums2Archives'),
	'eval'                    => array('mandatory'=>true, 'multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsTemplate'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsTemplate'],
	'exclude'                 => true,
	'filter'                  => true,
	'search'                  => true,
	'sorting'                 => true,
	'flag'                    => 11,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_photoalbums2', 'getAlbumsTemplates'),
	'eval'                    => array('chosen'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2ImagesTemplate'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2ImagesTemplate'],
	'exclude'                 => true,
	'filter'                  => true,
	'search'                  => true,
	'sorting'                 => true,
	'flag'                    => 11,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_photoalbums2', 'getImagesTemplates'),
	'eval'                    => array('chosen'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
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
	'eval'                    => array('tl_class'=>'clr'),
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

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsMetaFields'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsMetaFields'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => $GLOBALS['Pa2']['metaFields'],
	'reference'               => &$GLOBALS['TL_LANG']['pa2']['pa2MetaFields_options'],
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2ImagesMetaFields'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2ImagesMetaFields'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => $GLOBALS['Pa2']['metaFields'],
	'reference'               => &$GLOBALS['TL_LANG']['pa2']['pa2MetaFields_options'],
	'eval'                    => array('multiple'=>true),
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
	'options'                 => array(/*'seconds', 'minutes', 'hours', */'days', 'weeks', 'months', 'years'),
	'reference'               => &$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options'],
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2TimeFilterEnd'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilterEnd'],
	'exclude'                 => true,
	'inputType'               => 'timePeriod',
	'default'                 => 'days',
	'options'                 => array(/*'seconds', 'minutes', 'hours', */'days', 'weeks', 'months', 'years'),
	'reference'               => &$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options'],
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2Teaser'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2Teaser'],
	'exclude'                 => true,
	'inputType'               => 'textarea',
	'eval'                    => array('rte'=>'tinyFlash', 'tl_class'=>'long'),
	'sql'                     => "text NULL"
);


/**
 * Class tl_module_photoalbums2
 *
 * @copyright Daniel Kiesel 2012
 * @author    Daniel Kiesel <https://github.com/icodr8>
 * @package   photoalbums2
 */
class tl_module_photoalbums2 extends Backend
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

		while ($objArchives->next())
		{
			if ($this->User->isAdmin || $this->User->hasAccess($objArchives->id, 'photoalbums2_archive'))
			{
				$arrArchives[$objArchives->id] = $objArchives->title;
			}
		}

		return $arrArchives;
	}


	/**
	 * Return all album templates as array
	 * @param DataContainer
	 * @return array
	 */
	public function getAlbumsTemplates(DataContainer $dc)
	{
		$intPid = $dc->activeRecord->pid;

		if ($this->Input->get('act') == 'overrideAll')
		{
			$intPid = $this->Input->get('id');
		}

		return $this->getTemplateGroup('pa2_album', $intPid);
	}


	/**
	 * Return all album templates as array
	 * @param DataContainer
	 * @return array
	 */
	public function getImagesTemplates(DataContainer $dc)
	{
		$intPid = $dc->activeRecord->pid;

		if ($this->Input->get('act') == 'overrideAll')
		{
			$intPid = $this->Input->get('id');
		}

		return $this->getTemplateGroup('pa2_image', $intPid);
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

		// If pa2Mode is not set
		if ($objModule->pa2Mode != 'pa2_on_one_page' && $objModule->pa2Mode != 'pa2_only_album_view' && $objModule->pa2Mode != 'pa2_with_detail_page')
		{
			$objModule->pa2Mode = 'pa2_on_one_page';
		}

		// Fix pa2 palette
		$GLOBALS['TL_DCA']['tl_module']['palettes']['photoalbums2'] = $GLOBALS['TL_DCA']['tl_module']['palettes'][$objModule->pa2Mode];

		// Fix pa2 field position
		if ($objModule->pa2Mode == 'pa2_only_album_view')
		{
			$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsTemplate']['eval']['tl_class'] = 'w50,clr';
			$GLOBALS['TL_DCA']['tl_module']['fields']['pa2NumberOfAlbums']['eval']['tl_class'] = 'w50,clr';
			$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsPerPage']['eval']['tl_class'] = 'w50,clr';
			$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsPerRow']['eval']['tl_class'] = 'w50,clr';
			$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsShowHeadline']['eval']['tl_class'] = 'w50,clr';
			$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsShowTitle']['eval']['tl_class'] = 'w50,clr';
			$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsShowTeaser']['eval']['tl_class'] = 'w50,clr';
			$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsImageSize']['eval']['tl_class'] = 'w50,clr';
			$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsImageMargin']['eval']['tl_class'] = 'w50,clr';
		}
	}
}
