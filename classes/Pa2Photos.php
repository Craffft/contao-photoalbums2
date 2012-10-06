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
 * Class Pa2Photos 
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 */
class Pa2Photos extends \Pa2
{
	public $type = 'photos';
	
	
	/**
	 * getAlbum function.
	 * 
	 * @access public
	 * @param string $alias
	 * @return int
	 */
	public function getAlbum($val)
	{
		$time = time();
		
		// Set id and alias
		$id = '';
		$alias = '';
		
		// Check value
		if(is_numeric($val))
		{
			$id = $val;
		}
		else
		{
			$alias = $val;
		}
		
		
		// Get album by id or alias
		$objAlbums = \Photoalbums2AlbumModel::findPublishedByIdOrAlias($val);
		
		// HOOK: pa2GetAlbum callback
		if (is_object($objAlbums) && isset($GLOBALS['TL_HOOKS']['pa2GetAlbum']) && is_array($GLOBALS['TL_HOOKS']['pa2GetAlbum']))
		{
			foreach ($GLOBALS['TL_HOOKS']['pa2GetAlbum'] as $callback)
			{
				$this->import($callback[0]);
				$objAlbums = $this->$callback[0]->$callback[1]($objAlbums);
			}
		}
		
		return $this->fetchAlbums($objAlbums);
	}
	
	
	/**
	 * parsePhotos function.
	 * 
	 * @access public
	 * @param array $arrAlbum
	 * @param array $arrPaginationPhotos
	 * @return array
	 */
	public function parsePhotos($objTemplate, $arrAlbum, $arrPaginationPhotos)
	{
		// Check
		if(!is_array($arrAlbum) || count($arrAlbum) < 1 || !is_array($arrPaginationPhotos) || count($arrPaginationPhotos) < 1)
		{
			if(TL_MODE == 'BE')
			{
				return $objTemplate;
			}
			
			return false;
		}
		
		// HOOK: pa2BeforeParsingPhotos callback
		if ($objTemplate instanceof FrontendTemplate && isset($GLOBALS['TL_HOOKS']['pa2BeforeParsingPhotos']) && is_array($GLOBALS['TL_HOOKS']['pa2BeforeParsingPhotos']))
		{
			foreach ($GLOBALS['TL_HOOKS']['pa2BeforeParsingPhotos'] as $callback)
			{
				$this->import($callback[0]);
				$arrReturn = $this->$callback[0]->$callback[1]($objTemplate, $arrAlbum, $arrPaginationPhotos, $this->arrVars);
				
				$objTemplate = $arrReturn[0];
				$arrAlbum = $arrReturn[1];
				$arrPaginationPhotos = $arrReturn[2];
				$this->arrVars = $arrReturn[3];
			}
		}
		
		global $objPage;
		
		$arrElements = array();
		
		$objTemplate->title = $arrAlbum['title'];
		$objTemplate->alias = $arrAlbum['alias'];
		$objTemplate->showHeadline = $this->arrVars['pa2ShowHeadline'];
		$objTemplate->showTitle = $this->arrVars['pa2ShowTitle'];
		$objTemplate->showTeaser = $this->arrVars['pa2ShowTeaser'];
		$objTemplate->teaser = $this->cleanRteOutput($this->arrVars['pa2Teaser']);
		$objTemplate->cssClass .= ($objTemplate->cssClass == '') ? $arrAlbum['cssClass'] : ' ' . $arrAlbum['cssClass'];
		
		// Check headline
		if($objTemplate->headline == '')
		{
			$objTemplate->showHeadline = false;
		}
		
		// Check title
		if($objTemplate->title == '')
		{
			$objTemplate->showTitle = false;
		}
		
		// Check teaser
		if($objTemplate->teaser == '')
		{
			$objTemplate->showTeaser = false;
		}
		
		// Define date
		$objTemplate = $this->pa2BuildDate($objTemplate, $arrAlbum['startdate'], $arrAlbum['enddate']);
		
		// Define metaFields
		$objTemplate = $this->pa2MetaFields($objTemplate, $this->arrVars['pa2MetaFields']);
		$objTemplate->event = $arrAlbum['event'];
		$objTemplate->place = $arrAlbum['place'];
		$objTemplate->photographer = $arrAlbum['photographer'];
		$objTemplate->description = $arrAlbum['description'];
		
		// Get only pictures as array
		$objPa2PicSorter = new \Pa2PicSorter($arrAlbum['pic_sort_check'], $arrAlbum['pictures'], $arrAlbum['pic_sort']);
		$arrPictures = $objPa2PicSorter->getSortedIds();
		
		// Check arrElements
		if(!is_array($arrPictures) || count($arrPictures) < 1)
		{
			return false;
		}
		
		// Define pagination helper vars
		$pagiantionCount = 0;
		$paginationTotal = count($arrPaginationPhotos);
		
		foreach($arrPictures as $i => $element)
		{
			$objFile = \FilesModel::findByPk($element);
			
			$objSubTemplate = new \FrontendTemplate($this->arrVars['strSubtemplate']);
			$objSubTemplate->setData($this->arrVars['arrData']);
			
			// Add totalItems to subtemplate
			$objSubTemplate->totalItems = $objTemplate->totalItems;
			
			// Define show
			$objSubTemplate->show = false;
			
			// Check Version
			$objSubTemplate->lbvCheck = (version_compare(VERSION.'.'.BUILD, '2.11.0', '>='));
			
			// Define image array
			$arrImage = array();
			
			// If show element
			if (in_array($element, $arrPaginationPhotos))
			{
				// Define perRow
				$objSubTemplate = $this->pa2PerRow($objSubTemplate, $paginationTotal, $pagiantionCount, $this->arrVars['pa2PerRow']);
				
				// Define firstOfAll an lastOfAll
				$objSubTemplate = $this->pa2AddSpecificClasses($objSubTemplate, $objTemplate->totalItems, $i, $this->arrVars['intItemsPerPage'], $this->type);
				
				// Define show
				$objSubTemplate->show = true;
				
				// Set image
			    $arrImage['size'] = $this->arrVars['pa2ImageSize'];
			    $arrImage['imagemargin'] = $this->arrVars['pa2ImageMargin'];
			    $arrImage['singleSRC'] = $objFile->path;
				
				$pagiantionCount++;
			}
			else
			{
				//Set image
				$arrImage['size'] = serialize(array(0, 0, 'crop'));
				$arrImage['imagemargin'] = serialize(array('bottom'=>'', 'left'=>'', 'right'=>'', 'top'=>'', 'unit'=>''));
			    $arrImage['singleSRC'] = 'system/modules/photoalbums2/html/blank.gif';
			}
			
			// Set element ID
			$objSubTemplate->elementID = $i;
			
			// Set album ID
			$objSubTemplate->albumID = $this->arrVars['id'];
			
			// Set href
			$objSubTemplate->href = str_replace(' ', '%20', $objFile->path);
			
			// Add an image
			if ($objFile->path != '' && is_file(TL_ROOT . '/' . $objFile->path))
			{
			    // Add alt tag
			    $arrImage['alt'] = $objFile->name;
			    
			    $this->addImageToTemplate($objSubTemplate, $arrImage);
			    
			    // Add link title to template
				$objSubTemplate->title = $objFile->name;
			}
			
			// HOOK: pa2ParsePhoto callback
			if ($objSubTemplate instanceof FrontendTemplate && isset($GLOBALS['TL_HOOKS']['pa2ParsePhoto']) && is_array($GLOBALS['TL_HOOKS']['pa2ParsePhoto']))
			{
				foreach ($GLOBALS['TL_HOOKS']['pa2ParsePhoto'] as $callback)
				{
					$this->import($callback[0]);
					$objSubTemplate = $this->$callback[0]->$callback[1]($objSubTemplate, $this, $i);
				}
			}
			
			// Parse template
			$arrElements[] = $objSubTemplate->parse();
		}
		
		// Add items to template
		$objTemplate->items = $arrElements;
		
		// HOOK: pa2ParsePhotos callback
		if ($objTemplate instanceof FrontendTemplate && isset($GLOBALS['TL_HOOKS']['pa2ParsePhotos']) && is_array($GLOBALS['TL_HOOKS']['pa2ParsePhotos']))
		{
			foreach ($GLOBALS['TL_HOOKS']['pa2ParsePhotos'] as $callback)
			{
				$this->import($callback[0]);
				$objTemplate = $this->$callback[0]->$callback[1]($objTemplate, $this);
			}
		}
		
		return $objTemplate;
	}
}
