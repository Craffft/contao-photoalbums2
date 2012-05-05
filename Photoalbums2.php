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
 * Class Photoalbums2
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel 
 * @package    Controller
 */
class Photoalbums2 extends Frontend
{
	/**
	 * getTimeFilterData function.
	 * 
	 * @access public
	 * @param array $arrData
	 * @return int
	 */
	public function getTimeFilterData($arrData, $typeEnd = false)
	{
		// If use vars are not setted
		if (!isset($arrData['unit']) || !isset($arrData['value']))
		{
			return false;
		}
		
		$intValue = false;
		
		// Get date vars
		$day = date('j', time());
		$month = date('n', time());
		$year = date('Y', time());
		
		switch ($arrData['unit'])
		{
			case 'days':
				$intValue = mktime(0, 0, 0, $month, $day+($typeEnd ? 1 : 0)-$arrData['value'], $year);
			break;
			
			case 'weeks':
				$intValue = mktime(0, 0, 0, $month, $day+($typeEnd ? 7 : 0)-($arrData['value']*7)-(date('N', time())-1), $year);
			break;
			
			case 'months':
				$intValue = mktime(0, 0, 0, $month+($typeEnd ? 1 : 0)-$arrData['value'], 1, $year);
			break;
			
			case 'years':
				$intValue = mktime(0, 0, 0, 1, 1, $year+($typeEnd ? 1 : 0)-$arrData['value']);
			break;
		}
		
		return $intValue;
	}
}

?>