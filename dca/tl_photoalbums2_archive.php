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
 * @author     Daniel Kiesel 
 * @package    photoalbums2 
 * @license    LGPL 
 * @filesource
 */


/**
 * Table tl_photoalbums2_archive 
 */
$GLOBALS['TL_DCA']['tl_photoalbums2_archive'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'switchToEdit'                => true,
		'ctable'					  => array('tl_photoalbums2_album'),
		'onload_callback' => array
		(
			array('tl_photoalbums2_archive', 'checkPermission'),
			array('tl_photoalbums2_archive', 'generateFeed')
		),
		'onsubmit_callback' => array
		(
			array('tl_photoalbums2_archive', 'scheduleUpdate')
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('title'),
			'panelLayout'             => 'search,limit',
			'flag'                    => 1 
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
				'label'               => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['edit'],
				'href'                => 'table=tl_photoalbums2_album',
				'icon'                => 'edit.gif',
				'attributes'          => 'class="contextmenu"'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
				'button_callback'     => array('tl_photoalbums2_archive', 'deleteArchive')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('allowComments', 'protected', 'makeFeed'),
		'default'                     => '{title_legend},title;{comments_legend:hide},allowComments;{protected_legend},protected;{feed_legend:hide},makeFeed'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'allowComments'               => 'notify,sortOrder,perPage,moderate,bbcode,requireLogin,disableCaptcha',
		'protected'                   => 'users,groups',
		'makeFeed'                    => 'format,language,maxItems,feedBase,alias,modulePage,description'
	),

	// Fields
	'fields' => array
	(
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255)
		),
		'allowComments' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['allowComments'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true)
		),
		'notify' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['notify'],
			'default'                 => 'notify_admin',
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('notify_admin', 'notify_author', 'notify_both'),
			'reference'               => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']
		),
		'sortOrder' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['sortOrder'],
			'default'                 => 'ascending',
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('ascending', 'descending'),
			'reference'               => &$GLOBALS['TL_LANG']['MSC'],
			'eval'                    => array('tl_class'=>'w50')
		),
		'perPage' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['perPage'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50')
		),
		'moderate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['moderate'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50')
		),
		'bbcode' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['bbcode'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50')
		),
		'requireLogin' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['requireLogin'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50')
		),
		'disableCaptcha' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['disableCaptcha'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50')
		),
		'protected' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['protected'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true)
		),
		'users' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['users'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'foreignKey'              => 'tl_member.username',
			'eval'                    => array('multiple'=>true, 'tl_class'=>'w50')
		),
		'groups' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['groups'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'foreignKey'              => 'tl_member_group.name',
			'eval'                    => array('multiple'=>true, 'tl_class'=>'w50')
		),
		'makeFeed' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['makeFeed'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true)
		),
		'format' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['format'],
			'default'                 => 'rss',
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'options'                 => array('rss'=>'RSS 2.0', 'atom'=>'Atom'),
			'eval'                    => array('tl_class'=>'w50')
		),
		'language' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['language'],
			'exclude'                 => true,
			'search'                  => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>32, 'tl_class'=>'w50')
		),
		'maxItems' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['maxItems'],
			'default'                 => 25,
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50,clr')
		),
		'feedBase' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['feedBase'],
			'default'                 => $this->Environment->base,
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('trailingSlash'=>true, 'rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'tl_class'=>'w50')
		),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['alias'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'rgxp'=>'alnum', 'unique'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50,clr'),
			'save_callback' => array
			(
				array('tl_photoalbums2_archive', 'checkFeedAlias')
			)
		),
		'modulePage' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['modulePage'],
			'exclude'                 => true,
			'inputType'               => 'pageTree',
			'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio')
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_photoalbums2_archive']['description'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('style'=>'height:60px;', 'tl_class'=>'clr')
		)
	)
);


/**
 * tl_photoalbums2_archive class.
 * 
 * @extends Backend
 */
class tl_photoalbums2_archive extends Backend
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
	 * Check permissions to edit table tl_photoalbums2_archive
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

		$GLOBALS['TL_DCA']['tl_photoalbums2_archive']['list']['sorting']['root'] = $root;

		// Check permissions to add archives
		if (!$this->User->hasAccess('create', 'photoalbump'))
		{
			$GLOBALS['TL_DCA']['tl_photoalbums2_archive']['config']['closed'] = true;
		}

		// Check current action
		switch ($this->Input->get('act'))
		{
			case 'create':
			case 'select':
				// Allow
				break;

			case 'edit':
				// Dynamically add the record to the user profile
				if (!in_array($this->Input->get('id'), $root))
				{
					$arrNew = $this->Session->get('new_records');

					if (is_array($arrNew['tl_photoalbums2_archive']) && in_array($this->Input->get('id'), $arrNew['tl_photoalbums2_archive']))
					{
						// Add permissions on user level
						if ($this->User->inherit == 'custom' || !$this->User->groups[0])
						{
							$objUser = $this->Database->prepare("SELECT photoalbums, photoalbump FROM tl_user WHERE id=?")
													   ->limit(1)
													   ->execute($this->User->id);

							$arrphotoalbump = deserialize($objUser->photoalbump);

							if (is_array($arrphotoalbump) && in_array('create', $arrphotoalbump))
							{
								$arrPhotoalbums = deserialize($objUser->photoalbums);
								$arrPhotoalbums[] = $this->Input->get('id');

								$this->Database->prepare("UPDATE tl_user SET photoalbums=? WHERE id=?")
											   ->execute(serialize($arrPhotoalbums), $this->User->id);
							}
						}

						// Add permissions on group level
						elseif ($this->User->groups[0] > 0)
						{
							$objGroup = $this->Database->prepare("SELECT photoalbums, photoalbump FROM tl_user_group WHERE id=?")
													   ->limit(1)
													   ->execute($this->User->groups[0]);

							$arrphotoalbump = deserialize($objGroup->photoalbump);

							if (is_array($arrphotoalbump) && in_array('create', $arrphotoalbump))
							{
								$arrPhotoalbums = deserialize($objGroup->photoalbums);
								$arrPhotoalbums[] = $this->Input->get('id');

								$this->Database->prepare("UPDATE tl_user_group SET photoalbums=? WHERE id=?")
											   ->execute(serialize($arrPhotoalbums), $this->User->groups[0]);
							}
						}

						// Add new element to the user object
						$root[] = $this->Input->get('id');
						$this->User->photoalbums = $root;
					}
				}
				// No break;

			case 'copy':
			case 'delete':
			case 'show':
				if (!in_array($this->Input->get('id'), $root) || ($this->Input->get('act') == 'delete' && !$this->User->hasAccess('delete', 'photoalbump')))
				{
					$this->log('Not enough permissions to '.$this->Input->get('act').' photoalbums archive ID "'.$this->Input->get('id').'"', 'tl_photoalbums2_archive checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;

			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
				$session = $this->Session->getData();
				if ($this->Input->get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'photoalbump'))
				{
					$session['CURRENT']['IDS'] = array();
				}
				else
				{
					$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $root);
				}
				$this->Session->setData($session);
				break;

			default:
				if (strlen($this->Input->get('act')))
				{
					$this->log('Not enough permissions to '.$this->Input->get('act').' photoalbums archives', 'tl_photoalbums2_archive checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;
		}
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

		$this->import('Pa2');

		foreach ($session as $id)
		{
			$this->Pa2->generateFeed($id);
		}

		$this->Session->set('pa2_feed_updater', null);
	}


	/**
	 * Schedule a pa2 feed update
	 * 
	 * This method is triggered when a single pa2 archive or multiple pa2
	 * archives are modified (edit/editAll).
	 * @param DataContainer
	 */
	public function scheduleUpdate(DataContainer $dc)
	{
		// Return if there is no ID 
		if (!$dc->id)
		{
			return;
		}

		// Store the ID in the session
		$session = $this->Session->get('pa2_feed_updater');
		$session[] = $dc->id;
		$this->Session->set('pa2_feed_updater', array_unique($session));
	}


	/**
	 * Check the RSS-feed alias
	 * @param mixed
	 * @param DataContainer
	 * @return mixed
	 * @throws Exception
	 */
	public function checkFeedAlias($varValue, DataContainer $dc)
	{
		// No change or empty value
		if ($varValue == $dc->value || $varValue == '')
		{
			return $varValue;
		}

		$arrFeeds = $this->removeOldFeeds(true);

		// Alias exists
		if (array_search($varValue, $arrFeeds) !== false)
		{
			throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
		}

		return $varValue;
	}


	/**
	 * Return the delete archive button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function deleteArchive($row, $href, $label, $title, $icon, $attributes)
	{
		return ($this->User->isAdmin || $this->User->hasAccess('delete', 'photoalbump')) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ' : $this->generateImage(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}
}

?>