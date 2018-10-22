<?php
namespace LMS\Routes\Traits;

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
use TYPO3\CMS\Extbase\Configuration\{ConfigurationManager, ConfigurationManagerInterface as Configuration};
use TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait TypoScriptConfiguration
{
    /**
     * Get TypoScript settings area from requested extension (tx_extensionKey.settings)
     *
     * @api
     * @param  string $extensionKey
     * @return array
     */
    public static function getSettings(string $extensionKey = 'tx_routes'): array
    {
        $ts = self::retrieveFullTypoScriptConfigurationFor($extensionKey);

        return (array) $ts['settings.'];
    }

    /**
     *  Get all TypoScript definition for the requested extension (tx_extensionKey)
     *
     * @api
     * @param  string $extensionKey
     * @return array
     */
    public static function retrieveFullTypoScriptConfigurationFor(string $extensionKey): array
    {
        try {
            $ts = self::getConfigurationManager()
                    ->getConfiguration(Configuration::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        } catch (InvalidConfigurationTypeException $e) { return []; }

        return $ts['plugin.'][$extensionKey . '.'] ?: [];
    }

    /**
     * Returns the Configuration Manager instance
     *
     * @return ConfigurationManager|Object
     */
    private static function getConfigurationManager(): ConfigurationManager
    {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        return $objectManager->get(ConfigurationManager::class);
    }
}
