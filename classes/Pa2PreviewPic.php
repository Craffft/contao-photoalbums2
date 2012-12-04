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
 * Class Pa2PreviewPic 
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel <https://github.com/icodr8> 
 * @package    photoalbums2
 */
class Pa2PreviewPic extends \Controller
{
	/**
	 * intId
	 * 
	 * @var int
	 * @access private
	 */
	private $intId;
	
	
	/**
	 * objAlbum
	 * 
	 * @var object
	 * @access private
	 */
	private $objAlbum;
	
	
	/**
	 * objPreviewPic
	 * 
	 * @var object
	 * @access private
	 */
	private $objPreviewPic;
	
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param object $objAlbum
	 * @param string $type
	 * @return void
	 */
	public function __construct($objAlbum, $type)
	{
		if(is_numeric($objAlbum))
		{
			$objAlbum = \Photoalbums2AlbumModel::findByPk($objAlbum);
		}
		
		if(!is_object($objAlbum))
		{
			return false;
		}
		
		$this->objAlbum = $objAlbum;
		$this->type = $type;
		
		$this->getPreviewPic();
	}
	
	
	/**
	 * getPreviewPic function.
	 * 
	 * @access private
	 * @return void
	 */
	private function getPreviewPic()
	{
		if(is_object($this->objPreviewPic))
		{
			return $this->objPreviewPic;
		}
		
		$this->intId = null;
		
		switch($this->type)
		{
			case 'use_album_options':
				switch($this->objAlbum->preview_pic_check)
				{
					case 'no_preview_pic':
						$this->intId = null;
					break;
					
					case 'random_preview_pic':
						$this->intId = $this->getRandomPreviewPic();
					break;
					
					case 'select_preview_pic':
						$this->intId = $this->objAlbum->preview_pic;
					break;
				}
			break;
			
			case 'no_preview_pics':
				$this->intId = null;
			break;
			
			case 'random_pics':
				$this->intId = $this->getRandomPreviewPic();
			break;
			
			case 'random_pics_at_no_preview_pics':
				if($this->objAlbum->preview_pic_check == 'select_preview_pic')
				{
					$this->intId = $this->objAlbum->preview_pic;
				}
				else
				{
					$this->intId = $this->getRandomPreviewPic();
				}
			break;
		}
	}
	
	
	/**
	 * getPreviewPicId function.
	 * 
	 * @access public
	 * @return int
	 */
	public function getPreviewPicId()
	{
		return $this->intId;
	}
	
	
	/**
	 * getPreviewPicObject function.
	 * 
	 * @access public
	 * @return object
	 */
	public function getPreviewPicObject()
	{
		// Get preview pic as FilesModel object
		$this->objPreviewPic = \FilesModel::findByPk($this->intId);
		
		return $this->objPreviewPic;
	}
	
	
	/**
	 * getRandomPreviewPic function.
	 * 
	 * @access protected
	 * @return int
	 */
	protected function getRandomPreviewPic()
	{
		if(count($this->objAlbum->pictures) < 1)
		{
			return null;
		}
		
		// Deserialize
		$this->objAlbum->pictures = deserialize($this->objAlbum->pictures);
		
		// Get all pic ids and save them in the pictures array
		$objPicSorter = new \PicSorter($this->objAlbum->pictures, $GLOBALS['TL_DCA']['tl_photoalbums2_album']['fields']['pictures']['eval']['extensions']);
		$this->objAlbum->pictures = $objPicSorter->getPicIds();
		
		return $this->objAlbum->pictures[mt_rand(0, count($this->objAlbum->pictures)-1)];
	}
}
