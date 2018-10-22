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
use LMS\Routes\Service\Router;
use LMS\Routes\Traits\ObjectManageable;
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};
use Psr\Http\Message\{ServerRequestInterface, ResponseInterface};
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use TYPO3\CMS\Core\Http\NullResponse;
use TYPO3\CMS\Extbase\Mvc\Web\{Response as ExtbaseResponse, Request as ExtbaseRequest};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class ExtbaseRouteResolver implements MiddlewareInterface
{
    use ObjectManageable, Router;

    /**
     * @var YamlConfiguration
     */
    private $matchedRoute;

    /**
     * @return void
     */
    public function __construct()
    {
        $GLOBALS['TSFE']->determineId();
        $GLOBALS['TSFE']->getConfigArray();
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $config = $this->getRouter()->match($request->getUri()->getPath());
            $this->matchedRoute = new YamlConfiguration($config);
        } catch (ResourceNotFoundException $e) {
            return $handler->handle($request);
        }
\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->getRouter(), '');die();
        $response = new ExtbaseResponse();

        $controller = ObjectManageable::createObject($this->matchedRoute->getControllerFQCN());
        $controller->processRequest($this->createExtbaseRequest(), $response);

        $response->send();
        return new NullResponse();
    }

    /**
     * @return ExtbaseRequest
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidActionNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidArgumentNameException
     */
    private function createExtbaseRequest(): ExtbaseRequest
    {
        /** @var ExtbaseRequest$request */
        $request = ObjectManageable::createObject(ExtbaseRequest::class);
        $request->setControllerObjectName($this->matchedRoute->getControllerFQCN());
        $request->setControllerActionName($this->matchedRoute->getAction());
        $request->setFormat($this->matchedRoute->getFormat());

        foreach ($this->matchedRoute->getArguments() as $key => $value) {
            $request->setArgument($key, $value);
        }

        return $request;
    }
}
