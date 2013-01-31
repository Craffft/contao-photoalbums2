<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @package   photoalbums2
 * @author    Daniel Kiesel <https://github.com/icodr8>
 * @license   LGPL
 * @copyright Daniel Kiesel 2012-2013
 */


/**
 * Table tl_photoalbums2_album
 */
$GLOBALS['TL_DCA']['tl_photoalbums2_album'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'     => 'Table',
		'enableVersioning'  => true,
		'ptable'            => 'tl_photoalbums2_archive',
		'onload_callback'   => array
		(
			array('tl_photoalbums2_album', 'checkPermission'),
			array('tl_photoalbums2_album', 'generateFeed'),
			array('tl_photoalbums2_album', 'generatePalette')
		),
		'oncut_callback'    => array
		(
			array('tl_photoalbums2_album', 'scheduleUpdate')
		),
		'ondelete_callback' => array
		(
			array('tl_photoalbums2_album', 'scheduleUpdate')
		),
		'onsubmit_callback' => array
		(
			array('tl_photoalbums2_album', 'adjustTime'),
			array('tl_photoalbums2_album', 'scheduleUpdate')
		),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index',
				'alias' => 'index'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('sorting'),
			'headerFields'            => array('title', 'tstamp', 'protected', 'allowComments', 'makeFeed'),
			'panelLayout'             => 'search,limit',
			'child_record_callback'   => array('tl_photoalbums2_album', 'listAlbums')
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
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset()"'
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
		'__selector__'                => array('imageSortType', 'previewImageType', 'protected'),
		'default'                     => '{title_legend},title,alias,author;{date_legend},startdate,enddate;{images_legend},images,imageSortType,imageSort,previewImageType,previewImage;{info_legend},event,place,photographer,description;{protected_legend},protected;{expert_legend:hide},cssClass,noComments;{published_legend},published,start,stop'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'protected'                   => 'users,groups',
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'label'                   => array('ID'),
			'search'                  => true,
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'sorting' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['alias'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
			'save_callback'           => array
			(
				array('tl_photoalbums2_album', 'generateAlias')
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'author' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['author'],
			'default'                 => $this->User->id,
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_user.name',
			'eval'                    => array('doNotCopy'=>true, 'chosen'=>true, 'mandatory'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'startdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['startdate'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'enddate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['enddate'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'images' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['images'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('mandatory'=>true, 'multiple'=>true, 'fieldType'=>'checkbox', 'files'=>true, 'extensions'=>'png,jpg,jpeg,gif'),
			'sql'                     => "blob NULL"
		),
		'imageSortType' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['imageSortType'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => $GLOBALS['pa2']['imageSortTypes'],
			'reference'               => &$GLOBALS['TL_LANG']['pa2']['imageSortTypes'],
			'eval'                    => array('submitOnChange'=>true),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'imageSort' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['imageSort'],
			'exclude'                 => true,
			'inputType'               => 'ImageSortWizard',
			'eval'                    => array('sortfiles'=>'images', 'extensions'=>'png,jpg,jpeg,gif'),
			'sql'                     => "blob NULL"
		),
		'previewImageType' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['previewImageType'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => $GLOBALS['pa2']['albumPreviewImageTypes'],
			'reference'               => &$GLOBALS['TL_LANG']['pa2']['albumPreviewImageTypes'],
			'eval'                    => array('submitOnChange'=>true),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'previewImage' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['previewImage'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>'png,jpg,jpeg,gif'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'event' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['event'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'place' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['place'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'photographer' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['photographer'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['description'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyFlash'),
			'sql'                     => "text NULL"
		),
		'protected' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['protected'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'users' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['users'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'foreignKey'              => 'tl_member.username',
			'eval'                    => array('multiple'=>true, 'tl_class'=>'w50'),
			'sql'                     => "blob NULL"
		),
		'groups' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['groups'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'foreignKey'              => 'tl_member_group.name',
			'eval'                    => array('multiple'=>true, 'tl_class'=>'w50'),
			'sql'                     => "blob NULL"
		),
		'cssClass' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['cssClass'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'noComments' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['noComments'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['published'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array(),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'start' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['start'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'stop' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_album']['stop'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		)
	)
);


/**
 * tl_photoalbums2_album class.
 *
 * @copyright Daniel Kiesel 2012-2013
 * @author    Daniel Kiesel <https://github.com/icodr8>
 * @package   photoalbums2
 */
class tl_photoalbums2_album extends Pa2Backend
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
		if (!is_array($this->User->photoalbums2s) || empty($this->User->photoalbums2s))
		{
			$root = array(0);
		}
		else
		{
			$root = $this->User->photoalbums2s;
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
				$this->log('Not enough permissions to create photoalbums2 items in photoalbums2 archive ID "'.$this->Input->get('pid').'"', 'tl_photoalbums2_album checkPermission', TL_ERROR);
				$this->redirect('contao/main.php?act=error');
			}
			break;

		case 'cut':
		case 'copy':
			if (!in_array($this->Input->get('pid'), $root))
			{
				$this->log('Not enough permissions to '.$this->Input->get('act').' photoalbums2 item ID "'.$id.'" to photoalbums2 archive ID "'.$this->Input->get('pid').'"', 'tl_photoalbums2_album checkPermission', TL_ERROR);
				$this->redirect('contao/main.php?act=error');
			}
			// NO BREAK STATEMENT HERE

		case 'edit':
		case 'show':
		case 'delete':
		case 'toggle':
		case 'feature':
			$objArchive = \Photoalbums2AlbumModel::findByPk($id);

			if ($objArchive == null)
			{
				$this->log('Invalid photoalbums2 item ID "'.$id.'"', 'tl_photoalbums2_album checkPermission', TL_ERROR);
				$this->redirect('contao/main.php?act=error');
			}

			if (!in_array($objArchive->pid, $root))
			{
				$this->log('Not enough permissions to '.$this->Input->get('act').' photoalbums2 item ID "'.$id.'" of photoalbums2 archive ID "'.$objArchive->pid.'"', 'tl_photoalbums2_album checkPermission', TL_ERROR);
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
				$this->log('Not enough permissions to access photoalbums2 archive ID "'.$id.'"', 'tl_photoalbums2_album checkPermission', TL_ERROR);
				$this->redirect('contao/main.php?act=error');
			}

			$objArchive = \Photoalbums2AlbumModel::findByPid($id);

			if ($objArchive == null)
			{
				$this->log('Invalid photoalbums2 archive ID "'.$id.'"', 'tl_photoalbums2_album checkPermission', TL_ERROR);
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
				$this->log('Not enough permissions to access photoalbums2 archive ID "'.$id.'"', 'tl_photoalbums2_album checkPermission', TL_ERROR);
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
		// Import CSS files
		$objPa2 = new \Pa2();
		$objPa2->addCssFile();

		// Deserialize vars
		$arrRow['images'] = deserialize($arrRow['images']);
		$arrRow['imageSort'] = deserialize($arrRow['imageSort']);
		$arrRow['users'] = deserialize($arrRow['users']);

		// Generate Template
		$objTemplate = new \FrontendTemplate('pa2_wrap');
		$objTemplate->setData($arrRow);

		// Set template vars
		$objTemplate->pa2ImagesShowHeadline = false;
		$objTemplate->pa2ImagesShowTitle    = false;
		$objTemplate->pa2ImagesShowTeaser   = false;
		$objTemplate->pa2ImageMargin        = 0;
		$objTemplate->pa2NumberOfImages     = 0;
		$objTemplate->pa2ImagesPerPage      = 0;
		$objTemplate->pa2ImagesPerRow       = 1;
		$objTemplate->arrImage              = array('size' => array(100, 100, 'crop'));

		// Render image view
		$objImageViewParser = new \Pa2ImageViewParser($objTemplate, $arrRow['id']);
		$objTemplate = $objImageViewParser->getViewParserTemplate();

		// Set key
		$key = $arrRow['invisible'] ? 'unpublished' : 'published';

		return '
<div class="cte_type ' . $key . '">' . $arrRow['title'] . '</div>
<div class="limit_height' . (!$GLOBALS['TL_CONFIG']['doNotCollapse'] ? ' h64' : '') . '">
' . $objTemplate->parse() . '
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

		$objAlias = \Photoalbums2AlbumModel::findBy(array("id!=?", "alias=?"), array($dc->id, $varValue));

		// Check whether the albums alias exists
		if ($objAlias != null && !$autoAlias)
		{
			throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
		}

		// Add ID to alias
		if ($objAlias != null && $autoAlias)
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

		// Update
		$objAlbum = \Photoalbums2AlbumModel::findByPk($intId);
		$objAlbum->tstamp = time();
		$objAlbum->published = ($blnVisible ? 1 : '');
		$objAlbum->save();

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
		$arrSet = array();
		$arrSet['startdate'] = $dc->activeRecord->startdate;
		$arrSet['enddate'] = $dc->activeRecord->enddate;

		// Set startdate
		if ($arrSet['startdate'] == '' || $arrSet['startdate'] < 1)
		{
			$arrSet['startdate'] = mktime(0, 0, 0, date('n', time()), date('j', time()), date('Y', time()));
		}

		// Set enddate
		if (empty($arrSet['enddate']) || $arrSet['enddate'] < 1)
		{
			$arrSet['enddate'] = 0;
		}

		// Check startdate and enddate
		if ($arrSet['startdate'] > $arrSet['enddate'])
		{
			$arrSet['enddate'] = $arrSet['startdate'];
		}

		// Update date
		$this->Database->prepare("UPDATE tl_photoalbums2_album %s WHERE id=?")->set($arrSet)->execute($dc->activeRecord->id);
	}


	/**
	 * Check for modified pa2 feeds and update the XML files if necessary
	 */
	public function generateFeed()
	{
		$session = $this->Session->get('pa2_feed_updater');

		if (!is_array($session) || empty($session))
		{
			return;
		}

		$objPa2 = new \Pa2();

		foreach ($session as $id)
		{
			$objPa2->generateFeed($id);
		}

		$this->Session->set('pa2_feed_updater', null);
	}


	/**
	 * Schedule a pa2 feed update
	 *
	 * This method is triggered when a single pa2 item or multiple pa2
	 * items are modified (edit/editAll), moved (cut/cutAll) or deleted
	 * (delete/deleteAll). Since duplicated items are unpublished by default,
	 * it is not necessary to schedule updates on copyAll as well.
	 */
	public function scheduleUpdate()
	{
		// Return if there is no ID
		if (!CURRENT_ID || $this->Input->get('act') == 'copy')
		{
			return;
		}

		// Store the ID in the session
		$session = $this->Session->get('pa2_feed_updater');
		$session[] = CURRENT_ID;
		$this->Session->set('pa2_feed_updater', array_unique($session));
	}


	/**
	 * generatePalette function.
	 *
	 * @access public
	 * @return void
	 */
	public function generatePalette()
	{
		// Get album
		$objAlbum = \Photoalbums2AlbumModel::findByPk($this->Input->get('id'));

		// Remove from palette
		if ($objAlbum->previewImageType != 'select_preview_image')
		{
			$this->removeFromPalette('tl_photoalbums2_album', 'default', 'previewImage');
		}

		// Remove from palette
		if ($objAlbum->imageSortType != 'custom')
		{
			$this->removeFromPalette('tl_photoalbums2_album', 'default', 'imageSort');
		}
	}
}
