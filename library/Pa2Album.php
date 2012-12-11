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
 * Class Pa2Album 
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 */
class Pa2Album extends \Pa2Lib
{
	/**
	 * sortOut function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function sortOut()
	{
		if (count($this->arrItems) > 0)
		{
			$this->import('FrontendUser', 'User');
			
			$objItems = \Photoalbums2AlbumModel::findMultipleByIds($this->arrItems);
			
			$arrItems = array();
	
			while ($objItems->next())
			{
				// If album is published
				if ($objItems->published == 1)
				{
					if ($objItems->protected)
					{
						if (!FE_USER_LOGGED_IN)
						{
							continue;
						}
						
						$arrUsers = deserialize($objItems->users);
						$arrGroups = deserialize($objItems->groups);
						
						// Check users and groups
						if ((!is_array($arrUsers) || count($arrUsers) < 1 || count(array_intersect($arrUsers, array($this->User->id))) < 1) && (!is_array($arrGroups) || count($arrGroups) < 1 || count(array_intersect($arrGroups, $this->User->groups)) < 1))
						{
							continue;
						}
					}
					
					// Timefilter
					if ($this->arrData['pa2TimeFilter'])
					{
						$objTimeFilter = new Pa2TimeFilter($this->arrData['pa2TimeFilterStart'], $this->arrData['pa2TimeFilterEnd']);
						
						if($objTimeFilter->doFilter($objItems->startdate, $objItems->enddate))
						{
							continue;
						}
					}
					
					$arrItems[] = $objItems->id;
				}
			}
			
			$this->arrItems = $arrItems;
		}
	}
	
	
	/**
	 * getIdByAlias function.
	 * 
	 * @access protected
	 * @param string $strAlias
	 * @return string
	 */
	protected function getIdByAlias($strAlias)
	{
		$objPhotoalbums2AlbumModel = \Photoalbums2AlbumModel::findPublishedByIdOrAlias($strAlias);
		
		if($objPhotoalbums2AlbumModel !== null)
		{
			if(is_numeric($objPhotoalbums2AlbumModel->id))
			{
				return $objPhotoalbums2AlbumModel->id;
			}
		}
		
		return $strAlias;
	}
	
	
	/**
	 * getAlbumIds function.
	 * 
	 * @access public
	 * @return array
	 */
	public function getAlbumIds()
	{
		return $this->arrItems;
	}
	
	
	/**
	 * getAlbums function.
	 * 
	 * @access public
	 * @return object
	 */
	public function getAlbums()
	{
		if(count($this->arrItems) > 0)
		{
			$objAlbum = \Photoalbums2AlbumModel::findMultipleByIds($this->arrItems);
			
			if($objAlbum !== null)
			{
				while($objAlbum->next())
				{
					// Get preview pic as Pa2Picture object
					$objPicture = new \Pa2Picture($objAlbum->preview_pic);
					$objAlbum->objPreviewPic = $objPicture->getPicture();
					
					// Deserialize arrays
					$objAlbum->pictures = deserialize($objAlbum->pictures);
					$objAlbum->pic_sort = deserialize($objAlbum->pic_sort);
					
					// Set sortedPicIds
					$objPa2PicSorter = new \Pa2PicSorter($objAlbum->pic_sort_check, $objAlbum->pictures, $objAlbum->pic_sort);
					$objAlbum->arrSortedPicIds = $objPa2PicSorter->getSortedIds();
				}
				
				$objAlbum->reset();
			}
			
			return $objAlbum;
		}
		
		return null;
	}
}
