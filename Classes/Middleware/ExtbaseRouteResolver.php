<?php
declare(strict_types = 1);

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

use Exception;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Log\LogManager;
use LMS\Routes\Extbase\RouteHandler;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use Psr\Http\Message\{ServerRequestInterface, ResponseInterface};
use Symfony\Component\Routing\Exception\{NoConfigurationException, ResourceNotFoundException};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class ExtbaseRouteResolver implements MiddlewareInterface
{
    /**
     * We log the issue for failing API requests.
     */
    private LoggerInterface $logger;

    /**
     * Resolves the actual request and bootstraps the process in Extbase context.
     */
    private RouteHandler $apiHandler;

    public function __construct(RouteHandler $handler, LogManager $logger)
    {
        $this->apiHandler = $handler;
        $this->logger = $logger->getLogger(__CLASS__);
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $request = $this->disableRouting($request);

        try {
            $this->apiHandler->handle($request);
        } catch (ResourceNotFoundException | NoConfigurationException $e) {
            // Usually thrown when requested api slug is not registered.
            // Like `/api/bla`
            return $handler->handle($request);
        } catch (PropagateResponseException $e) {
            // Might be thrown from custom user middlewares for redirects
            return $e->getResponse();
        } catch (Exception $e) {
            // Route is found, but something wrong while execution.
            // For example missing argument, or missing plugin name, or anything else
            $path = $request->getUri()->getPath();

            $this->logger->info($e->getMessage(), compact('path'));

            return $handler->handle($request);
        }

        return $this->apiHandler->generateResponse();
    }

    /**
     * We unset routing attribute to prevent it from next middleware redirects/resolves
     */
    private function disableRouting(ServerRequestInterface $request): ServerRequestInterface
    {
        $request = $request->withoutAttribute('routing');

        $GLOBALS['TYPO3_REQUEST'] = $request;

        return $request;
    }
}
