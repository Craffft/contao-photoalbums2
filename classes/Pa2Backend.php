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
 * Namespace
 */
namespace Photoalbums2;

/**
 * Class Pa2Backend 
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 */
class Pa2Backend extends \Backend
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
