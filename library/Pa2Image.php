<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
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
 * Class Pa2Image
 *
 * @copyright  Daniel Kiesel 2012-2013
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class Pa2Image extends \Controller
{
	/**
	 * arrItems
	 *
	 * (default value: array())
	 *
	 * @var array
	 * @access protected
	 */
	protected $intId = 0;


	/**
	 * __construct function.
	 *
	 * @access public
	 * @param array or id $arrItems
	 * @return void
	 */
	public function __construct($intId)
	{
		if (!is_numeric($intId) || $intId < 1)
		{
			return;
		}

		$this->intId = $intId;
	}


	public function getPa2Image()
	{
		$objFile = \FilesModel::findByPk($this->intId);

		if ($objFile !== null)
		{
			return $objFile;
		}
	}


	public function addPa2ImageToTemplate($objTemplate, $arrMergeData = array())
	{
		if (isset($this->intId) && is_array($arrMergeData))
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
