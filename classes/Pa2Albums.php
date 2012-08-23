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
 * Class Pa2Albums 
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 */
class Pa2Albums extends \Pa2
{
	public $pa2Type = 'albums';
	
	
	/**
	 * getAlbums function.
	 * 
	 * @access public
	 * @param array $arrArchives
	 * @return array
	 */
	public function getAlbums($arrArchives)
	{
		// Check for array and content
		if (!is_array($arrArchives) || count($arrArchives) < 1)
		{
			return false;
		}
		
		// Set var time
		$time = time();
		
		// Get albums from archives
		$objAlbums = $this->Database->execute("SELECT * FROM tl_photoalbums2_album WHERE pid IN(" . implode(',', array_map('intval', $arrArchives)) . ") AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1 ORDER BY pid, sorting");
		
		// HOOK: pa2GetAlbum callback
		if (is_object($objAlbums) && isset($GLOBALS['TL_HOOKS']['pa2GetAlbums']) && is_array($GLOBALS['TL_HOOKS']['pa2GetAlbums']))
		{
			foreach ($GLOBALS['TL_HOOKS']['pa2GetAlbums'] as $callback)
			{
				$this->import($callback[0]);
				$objAlbums = $this->$callback[0]->$callback[1]($objAlbums, $arrArchives);
			}
		}
		
		return $this->fetchAlbums($objAlbums);
	}
	
	
	/**
	 * parseAlbums function.
	 * 
	 * @access public
	 * @param array $arrAlbums
	 * @return array
	 */
	public function parseAlbums($objTemplate, $arrAlbums)
	{
		// Check
		if(!is_array($arrAlbums) || count($arrAlbums) < 1)
		{
			return false;
		}
		
		// HOOK: pa2BeforeParsingAlbums callback
		if ($objTemplate instanceof FrontendTemplate && isset($GLOBALS['TL_HOOKS']['pa2BeforeParsingAlbums']) && is_array($GLOBALS['TL_HOOKS']['pa2BeforeParsingAlbums']))
		{
			foreach ($GLOBALS['TL_HOOKS']['pa2BeforeParsingAlbums'] as $callback)
			{
				$this->import($callback[0]);
				$arrReturn = $this->$callback[0]->$callback[1]($objTemplate, $arrAlbums, $this->arrVars);
				
				$objTemplate = $arrReturn[0];
				$arrAlbums = $arrReturn[1];
				$this->arrVars = $arrReturn[2];
			}
		}
		
		global $objPage;
		
		$arrElements = array();
		
		// Set Template vars
		$objTemplate->showHeadline = $this->arrVars['pa2ShowHeadline'];
		$objTemplate->showTeaser = $this->arrVars['pa2ShowTeaser'];
		$objTemplate->teaser = $this->cleanRteOutput($this->arrVars['pa2Teaser']);
		
		// Check headline
		if($objTemplate->headline == '')
		{
			$objTemplate->showHeadline = false;
		}
		
		// Check teaser
		if($objTemplate->teaser == '')
		{
			$objTemplate->showTeaser = false;
		}
		
		// Numerical value of all albums
		$total = count($arrAlbums);
		
		foreach($arrAlbums as $i => $album)
		{
			$objSubTemplate = new FrontendTemplate($this->arrVars['strSubtemplate']);
			$objSubTemplate->setData($this->arrVars['arrData']);
			
			// Add totalAll to subtemplate
			$objSubTemplate->totalAll = $objTemplate->totalAll;
			
			// Define perRow
			$objSubTemplate = $this->pa2PerRow($objSubTemplate, $total, $i, $this->arrVars['pa2PerRow']);
			
			// Define date
			$objSubTemplate = $this->pa2BuildDate($objSubTemplate, $album['startdate'], $album['enddate']);
			
			// Define metaFields
			$objSubTemplate = $this->pa2MetaFields($objSubTemplate, $this->arrVars['pa2MetaFields']);
			
			// Define firstOfAll an lastOfAll
			$objSubTemplate = $this->pa2AddSpecificClasses($objSubTemplate, $objTemplate->totalAll, $i, $this->arrVars['pa2PerPage'], $this->pa2Type);
			
			// Add an image
			if ($album['preview_pic']!='' && is_file(TL_ROOT . '/' . $album['preview_pic']))
			{
				$arrImage = array();
				$arrImage['size'] = $this->arrVars['pa2ImageSize'];
				$arrImage['imagemargin'] = $this->arrVars['pa2ImageMargin'];
				$arrImage['singleSRC'] = $album['preview_pic'];
				$arrImage['alt'] = strip_tags($album['title']);

				$this->addImageToTemplate($objSubTemplate, $arrImage);
			}
			
			// Add link title to template
			$objSubTemplate->title = strip_tags($album['title']);
			
			// Add array
			$arrLink = array(
				'id' => $objPage->id,
				'alias' => $objPage->alias
			);
			
			if(!empty($this->arrVars['pa2DetailPage']) && is_numeric($this->arrVars['pa2DetailPage']))
			{
				$objDetailPage = $this->getPageDetails($this->arrVars['pa2DetailPage']);
				
				$arrLink['id'] = $objDetailPage->id;
				$arrLink['alias'] = $objDetailPage->alias;
				$arrLink['language'] = $objDetailPage->language;
			}
			
			$objSubTemplate->title = $album['title'];
			$objSubTemplate->alias = $album['alias'];
			$objSubTemplate->showTitle = $this->arrVars['pa2ShowTitle'];
			$objSubTemplate->event = $album['event'];
			$objSubTemplate->place = $album['place'];
			$objSubTemplate->photographer = $album['photographer'];
			$objSubTemplate->description = $album['description'];
			$objSubTemplate->href = $this->generateFrontendUrl($arrLink, sprintf(($GLOBALS['TL_CONFIG']['useAutoItem'] ?  '/%s' : '/album/%s'), $album['alias']), $objDetailPage->language);
			$objSubTemplate->class .= ($objSubTemplate->class == '') ? $album['cssClass'] : ' ' . $album['cssClass'];
			
			// Check title
			if($objSubTemplate->title == '')
			{
				$objSubTemplate->showTitle = false;
			}
			
			// If album lightbox is activated the photos will be added to the album template
			$objSubTemplate = $this->albumLightbox($objSubTemplate, $album, $this->arrVars['pa2AlbumLightbox']);
			
			// HOOK: pa2ParseAlbum callback
			if ($objSubTemplate instanceof FrontendTemplate && isset($GLOBALS['TL_HOOKS']['pa2ParseAlbum']) && is_array($GLOBALS['TL_HOOKS']['pa2ParseAlbum']))
			{
				foreach ($GLOBALS['TL_HOOKS']['pa2ParseAlbum'] as $callback)
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
		
		// HOOK: pa2ParseAlbums callback
		if ($objTemplate instanceof FrontendTemplate && isset($GLOBALS['TL_HOOKS']['pa2ParseAlbums']) && is_array($GLOBALS['TL_HOOKS']['pa2ParseAlbums']))
		{
			foreach ($GLOBALS['TL_HOOKS']['pa2ParseAlbums'] as $callback)
			{
				$this->import($callback[0]);
				$objTemplate = $this->$callback[0]->$callback[1]($objTemplate, $this);
			}
		}
		
		return $objTemplate;
	}
	
	
	protected function albumLightbox($objTemplate, $album, $pa2AlbumLightbox)
	{
		$objTemplate->albumLightbox = $pa2AlbumLightbox;
		
		if($objTemplate->albumLightbox)
		{
			// Sort pictures
			$arrElements = ($album['pic_sort_check'] == 'pic_sort_wizard') ? $album['pic_sort'] : $this->sortElements($album['pictures'], $album['pic_sort_check']);
			
			$albumLightboxPictures = array();
			$i = 0;
			
			foreach($arrElements as $element)
			{
				if($i == 0)
				{
					$objTemplate->albumID = $album['id'];
					$objTemplate->href = str_replace(' ', '%20', $element);
					$objTemplate->lbvCheck = (version_compare(VERSION.'.'.BUILD, '2.11.0', '>='));
				}
				else
				{
					// Define image template
					$objImageTemplate = new FrontendTemplate('pa2_photo');
									
					// Set vars
					$objImageTemplate->albumID = $album['id'];
					$objImageTemplate->href = str_replace(' ', '%20', $element);
					$objImageTemplate->show = false;
					$objImageTemplate->lbvCheck = (version_compare(VERSION.'.'.BUILD, '2.11.0', '>='));
					
					// Add an image
					if ($element!='' && is_file(TL_ROOT . '/' . $element))
					{
						// Set image array
						$arrImage = array();
						$arrImage['size'] = serialize(array(0, 0, 'crop'));
						$arrImage['imagemargin'] = serialize(array('bottom'=>'', 'left'=>'', 'right'=>'', 'top'=>'', 'unit'=>''));
						$arrImage['singleSRC'] = 'system/modules/photoalbums2/html/blank.gif';
						$arrImage['alt'] = substr(strrchr($element, '/'), 1);
						
						$this->addImageToTemplate($objImageTemplate, $arrImage);
						
						// Add link title to template
						$objImageTemplate->title = substr(strrchr($element, '/'), 1);
					}
					
					// Add image template to parent template
					$albumLightboxPictures[] = $objImageTemplate->parse();
				}
				
				$i++;
			}
			
			$objTemplate->albumLightboxPictures = $albumLightboxPictures;
		}
		
		return $objTemplate;
	}
}
