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
    "@import 'EXT:routes/Configuration/TypoScript/constants.typoscript'"
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
    "@import 'EXT:routes/Configuration/TypoScript/setup.typoscript'"
);

$cache = $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'];

if (!array_key_exists('tx_routes', $cache)) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tx_routes'] = [];
}

(static function (): void {
    $GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive(
        $GLOBALS['TYPO3_CONF_VARS'],
        [
            'SYS' => [
                'routing' => [
                    'enhancers' => [
                        'Routes' => \LMS\Routes\Routing\RestApiEnhancer::class
                    ]
                ]
            ]
        ]
    );
})();

$GLOBALS['TYPO3_CONF_VARS']['FE']['disableNoCacheParameter'] = false;
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['routes']['routesFileName'] = 'Routes';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Routes',
    'RoutesApi',
    [
        \LMS\Routes\Controller\ManagementController::class => 'ping'
    ],
    [
        \LMS\Routes\Controller\ManagementController::class => 'ping'
    ]
);
