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
 * Class Pa2New 
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 */
class Pa2New extends \Controller
{
	/**
	 * addCssFile function.
	 * 
	 * @access public
	 * @return void
	 */
	public function addCssFile()
	{
		global $objPage;
		
		// Get layout skipPhotoalbums2 to disable photoalbums css file
		$objLayout = \LayoutModel::findByPk($objPage->layout);
		
		// Add css
		if (TL_MODE=='FE' && $objLayout->skipPhotoalbums2 != '1')
		{
			$GLOBALS['TL_CSS'][] = TL_FILES_URL . 'system/modules/photoalbums2/html/photoalbums2.css';
		}
		
		// Add css
		if (TL_MODE=='BE')
		{
			$GLOBALS['TL_CSS'][] = TL_FILES_URL . 'system/modules/photoalbums2/html/photoalbums2.css';
			$GLOBALS['TL_CSS'][] = TL_FILES_URL . 'system/modules/photoalbums2/html/photoalbums2_be.css';
		}
	}
}
