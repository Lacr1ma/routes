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

use Symfony\Component\Config\Exception\FileLocatorFileNotFoundException;
use TYPO3\CMS\Core\Routing\RouteCollection;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class YamlFileLoader extends \Symfony\Component\Routing\Loader\YamlFileLoader
{
    /**
     * {@inheritdoc}
     */
    public function load($file, $type = null): RouteCollection
    {
        $collection = new RouteCollection();

        foreach ($this->getFoundPathList((string)$file) as $path) {
            $collection->addCollection(parent::load($path));
        }

        return $collection;
    }

    /**
     * @param  string $file
     *
     * @return array
     */
    private function getFoundPathList(string $file): array
    {
        try {
            return $this->locator->locate($file, null, false);
        } catch (FileLocatorFileNotFoundException $e) {
            return [];
        }
    }
}
