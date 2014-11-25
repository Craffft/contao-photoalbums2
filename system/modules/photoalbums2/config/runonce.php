<?php

/**
 * Extension for Contao Open Source CMS
 *
 * Copyright (c) 2012-2014 Daniel Kiesel
 *
 * @package Photoalbums2
 * @link    https://github.com/icodr8/contao-photoalbums
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Namespace
 */
namespace Photoalbums2;

/**
 * Class Photoalbums2Runonce
 *
 * @copyright  Daniel Kiesel 2012-2014
 * @author     Daniel Kiesel <https://github.com/icodr8>
 * @package    photoalbums2
 */
class Photoalbums2Runonce extends \System
{
    public function __construct()
    {
        parent::__construct();

        // Disable debug mode
        $GLOBALS['TL_CONFIG']['debugMode'] = false;

        // Load required classes
        \ClassLoader::addNamespace('Photoalbums2');
        \ClassLoader::addClass('Photoalbums2\Updater', 'system/modules/photoalbums2/classes/Updater.php');
        \ClassLoader::register();

        // Load updater
        $this->import('\Photoalbums2\Updater', 'Updater');
    }

    public function run()
    {
        $this->Updater->createTranslationFieldsTableIfItNotExists();
        $this->Updater->updateDatabaseFields();
        $this->Updater->updateTranslationFields();
        $this->Updater->updateUuidFields();
    }
}

/**
 * Instantiate controller
 */
$objPhotoalbums2Runonce = new Photoalbums2Runonce();
$objPhotoalbums2Runonce->run();
