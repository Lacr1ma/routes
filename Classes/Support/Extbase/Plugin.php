<?php
declare(strict_types = 1);
namespace LMS\Routes\Support\Extbase;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Service\ExtensionService;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait Plugin
{
    /**
     * Retrieve the Plugin namespace based on extension and plugin.
     *
     * @api
     * @param  string $extensionName
     * @param  string $pluginTitle
     * @return string
     */
    public static function getNamespaceBasedOn(string $extensionName, string $pluginTitle): string
    {
        return self::getExtensionService()->getPluginNamespace($extensionName, $pluginTitle);
    }

    /**
     * Retrieve the Plugin name by used extension, controller and action
     *
     * @api
     * @param  string $extensionName
     * @param  string $controller
     * @param  string $action
     * @return string
     */
    public static function getNameBasedOn(string $extensionName, string $controller, string $action): string
    {
        try {
            return self::getExtensionService()
                                ->getPluginNameByAction($extensionName, $controller, $action);
        } catch (\TYPO3\CMS\Core\Exception $e) {
            return '';
        }
    }

    /**
     * Returns the Extension Service
     *
     * @return \TYPO3\CMS\Extbase\Service\ExtensionService|Object
     */
    private static function getExtensionService(): ExtensionService
    {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        return $objectManager->get(ExtensionService::class);
    }
}
