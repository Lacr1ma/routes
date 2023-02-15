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
use LMS\Routes\Support\TypoScript;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Routing\Route as SymfonyRoute;
use Symfony\Component\Routing\Router as SymfonyRouter;
use Symfony\Component\Routing\Exception\NoConfigurationException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class RouteService
{
    private SymfonyRouter $router;

    public function __construct(Router $router)
    {
        $this->router = $router->getRouter();
    }

    /**
     * Attempt to retrieve the corresponding <YAML Configuration> for the current request path
     *
     * @throws ResourceNotFoundException
     * @throws MethodNotAllowedException
     * @throws NoConfigurationException
     */
    public function findRouteFor(ServerRequestInterface $request): Route
    {
        $slug = $request->getUri()->getPath();

        $routeSettings = $this->router->match($slug);

        $route = GeneralUtility::makeInstance(Route::class);
        $route->setConfiguration($routeSettings, $request);

        return $route;
    }

    /**
     * Attempt to retrieve all associated middleware by query
     *
     * @psalm-suppress PossiblyNullReference
     */
    public function findMiddlewareFor(ServerRequestInterface $request): array
    {
        $slug = $request->getUri()->getPath();
        $tsFull = $request->getAttribute('frontend.typoscript')->getSetupArray();

        $middleware = $this->getRouteFor($slug)->getOptions()['middleware'] ?? [];
        if (!is_array($middleware)) {
            return [];
        }

        $tsMiddlewares = $tsFull['plugin.']['tx_routes.']['settings.']['middleware.'] ?? [];

        foreach ($middleware as $key => $mwName) {
            $middleware[$key] = $this->getMiddlewareNamespaceByName($mwName, $tsMiddlewares) ?: $mwName;
        }

        return $this->array_flatten($middleware);
    }

    /**
     * Attempt to retrieve all associated middleware by query
     */
    private function getMiddlewareNamespaceByName(string $name, array $middlewarePool): array
    {
        if ($name === 'auth') {
            return [
                \LMS\Routes\Middleware\Api\Authenticate::class,
                \LMS\Routes\Middleware\Api\VerifyCsrfToken::class
            ];
        }

        $namespaces = $middlewarePool;

        return array_values($namespaces["$name."] ?? []);
    }

    private function getRouteFor(string $slug): ?SymfonyRoute
    {
        return $this->router->getRouteCollection()->get(
            $this->router->match($slug)['_route']
        );
    }

    private function array_flatten(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->array_flatten($value));
            } else {
                $result = array_merge($result, array($key => $value));
            }
        }

        return $result;
    }
}
