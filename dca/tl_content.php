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
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <http://www.daniel-kiesel.de/contao>
 * @package    photoalbums2 
 * @license    LGPL 
 * @filesource
 */


/**
 * Table tl_content 
 */
$GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback'][] = array('Pa2Backend', 'checkTimeFilter');
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'pa2TimeFilter';
$GLOBALS['TL_DCA']['tl_content']['palettes']['photoalbums2']			 = '{type_legend},type,headline;
																			{config_legend},pa2Album;
																			{pa2Template_legend},pa2PhotosTemplate,pa2NumberOfPhotos,pa2PhotosPerPage,pa2PhotosShowHeadline,pa2PhotosShowTitle,pa2PhotosShowTeaser;
																			{pa2Image_legend},pa2PhotosPerRow,pa2PhotosImageSize,pa2PhotosImageMargin;
																			{pa2Meta_legend:hide},pa2PhotosMetaFields;
																			{pa2TimeFilter_legend:hide},pa2TimeFilter;
																			{pa2Other_legend:hide},pa2Teaser;
																			{protected_legend:hide},protected;
																			{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_content']['subpalettes']['pa2TimeFilter'] = 'pa2TimeFilterStart,pa2TimeFilterEnd';

$GLOBALS['TL_DCA']['tl_content']['fields']['pa2PreviewPic'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['pa2PreviewPic'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'default'                 => 'use_album_options',
	'options'				  => $GLOBALS['Pa2']['pa2_preview_pic_module_types'],
	'reference'				  => &$GLOBALS['TL_LANG']['pa2_preview_pic_module_types'],
	'eval'                    => array('tl_class'=>'long')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['pa2Album'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['pa2Album'],
    'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_content_photoalbums2', 'getPhotoalbums2Albums'),
	'eval'                    => array('mandatory'=>true)
);

$GLOBALS['TL_DCA']['tl_content']['fields']['pa2PhotosTemplate'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['pa2PhotosTemplate'],
    'exclude'                 => true,
    'filter'                  => true,
    'search'                  => true,
    'sorting'                 => true,
    'flag'                    => 11,
    'inputType'               => 'select',
    'options_callback'        => array('tl_content_photoalbums2', 'getPhotosTemplates'),
    'eval'                    => array('tl_class'=>'long')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['pa2NumberOfPhotos'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['pa2NumberOfPhotos'],
	'default'                 => 0,
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['pa2PhotosPerPage'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['pa2PhotosPerPage'],
    'default'                 => 24,
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('rgxp'=>'digit')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['pa2PhotosPerRow'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['pa2PhotosPerRow'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'default'                 => 2,
    'options'                 => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
    'eval'                    => array('mandatory'=>true)
);

$GLOBALS['TL_DCA']['tl_content']['fields']['pa2PhotosShowHeadline'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['pa2PhotosShowHeadline'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
	'default'                 => 1,
    'eval'                    => array('tl_class'=>'long')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['pa2PhotosShowTitle'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['pa2PhotosShowTitle'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
	'default'                 => 1,
    'eval'                    => array('tl_class'=>'long')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['pa2PhotosShowTeaser'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['pa2PhotosShowTeaser'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
	'default'                 => 1,
    'eval'                    => array('tl_class'=>'long')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['pa2PhotosImageSize'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['pa2PhotosImageSize'],
    'exclude'                 => true,
    'inputType'               => 'imageSize',
    'options'                 => array('crop', 'proportional', 'box'),
    'reference'               => &$GLOBALS['TL_LANG']['MSC'],
    'eval'                    => array('rgxp'=>'digit', 'nospace'=>true)
);

$GLOBALS['TL_DCA']['tl_content']['fields']['pa2PhotosImageMargin'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['pa2PhotosImageMargin'],
    'exclude'                 => true,
    'inputType'               => 'trbl',
    'options'                 => array('px', '%', 'em', 'pt', 'pc', 'in', 'cm', 'mm'),
    'eval'                    => array('includeBlankOption'=>true)
);

$GLOBALS['TL_DCA']['tl_content']['fields']['pa2PhotosMetaFields'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['pa2PhotosMetaFields'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => $GLOBALS['Pa2']['metaFields'],
	'reference'               => &$GLOBALS['TL_LANG']['pa2']['pa2MetaFields_options'],
	'eval'                    => array('multiple'=>true)
);

$GLOBALS['TL_DCA']['tl_content']['fields']['pa2TimeFilter'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilter'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true)
);

$GLOBALS['TL_DCA']['tl_content']['fields']['pa2TimeFilterStart'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilterStart'],
    'exclude'                 => true,
    'inputType'               => 'timePeriod',
    'default'				  => 'days',
    'options'                 => array(/*'seconds', 'minutes', 'hours', */'days', 'weeks', 'months', 'years'),
	'reference'               => &$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options'],
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['pa2TimeFilterEnd'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['pa2TimeFilterEnd'],
    'exclude'                 => true,
    'inputType'               => 'timePeriod',
    'default'				  => 'days',
    'options'                 => array(/*'seconds', 'minutes', 'hours', */'days', 'weeks', 'months', 'years'),
	'reference'               => &$GLOBALS['TL_LANG']['pa2']['pa2TimeFilter_options'],
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['pa2Teaser'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['pa2Teaser'],
    'exclude'                 => true,
    'inputType'               => 'textarea',
	'eval'                    => array('rte'=>'tinyFlash', 'tl_class'=>'long')
);


/**
 * Class tl_content_photoalbums2
 *
 * @copyright	Daniel Kiesel 2012
 * @author		Daniel Kiesel <http://www.daniel-kiesel.de/contao>
 * @package    Controller
 */
class tl_content_photoalbums2 extends Backend
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
	public function getPhotoalbums2Albums()
	{
		if (!$this->User->isAdmin && !is_array($this->User->photoalbums2_archive))
		{
			return array();
		}

		$arrArchives = array();
		$objArchives = $this->Database->execute("SELECT id, title FROM tl_photoalbums2_archive ORDER BY title");

		while ($objArchives->next())
		{
			if ($this->User->isAdmin || $this->User->hasAccess($objArchives->id, 'photoalbums2_archive'))
			{
				$objAlbums = $this->Database->prepare("SELECT id, title FROM tl_photoalbums2_album WHERE pid=? ORDER BY title")
											->execute($objArchives->id);
				
				while ($objAlbums->next())
				{
					$arrArchives[$objArchives->title][$objAlbums->id] = $objAlbums->title;
				}
			}
		}
		
		return $arrArchives;
	}


	/**
	 * Return all album templates as array
	 * @param DataContainer
	 * @return array
	 */
	public function getPhotosTemplates(DataContainer $dc)
	{
		$intPid = $dc->activeRecord->pid;

		if ($this->Input->get('act') == 'overrideAll')
		{
			$intPid = $this->Input->get('id');
		}

		return $this->getTemplateGroup('pa2_photo', $intPid);
	}
}

?>