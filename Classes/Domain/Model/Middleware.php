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

use LMS\Facade\Assist\Str;
use Psr\Http\Message\ServerRequestInterface;
use LMS\Routes\Middleware\Api\AbstractRouteMiddleware as RouteMiddleware;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class Middleware
{
    /**
     * @var array
     */
    private $properties;

    /**
     * @var string
     */
    private $middlewareClassName;

    /**
     * @param string $route
     */
    public function __construct(string $route)
    {
        $this->initializeNamespace($route);
        $this->initializeProperties($route);
    }

    /**
     * @psalm-suppress InvalidStringClass
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @throws \Symfony\Component\Routing\Exception\MethodNotAllowedException
     */
    public function process(ServerRequestInterface $request): void
    {
        /** @var RouteMiddleware $routeMiddleware */
        $routeMiddleware = new $this->middlewareClassName($request, $this->properties);

        $routeMiddleware->process();
    }

    /**
     * @psalm-suppress MissingClosureReturnType
     * @psalm-suppress MissingClosureParamType
     *
     * @param string $route
     */
    private function initializeProperties(string $route): void
    {
        if ($length = strpos($route, ':')) {
            $this->properties = explode(',', Str::substr($route, ++$length));
        }

        $this->properties = collect($this->properties)->map(function ($property) {
            return is_numeric($property) ? (int)$property : $property;
        })->all();
    }

    /**
     * @param string $route
     */
    private function initializeNamespace(string $route): void
    {
        if ($length = strpos($route, ':')) {
            $this->middlewareClassName = substr($route, 0, $length);
            return;
        }

        $this->middlewareClassName = $route;
    }
}
