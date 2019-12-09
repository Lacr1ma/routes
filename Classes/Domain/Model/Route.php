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

use LMS\Facade\Extbase\Plugin;
use LMS\Routes\Support\Route\Arguments as ContainsArguments;
use LMS\Routes\Support\Route\Controller as DefinesController;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class Route
{
    use ContainsArguments, DefinesController;

    /**
     * @var string
     */
    private $action;

    /**
     * @var string
     */
    private $format;

    /**
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        [$controllerFQCN, $this->action] = explode('::', $configuration['_controller']);

        $this->format = $configuration['_format'] ?: '';

        $this->initializeController($controllerFQCN);
        $this->initializeArguments($configuration);
    }

    /**
     * Get the Extbase <Action> name
     *
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Get Request Format
     *
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlugin(): string
    {
        $controller = $this->getController();
        $extensionKey = $this->getExtension();

        return Plugin::getNameBasedOn($extensionKey, $controller, $this->action);
    }

    /**
     * {@inheritdoc}
     */
    public function getPluginNamespace(): string
    {
        return Plugin::getNamespaceBasedOn($this->getExtension(), $this->getPlugin());
    }
}
