<?php
/** @noinspection PhpUnusedLocalVariableInspection */

declare(strict_types = 1);

namespace LMS\Routes\Support;

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

use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Extbase\Service\ExtensionService;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class Plugin
{
    private ExtensionService $extension;

    public function __construct(ExtensionService $extension)
    {
        $this->extension = $extension;
    }

    public function getNamespaceBasedOn(string $extName, string $pluginTitle): string
    {
        return $this->extension->getPluginNamespace($extName, $pluginTitle);
    }

    public function getNameBasedOn(string $extName, string $controller, string $action): string
    {
        try {
            return (string)$this->extension->getPluginNameByAction($extName, $controller, $action);
        } catch (Exception $e) {
            return '';
        }
    }
}
