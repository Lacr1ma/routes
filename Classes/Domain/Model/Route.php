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

use LMS\Routes\Support\Plugin;
use LMS\Routes\Support\Route\Controller;
use LMS\Routes\Support\Route\Arguments as ContainsArguments;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class Route
{
    use ContainsArguments;

    private string $action;
    private string $format;
    private string $plugin;
    private Plugin $pluginService;
    private Controller $controller;

    public function __construct(Plugin $service, Controller $controller)
    {
        $this->controller = $controller;
        $this->pluginService = $service;
    }

    public function setConfiguration(array $config, ServerRequestInterface $request): void
    {
        [$controllerFQCN, $this->action] = explode('::', $config['_controller']);

        $this->plugin = $config['plugin'] ?? '';
        $this->format = $config['_format'] ?? '';

        $this->controller->initializeController($controllerFQCN, $request);
        $this->initializeArguments($config);
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function getPlugin(): string
    {
        $controller = $this->controller->getController();
        $extensionKey = $this->controller->getExtension();

        return $this->plugin ?: $this->pluginService->getNameBasedOn($extensionKey, $controller, $this->action);
    }

    public function getPluginNamespace(): string
    {
        return $this->pluginService
            ->getNamespaceBasedOn($this->controller->getExtension(), $this->getPlugin());
    }

    public function getController(): Controller
    {
        return $this->controller;
    }
}
