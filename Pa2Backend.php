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
 * Class Pa2Backend
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel 
 * @package    Backend
 */
class Pa2Backend extends Backend
{
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
}

?>