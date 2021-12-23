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

use TYPO3\CMS\Core\Routing\RouteCollection;
use Symfony\Component\Routing\Loader\YamlFileLoader as SymfonyLoader;
use Symfony\Component\Config\Exception\FileLocatorFileNotFoundException;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class YamlFileLoader extends SymfonyLoader
{
    /**
     * {@inheritdoc}
     * @psalm-suppress InternalClass
     * @psalm-suppress MissingParamType
     * @psalm-suppress ParamNameMismatch
     */
    public function load($file, string $type = null): RouteCollection
    {
        $collection = new RouteCollection();

        foreach ($this->getFoundPathList($file) as $path) {
            $collection->addCollection(parent::load($path));
        }

        return $collection;
    }

    private function getFoundPathList(string $file): array
    {
        $yml = $this->retrievePathFor($file . '.yml');
        $yaml = $this->retrievePathFor($file . '.yaml');
        if (array_key_exists("additionalPathList", $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['routes'])) {
            $custom = (array)$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['routes']['additionalPathList'];
        } else {
            $custom = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['routes']['additionalPathList'] = [];
        }

        return array_merge($yml, $yaml, $custom);
    }

    private function retrievePathFor(string $file): array
    {
        try {
            return (array)$this->locator->locate($file, null, false);
        } catch (FileLocatorFileNotFoundException $e) {
            return [];
        }
    }
}
