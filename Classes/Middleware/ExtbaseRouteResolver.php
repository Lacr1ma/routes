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

use LMS\Facade\Logger\Logger;
use LMS\Routes\Extbase\RouteHandler;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\{ServerRequestInterface, ResponseInterface};
use Symfony\Component\Routing\Exception\{NoConfigurationException, ResourceNotFoundException};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class ExtbaseRouteResolver implements \Psr\Http\Server\MiddlewareInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $GLOBALS['TYPO3_REQUEST'] = $request->withAttribute('routing', null);

        try {
            $extbaseRouteHandler = new RouteHandler($request);
        } catch (ResourceNotFoundException | NoConfigurationException $e) {
            return $handler->handle($request);
        } catch (\Exception $e) {
            $this->log($e->getMessage(), $request->getUri()->getPath());

            return $handler->handle($request);
        }

        return $extbaseRouteHandler->generateResponse();
    }

    /**
     * Write error message to log file
     *
     * @param string $error
     * @param string $path
     */
    private function log(string $error, string $path): void
    {
        Logger::get(__CLASS__)->error($error, compact('path'));
    }
}
