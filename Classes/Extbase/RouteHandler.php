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

use LMS\Routes\Support\Response;
use TYPO3\CMS\Extbase\Core\Bootstrap;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use LMS\Routes\Support\{ErrorBuilder, ServerRequest};
use Symfony\Component\Routing\Exception\NoConfigurationException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Psr\Http\{Message\ResponseInterface, Message\ServerRequestInterface};
use LMS\Routes\{Domain\Model\Middleware, Domain\Model\Route, Service\RouteService};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class RouteHandler
{
    private Response $response;
    private ErrorBuilder $error;
    private Bootstrap $bootstrap;
    private RouteService $routeService;

    /**
     * Basically will contain the response text
     * which is generated after execution of the extbase action.
     */
    private string $output = '';

    /**
     * Contains the response status code.
     */
    private int $status = 200;

    public function __construct(RouteService $service, Bootstrap $bootstrap, Response $response, ErrorBuilder $error)
    {
        $this->error = $error;
        $this->response = $response;
        $this->bootstrap = $bootstrap;
        $this->routeService = $service;
    }

    /**
     * @throws NoConfigurationException
     * @throws ResourceNotFoundException
     * @throws PropagateResponseException
     */
    public function handle(ServerRequestInterface $request)
    {
        try {
            $this->processRoute($request, $this->routeService->findRouteFor($request));
        } catch (MethodNotAllowedException $exception) {
            $this->output = $this->error->messageFor($exception);
            $this->status = (int)$exception->getCode() ?: 200;
        }
    }

    /**
     * Creates the PSR7 Response based on output that was retrieved from FrontendRequestHandler
     */
    public function generateResponse(): ResponseInterface
    {
        return $this->response->createWith($this->output, $this->status);
    }

    /**
     * @throws MethodNotAllowedException
     * @throws PropagateResponseException
     */
    private function processRoute(ServerRequestInterface $request, Route $route): void
    {
        $GLOBALS['TSFE']->set_no_cache();
        $GLOBALS['TSFE']->determineId($request);

        $this->processMiddleware(
            $request->withQueryParams($route->getArguments())
        );

        $this->createActionArgumentsFrom($route);

        $this->bootstrap([
            'pluginName' => $route->getPlugin(),
            'vendorName' => $route->getController()->getVendor(),
            'extensionName' => $route->getController()->getExtension()
        ]);
    }

    /**
     * Check whether a route has any middleware and run them if any.
     *
     * @throws MethodNotAllowedException
     * @throws PropagateResponseException
     */
    private function processMiddleware(ServerRequestInterface $request): void
    {
        $debugMode = $GLOBALS['TYPO3_CONF_VARS']['FE']['disableRoutesMiddleware'] ?? false;

        if ($debugMode) {
            return;
        }

        foreach ($this->routeService->findMiddlewareFor($request) as $middlewareRoute) {
            $middleware = GeneralUtility::makeInstance(Middleware::class);
            $middleware->setRoute($middlewareRoute);

            $middleware->process($request);
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
            if (is_string($value) && ServerRequest::isJson($value)) {
                $value = json_decode($value, true);
            }

            ServerRequest::withParameter($name, $value, $plugin);
        }

        if (ServerRequest::isFormSubmit()) {
            foreach (ServerRequest::formBody() as $name => $value) {
                ServerRequest::withParameter($name, (string)$value, $plugin);
            }
        }
    }

    /**
     * Runs the Extbase Framework by resolving an appropriate Request Handler and passing control to it.
     *
     * @param array<string, string> $config
     */
    private function bootstrap(array $config): void
    {
        $this->output = $this->bootstrap->run('', $config, ServerRequest::getInstance());
    }
}
