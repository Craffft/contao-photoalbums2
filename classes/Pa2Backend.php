<?php

/**
 * Extension for Contao Open Source CMS
 *
 * Copyright (c) 2012-2014 Daniel Kiesel
 *
 * @package Photoalbums2
 * @link    https://github.com/icodr8/contao-photoalbums
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Namespace
 */
namespace Photoalbums2;


/**
 * Class Pa2Backend
 *
 * @copyright  Daniel Kiesel 2012-2014
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class Pa2Backend extends \Backend
{

	/**
	 * checkTimeFilter function.
	 *
	 * @access public
	 * @param $dc
	 * @return void
	 */
	public function checkTimeFilter($dc)
	{
		// Return if there is no active record (override all)
		if (!$dc->activeRecord)
		{
			return;
		}

		// Get Object
		$objModule = \ModuleModel::findByPk($dc->activeRecord->id);

		if ($objModule === null)
		{
			return;
		}

		// Set arrSet
		$objModule->pa2TimeFilterStart = deserialize($dc->activeRecord->pa2TimeFilterStart);
		$objModule->pa2TimeFilterEnd = deserialize($dc->activeRecord->pa2TimeFilterEnd);

		if ($dc->activeRecord->pa2TimeFilter == 1)
		{
			// Set pa2TimeFilterStart
			if ($objModule->pa2TimeFilterStart['value'] == '' || $objModule->pa2TimeFilterStart['value'] < 0)
			{
				$objModule->pa2TimeFilterStart['value'] = '0';
			}

			// Set pa2TimeFilterEnd
			if ($objModule->pa2TimeFilterEnd['value'] == '' || $objModule->pa2TimeFilterEnd['value'] < 0)
			{
				$objModule->pa2TimeFilterEnd['value'] = '0';
			}

			// Get TimeFilter object
			$objPa2TimeFilter = new Pa2TimeFilter($objModule->pa2TimeFilterStart, $objModule->pa2TimeFilterEnd);

			// Check startdate and enddate
			if ($objPa2TimeFilter->getFilterStart() > $objPa2TimeFilter->getFilterEnd())
			{
				$objModule->pa2TimeFilterEnd = $objModule->pa2TimeFilterStart;
			}

			// Serialize
			$objModule->pa2TimeFilterStart = serialize($objModule->pa2TimeFilterStart);
			$objModule->pa2TimeFilterEnd = serialize($objModule->pa2TimeFilterEnd);

			// Update date
			$db = \Database::getInstance();
			$stmt = $db->prepare("UPDATE tl_module SET pa2TimeFilterStart=?, pa2TimeFilterEnd=? WHERE id=?");
			$res = $stmt->execute($objModule->pa2TimeFilterStart, $objModule->pa2TimeFilterEnd, $objModule->id);
		}
	}


	/**
	 * getPa2WrapTemplates function.
	 *
	 * @access public
	 * @param DataContainer $dc
	 * @return array
	 */
	public function getPa2WrapTemplates(\DataContainer $dc)
	{
		$intPid = $dc->activeRecord->pid;

		if ($this->Input->get('act') == 'overrideAll')
		{
			$intPid = $this->Input->get('id');
		}

		return $this->getTemplateGroup('pa2_wrap', $intPid);
	}


	/**
	 * getPa2AlbumTemplates function.
	 *
	 * @access public
	 * @param DataContainer $dc
	 * @return array
	 */
	public function getPa2AlbumTemplates(\DataContainer $dc)
	{
		$intPid = $dc->activeRecord->pid;

		if ($this->Input->get('act') == 'overrideAll')
		{
			$intPid = $this->Input->get('id');
		}

		return $this->getTemplateGroup('pa2_album', $intPid);
	}


	/**
	 * getPa2ImageTemplates function.
	 *
	 * @access public
	 * @param DataContainer $dc
	 * @return array
	 */
	public function getPa2ImageTemplates(\DataContainer $dc)
	{
		$intPid = $dc->activeRecord->pid;

		if ($this->Input->get('act') == 'overrideAll')
		{
			$intPid = $this->Input->get('id');
		}

		return $this->getTemplateGroup('pa2_image', $intPid);
	}


	/**
	 * removeFromPalette function.
	 *
	 * @access protected
	 * @param string $table
	 * @param string $palette
	 * @param string $value
	 * @return void
	 */
	protected function removeFromPalette($table, $palette, $value)
	{
		$GLOBALS['TL_DCA'][$table]['palettes'][$palette] = preg_replace('#[,]{1}(' . $value . ')([,;]{1})#', '$2', $GLOBALS['TL_DCA'][$table]['palettes'][$palette]);
	}
}
