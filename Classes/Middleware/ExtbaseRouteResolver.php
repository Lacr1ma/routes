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

use LMS\Routes\Service\Router;
use LMS\Routes\Traits\ObjectManageable;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use TYPO3\CMS\Core\Http\NullResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Response;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class ExtbaseRouteResolver implements MiddlewareInterface
{
    use ObjectManageable, Router;

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
            $configuration = $this->getRouter()->match($request->getUri()->getPath());
        } catch (ResourceNotFoundException $e) {
            return $handler->handle($request);
        }

        [$controllerFQCN, $action] = explode('::', $configuration['_controller']);

        $extbaseRequest = new \TYPO3\CMS\Extbase\Mvc\Request();
        $extbaseRequest->setControllerObjectName($controllerFQCN);
        $extbaseRequest->setControllerActionName($action);

        foreach ($configuration as $key => $value) {
            if (strpos($key,'_') === 0) {
                continue;
            }

            $value = GeneralUtility::_GP($key) ?? $value;
            if (MathUtility::canBeInterpretedAsInteger($value)) {
                $value = (int) $value;
            }

            $extbaseRequest->setArgument($key, $value);
        }

        $extbaseRequest->setFormat($configuration['_format'] ?? 'html');

        $response = new Response();

        $controller = ObjectManageable::createObject($controllerFQCN);
        $controller->processRequest($extbaseRequest, $response);

        $response->send();
        return new NullResponse();
    }
}
