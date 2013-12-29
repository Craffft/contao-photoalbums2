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
 * Class Pa2PreviewImage
 *
 * @copyright  Daniel Kiesel 2012-2014
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class Pa2PreviewImage extends \Controller
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
	 * objPreviewImage
	 *
	 * @var object
	 * @access private
	 */
	private $objPreviewImage;


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
		if (is_numeric($objAlbum))
		{
			$objAlbum = \Photoalbums2AlbumModel::findByPk($objAlbum);
		}

		if (!is_object($objAlbum))
		{
			return false;
		}

		$this->objAlbum = $objAlbum;
		$this->type = $type;

		$this->setPreviewImageId();
	}


	/**
	 * getPreviewImage function.
	 *
	 * @access private
	 * @return void
	 */
	private function setPreviewImageId()
	{
		$this->intId = null;

		switch($this->type)
		{
		case 'use_album_options':
			switch($this->objAlbum->previewImageType)
			{
			case 'no_preview_image':
				$this->intId = null;
				break;

			case 'random_preview_image':
				$this->intId = $this->getRandomPreviewImage();
				break;

			case 'select_preview_image':
				$this->intId = $this->objAlbum->previewImage;
				break;
			}
			break;

		case 'no_preview_images':
			$this->intId = null;
			break;

		case 'random_images':
			$this->intId = $this->getRandomPreviewImage();
			break;

		case 'random_images_at_no_preview_images':
			if ($this->objAlbum->previewImageType == 'select_preview_image')
			{
				$this->intId = $this->objAlbum->previewImage;
			}
			else
			{
				$this->intId = $this->getRandomPreviewImage();
			}
			break;
		}
	}


	/**
	 * getPreviewImageId function.
	 *
	 * @access public
	 * @return int
	 */
	public function getPreviewImageId()
	{
		return $this->intId;
	}


	/**
	 * getPreviewImage function.
	 *
	 * @access public
	 * @return object
	 */
	public function getPreviewImage()
	{
		if (is_object($this->objPreviewImage))
		{
			return $this->objPreviewImage;
		}

		// Get preview image as FilesModel object
		$this->objPreviewImage = \FilesModel::findByPk($this->intId);

		return $this->objPreviewImage;
	}


	/**
	 * getRandomPreviewImage function.
	 *
	 * @access protected
	 * @return int
	 */
	protected function getRandomPreviewImage()
	{
		if (count($this->objAlbum->images) < 1)
		{
			return null;
		}

		// Deserialize
		$this->objAlbum->images = deserialize($this->objAlbum->images);

		// Get all image ids and save them in the images array
		$objImageSorter = new \ImageSorter($this->objAlbum->images, $GLOBALS['TL_DCA']['tl_photoalbums2_album']['fields']['images']['eval']['extensions']);
		$this->objAlbum->images = $objImageSorter->getImageIds();

		return $this->objAlbum->images[mt_rand(0, count($this->objAlbum->images)-1)];
	}
}
