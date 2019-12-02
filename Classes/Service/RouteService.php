<?php
declare(strict_types = 1);

namespace LMS\Routes\Service;

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

use LMS\Routes\Domain\Model\Route;
use LMS\Facade\Extbase\TypoScriptConfiguration;
use Symfony\Component\Routing\Route as SymfonyRoute;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class RouteService
{
    use Router;

    /**
     * Attempt to retrieve the corresponding <YAML Configuration> for the current request path
     *
     * @param string $slug
     *
     * @return \LMS\Routes\Domain\Model\Route
     * @throws \Symfony\Component\Routing\Exception\ResourceNotFoundException
     * @throws \Symfony\Component\Routing\Exception\MethodNotAllowedException
     * @throws \Symfony\Component\Routing\Exception\NoConfigurationException
     */
    public function findRouteFor(string $slug): Route
    {
        $routeSettings = $this->getRouter()->match($slug);

        return new Route($routeSettings);
    }

    /**
     * Attempt to retrieve all associated middleware by query
     *
     * @param string $slug
     *
     * @return array
     */
    public function findMiddlewareFor(string $slug): array
    {
        return collect($this->getRouteFor($slug)->getOptions()['middleware'])
            ->map(function (string $middleware) {
                return $this->getMiddlewareNamespaceByName($middleware) ?: $middleware;
            })
            ->flatten()
            ->all();
    }

    /**
     * Attempt to retrieve all associated middleware by query
     *
     * @param string $name
     *
     * @return array
     */
    private function getMiddlewareNamespaceByName(string $name): array
    {
        $namespaces = TypoScriptConfiguration::getSettings('tx_routes')['middleware.'];

        return array_values($namespaces["$name."] ?? []);
    }

    /**
     * Get Route settings by it's slug
     *
     * @param string $slug
     *
     * @return \Symfony\Component\Routing\Route|null
     */
    private function getRouteFor(string $slug): ?SymfonyRoute
    {
        return $this->getRouter()->getRouteCollection()->get(
            $this->getRouter()->match($slug)['_route']
        );
    }
}
