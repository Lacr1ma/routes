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

use LMS\Routes\Extbase\RouteHandler;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\{ServerRequestInterface, ResponseInterface};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class ExtbaseRouteResolver implements \Psr\Http\Server\MiddlewareInterface
{
    /**
     * We need to initialize some of the TypoScriptFrontendController properties before working on a request
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
            $extbaseRouteHandler = new RouteHandler($request);
        } catch (\Exception $e) {
            return $handler->handle($request);
        }

        return $extbaseRouteHandler->generateResponse();
    }
}
