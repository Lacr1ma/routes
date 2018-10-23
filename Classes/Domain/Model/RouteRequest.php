<?php
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

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Request;
use TYPO3\CMS\Extbase\Mvc\Exception\{InvalidActionNameException, InvalidArgumentNameException};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class RouteRequest extends Request
{
    /**
     * @var YamlConfiguration
     */
    private $route;

    /**
     * @param  YamlConfiguration            $route
     * @param  ServerRequestInterface       $originalRequest
     * @throws InvalidActionNameException
     * @throws InvalidArgumentNameException
     */
    public function __construct(YamlConfiguration $route, ServerRequestInterface $originalRequest)
    {
        $this->route = $route;
        $this->originalRequest = $originalRequest;

        $this->initialize();
    }

    /**
     * @return void
     * @throws InvalidActionNameException
     * @throws InvalidArgumentNameException
     */
    private function initialize(): void
    {
        $this->initializeController()
             ->initializeAction()
             ->initializeFormat()
             ->initializeArguments();
    }

    /**
     * @return self
     */
    private function initializeController(): self
    {
        $this->setControllerObjectName($this->route->getControllerFQCN());

        return $this;
    }

    /**
     * @return self
     * @throws InvalidActionNameException
     */
    private function initializeAction(): self
    {
        $this->setControllerActionName($this->route->getAction());

        return $this;
    }

    /**
     * @return self
     */
    private function initializeFormat(): self
    {
        $this->setFormat($this->route->getFormat());

        return $this;
    }

    /**
     * @return self
     * @throws InvalidArgumentNameException
     */
    private function initializeArguments(): self
    {
        foreach ($this->route->getArguments() as $key => $value) {
            $this->setArgument($key, $value);
        }

        return $this;
    }
}
