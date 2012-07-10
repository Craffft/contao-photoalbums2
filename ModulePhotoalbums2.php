<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel 
 * @package    photoalbums2 
 * @license    LGPL 
 * @filesource
 */


/**
 * Class ModulePhotoalbums2
 *
 * @copyright  Daniel Kiesel 2012 
 * @author     Daniel Kiesel 
 * @package    Controller
 */
class ModulePhotoalbums2 extends Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_photoalbums2';


	/**
	 * Subtemplate
	 * @var string
	 */
	protected $strSubtemplate = 'pa2_album';


	/**
	 * Elements
	 * @var array
	 */
	private $arrElements = array();


	/**
	 * Number of
	 * @var int
	 */
	private $pa2NumberOf;


	/**
	 * Per page
	 * @var int
	 */
	private $pa2PerPage;


	/**
	 * Empty
	 * @var string
	 */
	private $empty = '';
	
	
	/**
	 * generate function.
	 * 
	 * @access public
	 * @return void
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### PHOTOALBUMS 2 MODULE ###';

			return $objTemplate->parse();
		}
		
		// Deserialize vars
		$this->groups = deserialize($this->groups);
		$this->pa2Archives = deserialize($this->pa2Archives);
		$this->pa2AlbumsMetaFields = deserialize($this->pa2AlbumsMetaFields);
		$this->pa2PhotosMetaFields = deserialize($this->pa2PhotosMetaFields);
		$this->pa2TimeFilterStart = deserialize($this->pa2TimeFilterStart);
		$this->pa2TimeFilterEnd = deserialize($this->pa2TimeFilterEnd);
		
		// Set true and false on checkboxes
		$this->pa2PhotosShowHeadline = ($this->pa2PhotosShowHeadline == 1) ? true : false;
		$this->pa2PhotosShowTitle = ($this->pa2PhotosShowTitle == 1) ? true : false;
		$this->pa2PhotosShowTeaser = ($this->pa2PhotosShowTeaser == 1) ? true : false;
		$this->pa2AlbumsShowHeadline = ($this->pa2AlbumsShowHeadline == 1) ? true : false;
		$this->pa2AlbumsShowTitle = ($this->pa2AlbumsShowTitle == 1) ? true : false;
		$this->pa2AlbumsShowTeaser = ($this->pa2AlbumsShowTeaser == 1) ? true : false;
		$this->pa2AlbumLightbox = ($this->pa2Mode == 'pa2_only_album_view') ? true : false;
		$this->pa2DetailPage = ($this->pa2Mode == 'pa2_with_detail_page') ? $this->pa2DetailPage : '';
		
		// Get unsorted pictures
		$this->import('PicSortWizard');
		$this->loadDataContainer('tl_photoalbums2_album');
		$this->pictures = $this->PicSortWizard->getUnsortedPictures($this->pictures, $GLOBALS['TL_DCA']['tl_photoalbums2_album']['fields']['pictures']['eval']['extensions']);
		
		// Set the item from the auto_item parameter
		if ($GLOBALS['TL_CONFIG']['useAutoItem'] && isset($_GET['auto_item']))
		{
			$this->Input->setGet('album', $this->Input->get('auto_item'));
		}
		
		return parent::generate();
	}


	/**
	 * compile function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function compile()
	{
		global $objPage;
		
		// Show photos
		if($this->Input->get('album') && (($this->pa2DetailPage == '') || ($this->pa2DetailPage != '' && ($this->pa2DetailPage == $objPage->id || ($objPage->languageMain != '' && $objPage->languageMain == $this->pa2DetailPage)))))
		{
			$this->preparePhotos();
		}
		// Show albums
		else if(!$this->Input->get('album') && ($this->pa2DetailPage == '' || ($this->pa2DetailPage != '' && $this->pa2DetailPage != $objPage->id)))
		{
			$this->prepareAlbums();
		}
		// Go to detail page (photos)
		else if($this->Input->get('album'))
		{
			$this->goToDetailPage();
		}
		// Go to root page
		else
		{
			$this->goToRootPage();
		}
		
		// Add photoalbums2 css file
		$this->Pa2->addCssFile();
		
		// Add Subtemplate to Template
		$this->Template->strSubtemplate = $this->strSubtemplate;
		
		// Get albums
		$total = count($this->arrElements);
		
		// If albums empty
		if ($total < 1 || !$this->arrElements || $this->arrElements == false)
		{
			$this->strTemplate = 'mod_photoalbums2_empty';
			$this->Template = new FrontendTemplate($this->strTemplate);
			$this->Template->setData($this->arrData);
			$this->Template->empty = $this->empty;
			
			return;
		}
		
		// Pagination
		$arrPa2Pagination = $this->Pa2->pa2Pagination($this->arrElements, $this->pa2NumberOf, $this->pa2PerPage, $total);
		$this->arrElements = $arrPa2Pagination['elements'];
		$this->Template->pagination = $arrPa2Pagination['pagination'];
		
		// Set total var in template object
		$this->Template->totalAll = $total;
		
		// Add arrVars to Pa2
		$this->Pa2 = $this->addArrVars($this->Pa2);
		
		// Check for detail view
		if ($this->Input->get('album'))
		{
			// Parse photos
			$this->Template = $this->Pa2->parsePhotos($this->Template, $this->arrPhotos, $this->arrElements);
		}
		else
		{
			// Parse albums
			$this->Template = $this->Pa2->parseAlbums($this->Template, $this->arrElements);
		}
	}
	
	
	/**
	 * preparePhotos function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function preparePhotos()
	{
		// Import Photoalbums2 class
		$this->import('Pa2Photos', 'Pa2');
		
		// Set Subtemplate
		$this->strSubtemplate = $this->pa2PhotosTemplate;
		
		// Add arrVars to Pa2
		$this->Pa2 = $this->addArrVars($this->Pa2);
		
		$this->pa2NumberOf = $this->pa2NumberOfPhotos;
		$this->pa2PerPage = $this->pa2PhotosPerPage;
		$this->arrElements = $this->Pa2->getAlbum($this->Input->get('album'));
		
		$this->arrPhotos = $this->arrElements[0];
		
		$this->arrElements = ($this->arrElements[0]['pic_sort_check'] == 'pic_sort_wizard') ? $this->arrElements[0]['pic_sort'] : $this->Pa2->sortElements($this->arrElements[0]['pictures'], $this->arrElements[0]['pic_sort_check']);
		
		// Save referer from albums page
		if($this->Session->get('pa2_referer') == NULL)
		{
			$referer = $this->Session->get('referer');
			$this->Session->set('pa2_referer', $referer['current']);
		}
		
		$this->Template->referer = $this->Session->get('pa2_referer');
		$this->Template->back = $GLOBALS['TL_LANG']['MSC']['goBack'];
		
		// Empty text
		$this->empty = $GLOBALS['TL_LANG']['MSC']['photosEmpty'];
		
		// Add comments module
		$this->addComments($this->arrPhotos);
	}
	
	
	/**
	 * prepareAlbums function.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function prepareAlbums()
	{
		// Import Photoalbums2 class
		$this->import('Pa2Albums', 'Pa2');
		
		// Remove referer
		$this->Session->remove('pa2_referer');
		
		// Set Subtemplate
		$this->strSubtemplate = $this->pa2AlbumsTemplate;
		
		// Add arrVars to Pa2
		$this->Pa2 = $this->addArrVars($this->Pa2);
		
		// Define vars
		$this->pa2NumberOf = $this->pa2NumberOfAlbums;
		$this->pa2PerPage = $this->pa2AlbumsPerPage;
		
		// Sort out 
		$this->pa2Archives = $this->Pa2->sortOutElements($this->pa2Archives);
		$this->arrElements = $this->Pa2->getAlbums($this->pa2Archives);
		
		// Empty text
		$this->empty = $GLOBALS['TL_LANG']['MSC']['albumsEmpty'];
	}
	
	
	/**
	 * goToDetailPage function.
	 * 
	 * @access public
	 * @return void
	 */
	public function goToDetailPage()
	{
		// Get detail page informations
		$objDetailPage = $this->getPageDetails($this->pa2DetailPage);
		
		// Add array
		$arrDetailPage = array(
			'id' => $objDetailPage->id,
			'alias' => $objDetailPage->alias
		);
		
		$linkDetailPage = $this->generateFrontendUrl($arrDetailPage, sprintf(($GLOBALS['TL_CONFIG']['useAutoItem'] ?  '/%s' : '/album/%s'), $this->Input->get('album')), $objDetailPage->language);
		
		if(($this->Input->get('page') != '') && ($this->Input->get('page') != NULL) && is_numeric($this->Input->get('page')))
		{
			$linkDetailPage .= '?page=' . $this->Input->get('page');
		}
		
		// Locate to detail page
		$this->redirect($linkDetailPage);
	}
	
	
	/**
	 * goToRootPage function.
	 * 
	 * @access public
	 * @return void
	 */
	public function goToRootPage()
	{
		global $objPage;
		
		// Do not index or cache the page if no album has been specified
		$objPage->noSearch = 1;
		$objPage->cache = 0;
		
		// Get root page informations
		$objRootPage = $this->getPageDetails($objPage->rootId);
		
		// Add array
		$arrRootPage = array(
		    'id' => $objRootPage->id,
		    'alias' => $objRootPage->alias
		);
		
		$linkRootPage = $this->generateFrontendUrl($arrRootPage);
		
		// Locate to root page
		$this->redirect($linkRootPage);
	}
	
	
	/**
	 * addComments function.
	 * 
	 * @access public
	 * @return void
	 */
	public function addComments($arrAlbum)
	{
		// HOOK: comments extension required
		if ($arrAlbum['noComments'] || !in_array('comments', $this->Config->getActiveModules()))
		{
			$this->Template->allowComments = false;
			return;
		}
		
		// Check whether comments are allowed
		$objArchive = $this->Database->prepare("SELECT * FROM tl_photoalbums2_archive WHERE id=?")
									 ->limit(1)
									 ->execute($this->pid);

		if ($objArchive->numRows < 1 || !$objArchive->allowComments)
		{
			$this->Template->allowComments = false;
			return;
		}

		$this->Template->allowComments = true;

		// Adjust the comments headline level
		$intHl = min(intval(str_replace('h', '', $this->hl)), 5);
		$this->Template->hlc = 'h' . ($intHl + 1);

		$this->import('Comments');
		$arrNotifies = array();
		
		// Notify system administrator
		if ($objArchive->notify != 'notify_author')
		{
			$arrNotifies[] = $GLOBALS['TL_ADMIN_EMAIL'];
		}

		// Notify author
		if ($objArchive->notify != 'notify_admin')
		{
			$objAuthor = $this->Database->prepare("SELECT email FROM tl_user WHERE id=?")
										->limit(1)
										->execute($arrAlbum['author']);

			if ($objAuthor->numRows)
			{
				$arrNotifies[] = $objAuthor->email;
			}
		}

		$objConfig = new stdClass();

		$objConfig->perPage = $objArchive->perPage;
		$objConfig->order = $objArchive->sortOrder;
		$objConfig->template = $this->com_template;
		$objConfig->requireLogin = $objArchive->requireLogin;
		$objConfig->disableCaptcha = $objArchive->disableCaptcha;
		$objConfig->bbcode = $objArchive->bbcode;
		$objConfig->moderate = $objArchive->moderate;
		
		$this->Comments->addCommentsToTemplate($this->Template, $objConfig, 'tl_photoalbums2_album', $arrAlbum['id'], $arrNotifies);
	}
	
	
	/**
	 * addArrVars function.
	 * 
	 * @access public
	 * @param obj $objPa2
	 * @return obj
	 */
	public function addArrVars($objPa2)
	{
		if(!is_object($objPa2))
		{
			return $objPa2;
		}
		
		// Define arrVars
		$arrVars = array(
			'id'				=> $this->id,
			'strSubtemplate'	=> $this->strSubtemplate,
			'arrData'			=> $this->arrData,
			'pa2DetailPage'		=> $this->pa2DetailPage,
			'pa2Teaser'			=> $this->pa2Teaser
		);
		
		// Check for detail view
		if ($this->Input->get('album'))
		{
			// Add to arrVars
			$arrVars['pa2MetaFields']		= $this->pa2PhotosMetaFields;
			$arrVars['pa2PerRow']			= $this->pa2PhotosPerRow;
			$arrVars['pa2ImageSize']		= $this->pa2PhotosImageSize;
			$arrVars['pa2ImageMargin']		= $this->pa2PhotosImageMargin;
			$arrVars['pa2ShowHeadline']		= $this->pa2PhotosShowHeadline;
			$arrVars['pa2ShowTitle']		= $this->pa2PhotosShowTitle;
			$arrVars['pa2ShowTeaser']		= $this->pa2PhotosShowTeaser;
		}
		else
		{
			// Add to arrVars
			$arrVars['pa2MetaFields']		= $this->pa2AlbumsMetaFields;
			$arrVars['pa2PerRow']			= $this->pa2AlbumsPerRow;
			$arrVars['pa2ImageSize']		= $this->pa2AlbumsImageSize;
			$arrVars['pa2ImageMargin']		= $this->pa2AlbumsImageMargin;
			$arrVars['pa2ShowHeadline']		= $this->pa2AlbumsShowHeadline;
			$arrVars['pa2ShowTitle']		= $this->pa2AlbumsShowTitle;
			$arrVars['pa2ShowTeaser']		= $this->pa2AlbumsShowTeaser;
			$arrVars['pa2AlbumLightbox']	= $this->pa2AlbumLightbox;
			$arrVars['pa2PreviewPic']		= $this->pa2PreviewPic;
		}
		
		// Add arrVars to Pa2
		$objPa2->addArrVars($arrVars);
		
		return $objPa2;
	}
}

?>