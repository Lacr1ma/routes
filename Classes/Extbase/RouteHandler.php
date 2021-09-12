<?php
/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

declare(strict_types = 1);

namespace LMS\Routes\Extbase;

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

use TYPO3\CMS\Extbase\Core\Bootstrap;
use LMS\Facade\{Extbase\Response, ObjectManageable};
use LMS\Routes\Support\{ErrorBuilder, ServerRequest};
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Psr\Http\{Message\ResponseInterface, Message\ServerRequestInterface};
use LMS\Routes\{Domain\Model\Middleware, Domain\Model\Route, Service\RouteService};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class RouteHandler
{
    /**
     * Basically will contain the response text
     * which is generated after execution of the extbase action.
     */
    private string $output = '';

    /**
     * Contains the response status code.
     */
    private int $status = 200;

    /**
     * @throws \Symfony\Component\Routing\Exception\NoConfigurationException
     * @throws \Symfony\Component\Routing\Exception\ResourceNotFoundException
     */
    public function __construct(ServerRequestInterface $request)
    {
        $slug = $request->getUri()->getPath();

        try {
            $this->processRoute($request, $this->getRouteService()->findRouteFor($slug));
        } catch (MethodNotAllowedException $exception) {
            $this->output = ErrorBuilder::messageFor($exception);
            $this->status = (int)$exception->getCode() ?: 200;
        }
    }

    /**
     * Creates the PSR7 Response based on output that was retrieved from FrontendRequestHandler
     */
    public function generateResponse(): ResponseInterface
    {
        return Response::createWith($this->output, $this->status);
    }

    /**
     * @throws \Symfony\Component\Routing\Exception\MethodNotAllowedException
     */
    private function processRoute(ServerRequestInterface $request, Route $route): void
    {
        $GLOBALS['TSFE']->set_no_cache();
        $GLOBALS['TSFE']->determineId($request);
        $GLOBALS['TSFE']->getConfigArray();

        $this->processMiddleware(
            $request->withQueryParams($route->getArguments())
        );

        $this->createActionArgumentsFrom($route);

        $this->run([
            'vendorName' => $route->getVendor(),
            'pluginName' => $route->getPlugin(),
            'extensionName' => $route->getExtension()
        ]);
    }

    /**
     * Check whether a route has any middleware and run them if any.
     *
     * @throws \Symfony\Component\Routing\Exception\MethodNotAllowedException
     */
    private function processMiddleware(ServerRequestInterface $request): void
    {
        if ($GLOBALS['TYPO3_CONF_VARS']['FE']['disableRoutesMiddleware']) {
            return;
        }

        $slug = $request->getUri()->getPath();

        foreach ($this->getRouteService()->findMiddlewareFor($slug) as $middlewareRoute) {
            (new Middleware($middlewareRoute))->process($request);
        }
    }

    /**
     * Mainly parse the current server request and bind existing request parameters
     * as extbase action arguments.
     */
    private function createActionArgumentsFrom(Route $route): void
    {
        $plugin = $route->getPluginNamespace();

        ServerRequest::withParameter('action', $route->getAction(), $plugin);
        ServerRequest::withParameter('format', $route->getFormat(), $plugin);

        foreach ($route->getArguments() as $name => $value) {
            ServerRequest::withParameter($name, $value, $plugin);
        }

        if (ServerRequest::isUrlEncoded()) {
            foreach (ServerRequest::body() as $name => $value) {
                ServerRequest::withParameter($name, (string)$value, $plugin);
            }
        }
    }

    /**
     * Create the Route Service Instance.
     *
     * @psalm-suppress LessSpecificReturnStatement
     * @psalm-suppress MoreSpecificReturnType
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    private function getRouteService(): RouteService
    {
        return ObjectManageable::createObject(RouteService::class);
    }

    /**
     * Runs the Extbase Framework by resolving an appropriate Request Handler and passing control to it.
     *
     * @param array<string, string> $config
     */
    private function run(array $config): void
    {
        /** @var \TYPO3\CMS\Extbase\Core\Bootstrap $bootstrap */
        $bootstrap = ObjectManageable::createObject(Bootstrap::class);

        $this->output = $bootstrap->run('', $config);
    }
}
