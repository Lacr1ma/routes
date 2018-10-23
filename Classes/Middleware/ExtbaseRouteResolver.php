<?php
namespace LMS\Routes\Middleware;

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

use LMS\Routes\Domain\Model\YamlConfiguration;
use LMS\Routes\Extbase\RouteHandler;
use LMS\Routes\Service\Router;
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};
use Psr\Http\Message\{ServerRequestInterface, ResponseInterface};
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class ExtbaseRouteResolver implements MiddlewareInterface
{
    use Router;

    /**
     * @return void
     */
    public function __construct()
    {
        $GLOBALS['TSFE']->determineId();
        $GLOBALS['TSFE']->getConfigArray();
    }

    /**
     * @param  string $slug
     * @return YamlConfiguration|null
     */
    private function findRouteConfigurationFor(string $slug): ?YamlConfiguration
    {
        try {
            return new YamlConfiguration($this->getRouter()->match($slug));
        } catch (ResourceNotFoundException $e) {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $slug = $request->getUri()->getPath();

        $routeConfiguration = $this->findRouteConfigurationFor($slug);
        if ($routeConfiguration === null) {
            return $handler->handle($request);
        }

        (new RouteHandler($routeConfiguration, $request))
                ->sendResponse();

        exit();
    }
}
