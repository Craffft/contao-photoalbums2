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
 * Class Pa2PhotoViewParser
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 */
class Pa2PhotoViewParser extends \Pa2ViewParser
{
	/**
	 * generate function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function generate()
	{
		$this->strEmptyText = $GLOBALS['TL_LANG']['MSC']['photosEmpty'];
		
		parent::generate();
	}
	
	
	/**
	 * compile function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function compile()
	{
		
	}
}
