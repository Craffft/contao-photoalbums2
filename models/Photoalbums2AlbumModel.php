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
 * Class Photoalbums2AlbumModel
 *
 * @copyright  Daniel Kiesel 2012-2014
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
			array("$t.pid IN(" . $arrIds . ") AND ($t.start='' OR $t.start<'$time') AND ($t.stop='' OR $t.stop>'$time') AND $t.published='1'"),
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
			'column' => array("($t.id=? OR $t.alias=?) AND ($t.start='' OR $t.start<$time) AND ($t.stop='' OR $t.stop>$time) AND $t.published=1"),
			'value'  => array((is_numeric($value) ? $value : 0), $value),
			'return' => 'Collection'
		);

		return static::find($arrOptions);
	}

}
