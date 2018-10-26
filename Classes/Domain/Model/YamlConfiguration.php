<?php
declare(strict_types = 1);
namespace LMS\Routes\Domain\Model;

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

use LMS\Routes\Traits\Plugin;
use LMS\Routes\Traits\ObjectManageable;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class YamlConfiguration
{
    use ObjectManageable, Plugin;

    /**
     * @var \TYPO3\CMS\Extbase\Mvc\Request
     */
    private $request;

    /**
     * @var string
     */
    private $action;

    /**
     * @var array
     */
    private $arguments = [];

    /**
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        [$controllerFQCN, $this->action] = explode('::', $configuration['_controller']);

        $this->initializeRequest($controllerFQCN);
        $this->initializeArguments($configuration);
    }

    /**
     * @param string $controllerFQCN
     * @return void
     */
    private function initializeRequest(string $controllerFQCN): void
    {
        $this->request = ObjectManageable::createObject(Request::class);
        $this->request->setControllerObjectName($controllerFQCN);
    }

    /**
     * @param array $configuration
     */
    private function initializeArguments(array $configuration): void
    {
        foreach ($configuration as $name => $value) {
            // Any name that start by <_> are metadata and should not be initialized as arguments
            if (strpos($name,'_') === 0) {
                continue;
            }

            $this->arguments[$name] = GeneralUtility::_GP($name) ?? $value;
        }
    }

    /**
     * @return string
     */
    public function getPlugin(): string
    {
        $controller = $this->request->getControllerName();
        $extensionKey = $this->getExtension();

        return Plugin::getNameBasedOn($extensionKey, $controller, $this->getAction());
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->request->getControllerExtensionName();
    }

    /**
     * @return string
     */
    public function getVendor(): string
    {
        return $this->request->getControllerVendorName();
    }

    /**
     * @return string
     */
    public function getPluginNameSpace(): string
    {
        return Plugin::getNamespaceBasedOn($this->getExtension(), $this->getPlugin());
    }
}
