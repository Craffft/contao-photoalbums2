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
 * Class Pa2Picture 
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 */
class Pa2Picture extends \Controller
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
		if(!is_numeric($intId) || $intId < 1)
		{
			return;
		}
		
		$this->intId = $intId;
	}
	
	
	public function getPicture()
	{
		$objFile = \FilesModel::findByPk($this->intId);
		
		if($objFile !== null)
		{
			return $objFile;
		}
	}
	
	
	public function addPictureToTemplate($objTemplate)
	{
		if (isset($this->intId))
		{
			$objFile = $this->getPicture();
			
			if ($objFile !== null && is_file(TL_ROOT . '/' . $objFile->path))
			{
				$arrData = $objTemplate->getData();
				$arrData['singleSRC'] = $objFile->path;
				
				$this->addImageToTemplate($objTemplate, $arrData);
			}
		}
		
		return $objTemplate;
	}
}
