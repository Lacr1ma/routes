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

use LMS\Routes\Support\Extbase\TypoScriptConfiguration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait Yaml
{
    use TypoScriptConfiguration;

    /**
     * Get the loader, which contains all the possible locations where we could find Routes.yml
     *
     * @api
     * @return \LMS\Routes\Loader\YamlFileLoader
     */
    public function getLoader(): YamlFileLoader
    {
        return new YamlFileLoader(
            new \Symfony\Component\Config\FileLocator($this->getPossiblePaths())
        );
    }

    /**
     * Returns the array, that collects paths, of all custom extensions that have been installed.
     * Also as need to search under custom extension suffix, each path will contains that suffix as well.
     *
     * Let's imagine that we have only 2 custom extensions (news, blog)  installed on a system, then the result will be:
     * [
     *    0 => 'typo3conf/ext/news/Configuration',
     *    1 => 'typo3conf/ext/blog/Configuration',
     * }
     *
     * @return array
     */
    private function getPossiblePaths(): array
    {
        $customExtensionsFolderPath = Environment::getPublicPath() . '/typo3conf/ext/';
        $yamlFolderPath = TypoScriptConfiguration::getSettings()['suffix'] ?? '/Configuration';

        $paths = [];
        foreach (GeneralUtility::get_dirs($customExtensionsFolderPath) as $extensionKey) {
            $paths[] = $customExtensionsFolderPath . $extensionKey . $yamlFolderPath;
        }

        return $paths;
    }
}
