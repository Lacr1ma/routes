<?php

declare(strict_types = 1);

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

defined('TYPO3') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptConstants(
    "@import 'EXT:demo/Configuration/TypoScript/constants.typoscript'"
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
    "@import 'EXT:demo/Configuration/TypoScript/setup.typoscript'"
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Demo',
    'DemoApi',
    [
        \LMS\Demo\Controller\DemoApiController::class => 'show, index, store, update, destroy, fail, test, testWithParams, checkOwner,  updateRaw'
    ],
    [
        \LMS\Demo\Controller\DemoApiController::class => 'show, index, store, update, destroy, fail, test, testWithParams, checkOwner,  updateRaw'
    ]
);

$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['routes']['additionalPathList'] = [
  0 => '/var/www/html/public/typo3conf/ext/demo/Configuration/API/test.yaml',
  1 => '/var/www/html/public/typo3conf/ext/demo/Configuration/API/test1.yaml'
];
