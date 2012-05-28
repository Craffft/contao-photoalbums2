<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
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
 * Table tl_module 
 */
$GLOBALS['TL_DCA']['tl_module']['config']['onsubmit_callback'][] = array('tl_module_photoalbums2', 'checkTimeFilter');
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'pa2TimeFilter';
$GLOBALS['TL_DCA']['tl_module']['palettes']['photoalbums2'] = '{title_legend},name,headline,type;
																{config_legend},pa2Archives,pa2AlbumsTemplate,pa2PhotosTemplate,pa2NumberOfAlbums,pa2NumberOfPhotos,pa2AlbumsPerPage,pa2PhotosPerPage,pa2AlbumsShowHeadline,pa2PhotosShowHeadline,pa2AlbumsShowTitle,pa2PhotosShowTitle;
																{pa2Image_legend},pa2AlbumsPerRow,pa2PhotosPerRow,pa2AlbumsImageSize,pa2PhotosImageSize,pa2AlbumsImageMargin,pa2PhotosImageMargin;
																{pa2Meta_legend:hide},pa2AlbumsMetaFields,pa2PhotosMetaFields;
																{pa2PageView_legend},pa2DetailPage;
																{pa2TimeFilter_legend:hide},pa2TimeFilter;
																{protected_legend:hide},protected;
																{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['subpalettes']['pa2TimeFilter'] = 'pa2TimeFilterStart,pa2TimeFilterEnd';

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2Archives'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2Archives'],
    'exclude'                 => true,
	'inputType'               => 'checkboxWizard',
	'options_callback'        => array('tl_module_photoalbums2', 'getPhotoalbums2Archives'),
	'eval'                    => array('mandatory'=>true, 'multiple'=>true)
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
    'eval'                    => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2PhotosTemplate'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2PhotosTemplate'],
    'exclude'                 => true,
    'filter'                  => true,
    'search'                  => true,
    'sorting'                 => true,
    'flag'                    => 11,
    'inputType'               => 'select',
    'options_callback'        => array('tl_module_photoalbums2', 'getPhotosTemplates'),
    'eval'                    => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2NumberOfAlbums'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2NumberOfAlbums'],
	'default'                 => 0,
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2NumberOfPhotos'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2NumberOfPhotos'],
	'default'                 => 0,
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsPerPage'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsPerPage'],
    'default'                 => 5,
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2PhotosPerPage'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2PhotosPerPage'],
    'default'                 => 24,
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsPerRow'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsPerRow'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'default'                 => 1,
    'options'                 => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
    'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2PhotosPerRow'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2PhotosPerRow'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'default'                 => 2,
    'options'                 => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
    'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsShowHeadline'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowHeadline'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
	'default'                 => 1,
    'eval'                    => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2PhotosShowHeadline'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2PhotosShowHeadline'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
	'default'                 => 1,
    'eval'                    => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsShowTitle'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsShowTitle'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
	'default'                 => 1,
    'eval'                    => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2PhotosShowTitle'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2PhotosShowTitle'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
	'default'                 => 1,
    'eval'                    => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsImageSize'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsImageSize'],
    'exclude'                 => true,
    'inputType'               => 'imageSize',
    'options'                 => array('crop', 'proportional', 'box'),
    'reference'               => &$GLOBALS['TL_LANG']['MSC'],
    'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2PhotosImageSize'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2PhotosImageSize'],
    'exclude'                 => true,
    'inputType'               => 'imageSize',
    'options'                 => array('crop', 'proportional', 'box'),
    'reference'               => &$GLOBALS['TL_LANG']['MSC'],
    'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsImageMargin'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsImageMargin'],
    'exclude'                 => true,
    'inputType'               => 'trbl',
    'options'                 => array('px', '%', 'em', 'pt', 'pc', 'in', 'cm', 'mm'),
    'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2PhotosImageMargin'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2PhotosImageMargin'],
    'exclude'                 => true,
    'inputType'               => 'trbl',
    'options'                 => array('px', '%', 'em', 'pt', 'pc', 'in', 'cm', 'mm'),
    'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2AlbumsMetaFields'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2AlbumsMetaFields'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => $GLOBALS['Pa2']['metaFields'],
	'reference'               => &$GLOBALS['TL_LANG']['tl_module']['pa2MetaFields_options'],
	'eval'                    => array('multiple'=>true)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2PhotosMetaFields'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2PhotosMetaFields'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => $GLOBALS['Pa2']['metaFields'],
	'reference'               => &$GLOBALS['TL_LANG']['tl_module']['pa2MetaFields_options'],
	'eval'                    => array('multiple'=>true)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2DetailPage'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2DetailPage'],
    'exclude'                 => true,
    'inputType'               => 'pageTree',
    'eval'                    => array('fieldType'=>'radio')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2TimeFilter'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2TimeFilterStart'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilterStart'],
    'exclude'                 => true,
    'inputType'               => 'timePeriod',
    'default'				  => 'days',
    'options'                 => array(/*'seconds', 'minutes', 'hours', */'days', 'weeks', 'months', 'years'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter_options'],
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pa2TimeFilterEnd'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilterEnd'],
    'exclude'                 => true,
    'inputType'               => 'timePeriod',
    'default'				  => 'days',
    'options'                 => array(/*'seconds', 'minutes', 'hours', */'days', 'weeks', 'months', 'years'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_module']['pa2TimeFilter_options'],
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50')
);


/**
 * Class tl_module_photoalbums2
 *
 * @copyright	Daniel Kiesel 2012
 * @author		Daniel Kiesel <http://www.daniel-kiesel.de/contao>
 * @package    Controller
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
		$objArchives = $this->Database->execute("SELECT id, title FROM tl_photoalbums2_archive ORDER BY title");

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
	 * checkTimeFilter function.
	 * 
	 * @access public
	 * @param DataContainer $dc
	 * @return void
	 */
	public function checkTimeFilter(DataContainer $dc)
	{
		// Return if there is no active record (override all)
		if (!$dc->activeRecord)
		{
			return;
		}
		
		// Import Photoalbums2 class
		$this->import('Pa2');
		
		// Set arrSet
		$arrSet['pa2TimeFilterStart'] = deserialize($dc->activeRecord->pa2TimeFilterStart);
		$arrSet['pa2TimeFilterEnd'] = deserialize($dc->activeRecord->pa2TimeFilterEnd);
		
		if ($dc->activeRecord->pa2TimeFilter == 1)
		{
			// Set pa2TimeFilterStart
			if(empty($arrSet['pa2TimeFilterStart']['value']) || $arrSet['pa2TimeFilterStart']['value'] < 0)
			{
				$arrSet['pa2TimeFilterStart']['value'] = '0';
			}
			
			// Set pa2TimeFilterEnd
			if(empty($arrSet['pa2TimeFilterEnd']['value']) || $arrSet['pa2TimeFilterEnd']['value'] < 0)
			{
				$arrSet['pa2TimeFilterEnd']['value'] = '0';
			}
			
			// Check startdate and enddate
			if($this->Pa2->getTimeFilterData($arrSet['pa2TimeFilterStart']) > $this->Pa2->getTimeFilterData($arrSet['pa2TimeFilterEnd']))
			{
				$arrSet['pa2TimeFilterEnd'] = $arrSet['pa2TimeFilterStart'];
			}
			
			// Serialize
			$arrSet['pa2TimeFilterStart'] = serialize($arrSet['pa2TimeFilterStart']);
			$arrSet['pa2TimeFilterEnd'] = serialize($arrSet['pa2TimeFilterEnd']);
			
			// Update date
			$this->Database->prepare("UPDATE tl_module %s WHERE id=?")->set($arrSet)->execute($dc->id);
		}
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