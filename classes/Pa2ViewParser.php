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
 * Class Pa2ViewParser
 *
 * @copyright  Daniel Kiesel 2012-2014
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
		if (!is_object($objTemplate) || !$objTemplate instanceof \Template)
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
	protected function setEmptyTemplate($strMessage, $arrItems = array())
	{
		// If required set empty template
		$objPa2Empty = new \Pa2Empty($strMessage, $arrItems);

		if ($objPa2Empty->run() !== null)
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
	 * addComments function.
	 *
	 * @access public
	 * @return void
	 */
	public function addComments($objAlbum)
	{
		// HOOK: comments extension required
		if ($objAlbum->noComments || !in_array('comments', $this->Template->Config->getActiveModules()))
		{
			$this->Template->allowComments = false;
			return;
		}

		// Check whether comments are allowed
		$objArchive = \Photoalbums2ArchiveModel::findByPk($objAlbum->pid);

		if ($objArchive === null || !$objArchive->allowComments)
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
			$objAuthor = \UserModel::findByPk($objAlbum->author);

			if ($objAuthor !== null)
			{
				$arrNotifies[] = $objAuthor->email;
			}
		}

		$objConfig = new \stdClass();

		$objConfig->perPage = $objArchive->perPage;
		$objConfig->order = $objArchive->sortOrder;
		$objConfig->template = $this->com_template;
		$objConfig->requireLogin = $objArchive->requireLogin;
		$objConfig->disableCaptcha = $objArchive->disableCaptcha;
		$objConfig->bbcode = $objArchive->bbcode;
		$objConfig->moderate = $objArchive->moderate;

		$this->Comments->addCommentsToTemplate($this->Template, $objConfig, 'tl_photoalbums2_album', $objAlbum->id, $arrNotifies);
	}


	/**
	 * addDateToTemplate function.
	 *
	 * @access protected
	 * @param object $objTemplate
	 * @param int $intStartdate
	 * @param int $intEnddate
	 * @return object
	 */
	protected function addDateToTemplate($objTemplate, $intStartdate, $intEnddate)
	{
		global $objPage;

		// Check
		if (!is_object($objTemplate))
		{
			return false;
		}

		// Fixes the date format problem
		$dateFormat = ($objPage->dateFormat != '' ? $objPage->dateFormat : $GLOBALS['TL_CONFIG']['dateFormat']);

		$startdate = (!empty($intStartdate) && $intStartdate > 0) ? $this->parseDate($dateFormat, $intStartdate) : false;
		$enddate = (!empty($intEnddate) && $intEnddate > 0) ? $this->parseDate($dateFormat, $intEnddate) : false;

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


	/**
	 * addMetaFieldsToTemplate function.
	 *
	 * @access protected
	 * @param object $objTemplate
	 * @return object
	 */
	protected function addMetaFieldsToTemplate($objTemplate)
	{
		// Check
		if (is_object($objTemplate))
		{
			if (is_array($objTemplate->arrMetaFields) && count($objTemplate->arrMetaFields) > 0)
			{
				$metaFields = array();

				foreach($objTemplate->arrMetaFields as $metaField)
				{
					if ($objTemplate->$metaField != '')
					{
						$strMetaFieldDescription        = $GLOBALS['TL_LANG']['PA2']['pa2MetaFieldDescription'][$metaField];
						$strMetaFieldWithoutDescription = $GLOBALS['TL_LANG']['PA2']['pa2MetaFieldWithoutDescription'][$metaField];

						// Set strValue
						$strValue = $strMetaFieldWithoutDescription;

						// If meta description is active
						if ($objTemplate->showMetaDescriptions == '1')
						{
							$strValue = $strMetaFieldDescription;
						}

						// If the meta description has a singular and a plural version
						if (is_array($strValue))
						{
							if ($objTemplate->$metaField == '1' || count($strValue) < 2)
							{
								$strValue = $strValue[0];
							}
							else
							{
								$strValue = $strValue[1];
							}
						}

						// Set strValue to %s if the current strValue has no %s
						if (strpos($strValue, '%s') === false)
						{
							$strValue = '%s';
						}

						// Add meta data to strValue
						$strValue = sprintf($strValue, $objTemplate->$metaField);

						$metaFields[] = array
						(
							'key'      => $metaField,
							'value'    => $strValue
						);
					}
				}

				if (count($metaFields) > 0)
				{
					$objTemplate->metaFields = $metaFields;
				}
			}
		}

		return $objTemplate;
	}


	/**
	 * addSpecificClassesToTemplate function.
	 *
	 * @access protected
	 * @param object $objTemplate
	 * @param int $i
	 * @return object
	 */
	protected function addSpecificClassesToTemplate($objTemplate, $i)
	{
		// Do if vars are empty
		if (!is_object($objTemplate) || !is_numeric($objTemplate->totalItems) || !is_numeric($objTemplate->intItemsPerPage) || !is_numeric($i))
		{
			return $objTemplate;
		}

		// Define vars
		$arrClasses            = array();
		$arrStyles             = array();
		$totalItems            = $objTemplate->totalItems;
		$intItemsPerRow        = $objTemplate->intItemsPerRow;
		$intItemsPerPage       = $objTemplate->intItemsPerPage;
		$objTemplate->rowStart = false;
		$objTemplate->rowEnd   = false;

		// Fix division by zero problem
		$intItemsPerPage = ($intItemsPerPage < 1) ? $totalItems : $intItemsPerPage;

		$intItemNumberInRow    = ($i % $intItemsPerRow);
		$intItemNumberPerPage  = ($i % $intItemsPerPage);

		// Set maxPage
		$intMaxPage = (int) ceil($totalItems/$intItemsPerPage);

		// Set page
		$intPage = $this->Input->get('page');
		$intPage = (is_numeric($intPage)) ? $intPage : 1;
		$intPage = ($intMaxPage > $intPage) ? $intPage : $intMaxPage;

		// Set itemNumber var
		$itemNumber = $i + 1 + (($intPage - 1) * $intItemsPerPage);

		// Set firstItemInPageNumber
		$intFirstItemInPageNumber = (($intPage-1) * $intItemsPerPage) + 1;
		$intFirstItemInPageNumber = ($totalItems > $intFirstItemInPageNumber) ? $intFirstItemInPageNumber : $totalItems;

		// Set lastItemInPageNumber
		$intLastItemInPageNumber = ($intPage * $intItemsPerPage);
		$intLastItemInPageNumber = ($totalItems > $intLastItemInPageNumber) ? $intLastItemInPageNumber : $totalItems;

		// Add width to styles
		$arrStyles[] = 'width: ' . (100 / $intItemsPerRow) . '%;';


		// Add image propotion types to classes
		if (file_exists($objTemplate->href))
		{
			$arrImageSize = deserialize($objTemplate->size);

			if ($arrImageSize[0] > $arrImageSize[1])
			{
				$arrClasses[] = 'landscape';
			}
			else if ($arrImageSize[0] < $arrImageSize[1])
			{
				$arrClasses[] = 'portrait';
			}
			else if ($arrImageSize[0] == $arrImageSize[1] && $arrImageSize[0] != 0 && $arrImageSize[1] != 0)
			{
				$arrClasses[] = 'square';
			}
		}


		// Set row start
		if ($intItemNumberInRow == 0)
		{
			$arrClasses[] = 'first';
			$objTemplate->rowStart = true;
		}

		// Set row end
		if (($intItemNumberInRow + 1) == $intItemsPerRow || ($intItemNumberPerPage + 1) == $intItemsPerPage || $totalItems == ($i+1) || $itemNumber == $totalItems)
		{
			$arrClasses[] = 'last';
			$objTemplate->rowEnd = true;
		}

		// Add first of page and last of page to classes
		if ($itemNumber == $intFirstItemInPageNumber) $arrClasses[] = 'first_page';
		if ($itemNumber == $intLastItemInPageNumber)  $arrClasses[] = 'last_page';

		// Add first of all and last of all to classes
		if ($itemNumber == '1')         $arrClasses[] = 'first_all';
		if ($itemNumber == $totalItems) $arrClasses[] = 'last_all';


		// Add item number to classes
		$arrClasses[] = 'itemNumber_' . $itemNumber;

		// Set even and odd in items
		$arrClasses[] = ((($i % 2) == 0) ? 'even' : 'odd');

		// Set even and odd in rows
		if ($intItemNumberInRow == 0)
		{
			if (!isset($GLOBALS['pa2']['pa2RowEvenOdd']))
			{
				$GLOBALS['pa2']['pa2RowEvenOdd'] = 0;
			}

			$objTemplate->rowClass = ((($GLOBALS['pa2']['pa2RowEvenOdd'] % 2) == 0) ? 'even' : 'odd');

			$GLOBALS['pa2']['pa2RowEvenOdd']++;
		}


		// Add all classes to template
		$objTemplate->class = (($objTemplate->class == '') ? '' : $objTemplate->class . ' ') . implode(' ', $arrClasses);

		// Add all styles to template
		$objTemplate->style = (($objTemplate->style == '') ? '' : $objTemplate->style . ' ') . implode(' ', $arrStyles);

		// Add vars to template
		$objTemplate->itemNumber = $itemNumber;
		$objTemplate->firstItemInPageNumber = $intFirstItemInPageNumber;
		$objTemplate->lastItemInPageNumber = $intLastItemInPageNumber;

		return $objTemplate;
	}


	/**
	 * addLinkToTemplate function.
	 *
	 * @access protected
	 * @param object $objTemplate
	 * @param object $objAlbum
	 * @return object
	 */
	protected function addLinkToTemplate($objTemplate, $objAlbum)
	{
		global $objPage;

		// Check
		if (!is_object($objTemplate))
		{
			return $objTemplate;
		}

		if (is_numeric($objAlbum))
		{
			$objPa2Album = new \Pa2Album($objAlbum, $objTemplate->getData());
			$objAlbum = $objPa2Album->getAlbums();
			$objAlbum = $objAlbum->current();
		}

		if (!is_object($objAlbum))
		{
			return $objTemplate;
		}

		// Add array
		$arrLink = array(
			'id' => $objPage->id,
			'alias' => $objPage->alias
		);

		if (!empty($objTemplate->intDetailPage) && is_numeric($objTemplate->intDetailPage))
		{
			$objDetailPage = $this->getPageDetails($objTemplate->intDetailPage);

			$arrLink['id'] = $objDetailPage->id;
			$arrLink['alias'] = $objDetailPage->alias;
			$arrLink['language'] = $objDetailPage->language;
		}

		$objTemplate->href = $this->generateFrontendUrl($arrLink, sprintf(($GLOBALS['TL_CONFIG']['useAutoItem'] ?  '/%s' : '/album/%s'), $objAlbum->alias), $objDetailPage->language);

		return $objTemplate;
	}


	/**
	 * generateIndividualId function.
	 *
	 * @access protected
	 * @return string
	 */
	protected function generateIndividualId()
	{
		// Set global variable
		if (!isset($GLOBALS['pa2']['individualId']) || !is_array($GLOBALS['pa2']['individualId']))
		{
			$GLOBALS['pa2']['individualId'] = array();
			$GLOBALS['pa2']['individualId']['count'] = 0;
		}

		// Count up
		$GLOBALS['pa2']['individualId']['count']++;

		// New id
		$individualId = substr(md5('pa2_' . $GLOBALS['pa2']['individualId']['count']), 1, 12);

		// If new id already in id list exists
		if (is_array($GLOBALS['pa2']['individualId']['id']) && in_array($individualId, $GLOBALS['pa2']['individualId']['id']))
		{
			return $this->generateIndividualId();
		}

		// Add new id to id list
		$GLOBALS['pa2']['individualId']['id'][] = $individualId;

		return $individualId;
	}


	/**
	 * getImageTitle function.
	 *
	 * @access protected
	 * @param object $objImage
	 * @return void
	 */
	protected function getImageTitle($objImage)
	{
		if (!is_object($objImage))
		{
			return false;
		}

		// Set the filename as default
		$strAlt = $objImage->name;

		// If there is a meta title in the current language, then use this meta data
		if ($objImage->meta[$GLOBALS['TL_LANGUAGE']] != '')
		{
			$strAlt = $objImage->meta[$GLOBALS['TL_LANGUAGE']]['title'];
		}
		// Else if there is a meta title in english, use this meta data
		else if ($objImage->meta['en'] != '')
		{
			$strAlt = $objImage->meta['en']['title'];
		}

		return $strAlt;
	}


	/**
	 * getViewParserTemplate function.
	 *
	 * @access public
	 * @return object
	 */
	public function getViewParserTemplate()
	{
		return $this->Template;
	}
}
