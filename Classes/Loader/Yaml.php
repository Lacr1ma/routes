<?php
declare(strict_types = 1);
namespace LMS\Routes\Loader;

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

use LMS\Routes\Traits\TypoScriptConfiguration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait Yaml
{
    use TypoScriptConfiguration;

    /**
     * @api
     * @return YamlFileLoader
     */
    public function getLoader(): YamlFileLoader
    {
        return new YamlFileLoader(
            new \Symfony\Component\Config\FileLocator($this->getPossiblePaths())
        );
    }

    /**
     * @return array
     */
    private function getPossiblePaths(): array
    {
        $customExtensionsFolderPath = Environment::getPublicPath() . '/typo3conf/ext/';
        $yamlFolderPath = TypoScriptConfiguration::getSettings()['suffix'];

        $paths = [];
        foreach (GeneralUtility::get_dirs($customExtensionsFolderPath) as $extensionKey) {
            $paths[] = $customExtensionsFolderPath . $extensionKey . $yamlFolderPath;
        }

        return $paths;
    }
}
