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
 * Class Pa2ViewParser
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 */
abstract class Pa2ViewParser extends \Frontend
{
	/**
	 * Template
	 * 
	 * @var mixed
	 * @access protected
	 */
	protected $Template;
	
	
	/**
	 * strEmptyText
	 * 
	 * (default value: '')
	 * 
	 * @var string
	 * @access protected
	 */
	protected $strEmptyText = '';
	
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param object $objTemplate
	 * @return void
	 */
	public function __construct($objTemplate)
	{
		if(!is_object($objTemplate) || !$objTemplate instanceof \Template)
		{
			return false;
		}
		
		$this->Template = $objTemplate;
		
		$this->generate();
		$this->compile();
	}
	
	
	/**
	 * generate function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function generate()
	{
		// Do nothing
	}
	
	
	/**
	 * compile function.
	 * 
	 * @access protected
	 * @abstract
	 * @return void
	 */
	abstract protected function compile();
	
	
	/**
	 * setEmptyTemplate function.
	 * 
	 * @access protected
	 * @param array $arrItems (default: array())
	 * @return void
	 */
	protected function setEmptyTemplate($arrItems = array())
	{
		// If required set empty template
		$objPa2Empty = new \Pa2Empty($arrItems, $this->strEmptyText);
		
		if($objPa2Empty->run() !== null)
		{
			$this->Template = $objPa2Empty->run();
		}
	}
	
	
	/**
	 * cleanRteOutput function.
	 * 
	 * @access public
	 * @param string $text
	 * @return string
	 */
	public function cleanRteOutput($text)
	{
		global $objPage;
		$this->import('String');
		
		// Clean the RTE output
		if ($objPage->outputFormat == 'xhtml')
		{
			$text = $this->String->toXhtml($text);
		}
		else
		{
			$text = $this->String->toHtml5($text);
		}

		$text = $this->String->encodeEmail($text);
		
		return $text;
	}
	
	
	/**
	 * addClassesAndStyles function.
	 * 
	 * @access protected
	 * @param object $objTemplate
	 * @param int $total
	 * @param int $i
	 * @return object
	 */
	protected function addClassesAndStyles($objTemplate, $total, $i)
	{
		// Check
		if(!is_object($objTemplate))
		{
			return false;
		}
		
		// Get modulo
		$m = ($i % $objTemplate->intItemsPerRow);
		
		// Set width from objects
		$objTemplate->style = (($objTemplate->style == '') ? '' : ($objTemplate->style) . ' ') . 'width: ' . (100 / $objTemplate->intItemsPerRow) . '%;';
		
		// Set row start
		$objTemplate->rowStart = false;
		if($m == 0)
		{
		    $objTemplate->class .= ' first';
		    $objTemplate->rowStart = true;
		}
		
		// Set row end
		$objTemplate->rowEnd = false;
		if($m == ($objTemplate->intItemsPerRow - 1) || $total == ($i+1))
		{
		    $objTemplate->class .= ' last';
		    $objTemplate->rowEnd = true;
		}
		
		// Set even and odd in photos
		$objTemplate->class .= ' ' . ((($i % 2) == 0) ? 'even' : 'odd');
		
		// Set even and odd in rows
		if($m == 0)
		{
			if(!isset($GLOBALS['pa2RowEvenOdd']))
			{
				$GLOBALS['pa2RowEvenOdd'] = 0;
			}
			
			$objTemplate->rowClass = ((($GLOBALS['pa2RowEvenOdd'] % 2) == 0) ? 'even' : 'odd');
			
			$GLOBALS['pa2RowEvenOdd']++;
		}
		
		return $objTemplate;
	}
	
	
	/**
	 * buildDate function.
	 * 
	 * @access protected
	 * @param object $objTemplate
	 * @param int $intStartdate
	 * @param int $intEnddate
	 * @return object
	 */
	protected function buildDate($objTemplate, $intStartdate, $intEnddate)
	{
		global $objPage;
		
		// Check
		if(!is_object($objTemplate))
		{
			return false;
		}
		
		$startdate = (!empty($intStartdate) && $intStartdate > 0) ? $this->parseDate($objPage->dateFormat, $intStartdate) : false;
		$enddate = (!empty($intEnddate) && $intEnddate > 0) ? $this->parseDate($objPage->dateFormat, $intEnddate) : false;
		
		if ($startdate == $enddate)
		{
		    $objTemplate->date = $startdate;
		}
		else
		{
		    $objTemplate->date = $startdate . ' - ' . $enddate;
		}
		
		return $objTemplate;
	}
	
	
	protected function addSpecificClasses($objTemplate, $i, $type)
	{
		// Do if vars are empty
		if(!is_object($objTemplate) || !is_numeric($objTemplate->totalItems) || !is_numeric($objTemplate->intItemsPerPage) || !is_numeric($i))
		{
			return $objTemplate;
		}
		
		// Define vars
		$totalItems       = $objTemplate->totalItems;
		$intItemsPerPage  = $objTemplate->intItemsPerPage;
		
		// Fix division by zero problem
		if($intItemsPerPage < 1)
		{
			$intItemsPerPage = $totalItems;
		}
		
		// Set var maxPage
		$maxPage = (int) ceil($totalItems/$intItemsPerPage);
		
		// Set var page
		$page = $this->Input->get('page');
		$page = (is_numeric($page)) ? $page : 1;
		$page = ($maxPage > $page) ? $page : $maxPage;
		
		// Set picNum var
		if($type == 'overview')
		{
			$picNum = $i+1+(($page-1)*$intItemsPerPage);
		}
		else if($type == 'detail')
		{
			$picNum = $i+1;
		}
		else
		{
			return $objTemplate;
		}
		
		// Set firstPageNum
		$firstPageNum = (($page-1)*$intItemsPerPage) + 1;
		$firstPageNum = ($totalItems > $firstPageNum) ? $firstPageNum : $totalItems;
		
		// Set lastPageNum
		$lastPageNum = ($page*$intItemsPerPage);
		$lastPageNum = ($totalItems > $lastPageNum) ? $lastPageNum : $totalItems;
		
		// Set firstOfAll class
		if($picNum == '1')
		{
			$objTemplate->class .= ($objTemplate->class == '') ? 'firstOfAll' : ' firstOfAll';
		}
		
		// Set lastOfAll class
		if($picNum == $totalItems)
		{
			$objTemplate->class .= ($objTemplate->class == '') ? 'lastOfAll' : ' lastOfAll';
		}
		
		$objTemplate->class .= ($objTemplate->class == '') ? 'picnum_' . $picNum : ' picnum_' . $picNum;
		
		// Set vars in template
		$objTemplate->picNum = $picNum;
		$objTemplate->firstPageNum = $firstPageNum;
		$objTemplate->lastPageNum = $lastPageNum;
		
		return $objTemplate;
	}
}
