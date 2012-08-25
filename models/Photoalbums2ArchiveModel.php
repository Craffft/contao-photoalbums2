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
 * Class Photoalbums2ArchiveModel 
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 */
class Photoalbums2ArchiveModel extends \Model
{

	/**
	 * Name of the table
	 * @var string
	 */
	protected static $strTable = 'tl_photoalbums2_archive';
	
	
	public static function findMultipleByIds($arrIds)
	{
		if(!is_array($arrIds) || empty($arrIds))
		{
			return null;
		}
		
		$arrIds = implode(',', array_map('intval', $arrIds));
		
		$t = static::$strTable;
		$db = \Database::getInstance();
		
		return static::findBy
		(
			array("$t.id IN(" . $arrIds . ")"),
			null,
			array('order'=>$db->findInSet("$t.id", $arrIds))
		);
	}

}
