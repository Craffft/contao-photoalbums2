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
 * @author     Daniel Kiesel 
 * @package    photoalbums2 
 * @license    LGPL 
 * @filesource
 */


/**
 * Table tl_photoalbums2_album 
 */
$GLOBALS['TL_DCA']['tl_photoalbums2_album'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'ptable'					  => 'tl_photoalbums2_archive',
		'onsubmit_callback' => array
		(
			array('tl_photoalbums2_album', 'adjustTime')
		),
		'onload_callback' => array
		(
			array('tl_photoalbums2_album', 'checkPermission')
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('sorting'),
			'headerFields'            => array('title'),
			'panelLayout'             => 'search,limit',
			'child_record_callback'   => array('tl_photoalbums2_album', 'listAlbums')
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
				'button_callback'     => array('tl_photoalbums2_album', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('pic_sort_check', 'protected'),
		'default'                     => '{title_legend},title,alias;{date_legend},startdate,enddate;{pictures_legend},pictures,pic_preview,pic_sort_check;{info_legend},event,place,photographer,description;{protected_legend},protected;{published_legend},published',
		'pic_sort_wizard'             => '{title_legend},title,alias;{date_legend},startdate,enddate;{pictures_legend},pictures,pic_preview,pic_sort_check,pic_sort;{info_legend},event,place,photographer,description;{protected_legend},protected;{published_legend},published'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'protected'                   => 'users,groups'
	),

	// Fields
	'fields' => array
	(
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50')
		),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['alias'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_photoalbums2_album', 'generateAlias')
			)
		),
		'startdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['startdate'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>true, 'tl_class'=>'w50 wizard')
		),
		'enddate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['enddate'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>true, 'tl_class'=>'w50 wizard')
		),
		'pictures' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['pictures'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('mandatory'=>true, 'fieldType'=>'checkbox', 'files'=>true, 'extensions'=>'png,jpg,jpeg,gif')
		),
		'pic_preview' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['pic_preview'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>'png,jpg,jpeg,gif')
		),
		'pic_sort_check' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['pic_sort_check'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'				  => $GLOBALS['Pa2']['pa2_sort_types'],
			'reference'				  => &$GLOBALS['TL_LANG']['pa2_sort_types'],
			'eval'                    => array('submitOnChange'=>true)
		),
		'pic_sort' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['pic_sort'],
			'exclude'                 => true,
			'inputType'               => 'PicSortWizard',
			'eval'                    => array('sortfiles'=>'pictures', 'extensions'=>'png,jpg,jpeg,gif')
		),
		'event' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['event'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
		),
		'place' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['place'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
		),
		'photographer' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['photographer'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255)
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['description'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE')
		),
		'protected' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['protected'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true)
		),
		'users' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['users'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'foreignKey'              => 'tl_member.username',
			'eval'                    => array('multiple'=>true, 'tl_class'=>'w50')
		),
		'groups' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['groups'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'foreignKey'              => 'tl_member_group.name',
			'eval'                    => array('multiple'=>true, 'tl_class'=>'w50')
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['published'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array()
		)
	)
);


/**
 * tl_photoalbums2_album class.
 * 
 * @extends Backend
 */
class tl_photoalbums2_album extends Backend
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
	 * Check permissions to edit table tl_photoalbums2_album
	 */
	public function checkPermission()
	{
		if ($this->User->isAdmin)
		{
			return;
		}

		// Set root IDs
		if (!is_array($this->User->photoalbums) || empty($this->User->photoalbums))
		{
			$root = array(0);
		}
		else
		{
			$root = $this->User->photoalbums;
		}

		$id = strlen($this->Input->get('id')) ? $this->Input->get('id') : CURRENT_ID;

		// Check current action
		switch ($this->Input->get('act'))
		{
			case 'paste':
				// Allow
				break;

			case 'create':
				if (!strlen($this->Input->get('pid')) || !in_array($this->Input->get('pid'), $root))
				{
					$this->log('Not enough permissions to create photoalbums items in photoalbums archive ID "'.$this->Input->get('pid').'"', 'tl_photoalbums2_album checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;

			case 'cut':
			case 'copy':
				if (!in_array($this->Input->get('pid'), $root))
				{
					$this->log('Not enough permissions to '.$this->Input->get('act').' photoalbums item ID "'.$id.'" to photoalbums archive ID "'.$this->Input->get('pid').'"', 'tl_photoalbums2_album checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				// NO BREAK STATEMENT HERE

			case 'edit':
			case 'show':
			case 'delete':
			case 'toggle':
			case 'feature':
				$objArchive = $this->Database->prepare("SELECT pid FROM tl_photoalbums2_album WHERE id=?")
											 ->limit(1)
											 ->execute($id);

				if ($objArchive->numRows < 1)
				{
					$this->log('Invalid photoalbums item ID "'.$id.'"', 'tl_photoalbums2_album checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				if (!in_array($objArchive->pid, $root))
				{
					$this->log('Not enough permissions to '.$this->Input->get('act').' photoalbums item ID "'.$id.'" of photoalbums archive ID "'.$objArchive->pid.'"', 'tl_photoalbums2_album checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;

			case 'select':
			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
			case 'cutAll':
			case 'copyAll':
				if (!in_array($id, $root))
				{
					$this->log('Not enough permissions to access photoalbums archive ID "'.$id.'"', 'tl_photoalbums2_album checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				$objArchive = $this->Database->prepare("SELECT id FROM tl_photoalbums2_album WHERE pid=?")
											 ->execute($id);

				if ($objArchive->numRows < 1)
				{
					$this->log('Invalid photoalbums archive ID "'.$id.'"', 'tl_photoalbums2_album checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				$session = $this->Session->getData();
				$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $objArchive->fetchEach('id'));
				$this->Session->setData($session);
				break;

			default:
				if (strlen($this->Input->get('act')))
				{
					$this->log('Invalid command "'.$this->Input->get('act').'"', 'tl_photoalbums2_album checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				elseif (!in_array($id, $root))
				{
					$this->log('Not enough permissions to access photoalbums archive ID "'.$id.'"', 'tl_photoalbums2_album checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;
		}
	}
	
	
	/**
	 * Add the type of input field
	 * @param array
	 * @return string
	 */
	public function listAlbums($arrRow)
	{
		// Generate thumbnail
		$thumbnail = '';
		$currentFile = $arrRow['pic_preview'];
		
		if (!empty($currentFile))
		{
			$currentEncoded = $this->urlEncode($currentFile);
			
			$objFile = new File($currentFile);
			
			// Generate thumbnail
			if ($objFile->isGdImage && $objFile->height > 0)
			{
			    if ($GLOBALS['TL_CONFIG']['thumbnails'] && $objFile->height <= $GLOBALS['TL_CONFIG']['gdMaxImgHeight'] && $objFile->width <= $GLOBALS['TL_CONFIG']['gdMaxImgWidth'])
			    {
			    	$_height = ($objFile->height < 50) ? $objFile->height : 50;
			    	$_width = (($objFile->width * $_height / $objFile->height) > 400) ? 90 : '';
			
			    	$thumbnail = '<img src="' . TL_FILES_URL . $this->getImage($currentEncoded, $_width, $_height) . '" alt="" style="margin:0px 0px 2px 23px;">';
			    }
			}
		}
		
		$time = time();
		$key = ($arrRow['published']) ? 'published' : 'unpublished';
		$date = $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $arrRow['date']);

		return '
<div class="cte_type ' . $key . '"><strong>' . $arrRow['title'] . '</strong> - ' . $date . '</div>
<div class="limit_height block">
' . $thumbnail . '
</div>' . "\n";
	}


	/**
	 * Auto-generate the alias if it has not been set yet
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function generateAlias($varValue, DataContainer $dc)
	{
		$autoAlias = false;

		// Generate alias if there is none
		if (!strlen($varValue))
		{
			$autoAlias = true;
			$varValue = standardize($dc->activeRecord->title);
		}
		
		$objAlias = $this->Database->prepare("SELECT id FROM tl_photoalbums2_album WHERE id!=? AND alias=?")
								   ->execute($dc->id, $varValue);

		// Check whether the albums alias exists
		if ($objAlias->numRows > 0 && !$autoAlias)
		{
			throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
		}

		// Add ID to alias
		if ($objAlias->numRows && $autoAlias)
		{
			$varValue .= '-' . $dc->id;
			$varValue = $this->generateAlias($varValue, $dc);
		}
		
		return $varValue;
	}


	/**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen($this->Input->get('tid')))
		{
			$this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 1));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_photoalbums2_album::published', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;id='.$this->Input->get('id').'&amp;tid='.$row['id'].'&amp;state='.$row['published'];

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}		

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}


	/**
	 * Toggle the visibility of an element
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to edit
		$this->Input->setGet('id', $intId);
		$this->Input->setGet('act', 'toggle');
		$this->checkPermission();

		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_photoalbums2_album::published', 'alexf'))
		{
			$this->log('Not enough permissions to show/hide content element ID "'.$intId.'"', 'tl_photoalbums2_album toggleVisibility', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$this->createInitialVersion('tl_photoalbums2_album', $intId);

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_photoalbums2_album']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_photoalbums2_album']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_photoalbums2_album SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
					   ->execute($intId);

		$this->createNewVersion('tl_photoalbums2_album', $intId);
	}
	
	
	/**
	 * adjustTime function.
	 * 
	 * @access public
	 * @param DataContainer $dc
	 * @return void
	 */
	public function adjustTime(DataContainer $dc)
	{
		// Return if there is no active record (override all)
		if (!$dc->activeRecord)
		{
			return;
		}
		
		// Set arrSet
		$arrSet['startdate'] = $dc->activeRecord->startdate;
		$arrSet['enddate'] = $dc->activeRecord->enddate;
		
		// Set startdate
		if(empty($arrSet['startdate']) || $arrSet['startdate'] < 1)
		{
			$arrSet['startdate'] = mktime(0, 0, 0, date('n', time()), date('j', time()), date('Y', time()));
		}
		
		// Set enddate
		if(empty($arrSet['enddate']) || $arrSet['enddate'] < 1)
		{
			$arrSet['enddate'] = 0;
		}
		
		// Check startdate and enddate
		if($arrSet['startdate'] > $arrSet['enddate'])
		{
			$arrSet['enddate'] = $arrSet['startdate'];
		}
		
		// Update date
		$this->Database->prepare("UPDATE tl_photoalbums2_album %s WHERE id=?")->set($arrSet)->execute($dc->id);
	}
}

?>