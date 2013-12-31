<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2014 Leo Feyer
 *
 * @package    photoalbums2
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @license    LGPL
 * @copyright  Daniel Kiesel 2012-2014
 */


/**
 * Namespace
 */
namespace Photoalbums2;


/**
 * Class Pa2Image
 *
 * @copyright  Daniel Kiesel 2012-2014
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class Pa2Image extends \Controller
{

	/**
	 * uuid
	 *
	 * (default value: 0)
	 *
	 * @var int
	 * @access protected
	 */
	protected $uuid = 0;


	/**
	 * __construct function.
	 *
	 * @access public
	 * @param string
	 * @return void
	 */
	public function __construct($uuid)
	{
		if (!\Validator::isUuid($uuid))
		{
			return;
		}

		$this->uuid = $uuid;
	}


	/**
	 * getPa2Image function.
	 *
	 * @access public
	 * @return object
	 */
	public function getPa2Image()
	{
		$objFile = \FilesModel::findByUuid($this->uuid);

		if ($objFile !== null)
		{
			// Deserialize meta data
			$objFile->meta = deserialize($objFile->meta);

			return $objFile;
		}
	}


	/**
	 * addPa2ImageToTemplate function.
	 *
	 * @access public
	 * @param object $objTemplate
	 * @param array $arrMergeData (default: array())
	 * @return object
	 */
	public function addPa2ImageToTemplate($objTemplate, $arrMergeData = array())
	{
		if (isset($this->uuid) && is_array($arrMergeData))
		{
			$objFile = $this->getPa2Image();

			if ($objFile !== null && is_file(TL_ROOT . '/' . $objFile->path))
			{
				$arrData = $objTemplate->getData();
				$arrData['singleSRC'] = $objFile->path;

				if (count($arrMergeData) > 0)
				{
					$arrData = array_merge($arrData, $arrMergeData);
				}

				$this->addImageToTemplate($objTemplate, $arrData);
			}
		}

		return $objTemplate;
	}
}
