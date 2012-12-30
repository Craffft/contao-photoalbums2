<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @package   photoalbums2
 * @author    Daniel Kiesel <https://github.com/icodr8>
 * @license   LGPL
 * @copyright Daniel Kiesel 2012-2013
 */


/**
 * Namespace
 */
namespace Photoalbums2;

/**
 * Class Pa2Backend
 *
 * @copyright  Daniel Kiesel 2012-2013
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
}
