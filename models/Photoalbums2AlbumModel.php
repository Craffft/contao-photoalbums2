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
 * Class Photoalbums2AlbumModel
 *
 * @copyright  Daniel Kiesel 2012
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class Photoalbums2AlbumModel extends \Model
{

	/**
	 * Name of the table
	 * @var string
	 */
	protected static $strTable = 'tl_photoalbums2_album';


	public static function findMultipleByIds($arrIds)
	{
		if (!is_array($arrIds) || empty($arrIds))
		{
			return null;
		}

		$t = static::$strTable;
		return static::findBy(array("$t.id IN(" . implode(',', array_map('intval', $arrIds)) . ")"), null, array('order'=>\Database::getInstance()->findInSet("$t.id", $arrIds)));
	}


	public static function findAlbumsByMultipleArchives($arrIds)
	{
		if (!is_array($arrIds) || empty($arrIds))
		{
			return null;
		}

		$arrIds = implode(',', array_map('intval', $arrIds));

		$time = time();
		$t = static::$strTable;
		$db = \Database::getInstance();

		return static::findBy
		(
			array("$t.pid IN(" . $arrIds . ") AND (start='' OR start<'$time') AND (stop='' OR stop>'$time') AND published='1'"),
			null,
			array('order'=>"$t.pid, $t.sorting")
		);
	}


	public static function findPublishedByIdOrAlias($value)
	{
		$t = static::$strTable;
		$time = time();

		$arrOptions = array
		(
			'limit'  => 1,
			'column' => array("($t.id=? OR $t.alias=?) AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1"),
			'value'  => array((is_numeric($value) ? $value : 0), $value),
			'return' => 'Collection'
		);

		return static::find($arrOptions);
	}

}
