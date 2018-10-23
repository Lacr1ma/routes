<?php
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

use LMS\Routes\Domain\Model\RouteRequest;
use LMS\Routes\Domain\Model\YamlConfiguration;
use LMS\Routes\Traits\ObjectManageable;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ControllerInterface;
use TYPO3\CMS\Extbase\Mvc\Exception\{InvalidActionNameException,
    InvalidArgumentNameException,
    NoSuchControllerException,
    UnsupportedRequestTypeException};
use TYPO3\CMS\Extbase\Mvc\Web\Response as ExtbaseResponse;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class RouteHandler
{
    use ObjectManageable;

    /**
     * @var ExtbaseResponse
     */
    private $response;

    /**
     * @param  YamlConfiguration $routeConfiguration
     * @return void
     */
    public function __construct(YamlConfiguration $routeConfiguration, ServerRequestInterface $serverRequest)
    {
        $this->response = new ExtbaseResponse();

        try {
            $request = new RouteRequest($routeConfiguration, $serverRequest);
        } catch (InvalidArgumentNameException | InvalidActionNameException $e) {
            return;
        }

        try {
            $this->createControllerFrom($request)
                        ->processRequest($request, $this->response);
        } catch (UnsupportedRequestTypeException | NoSuchControllerException $e) {
            return;
        }
    }

    /**
     * @return void
     */
    public function sendResponse(): void
    {
        $this->response->send();
    }

    /**
     * @param  RouteRequest $request
     * @return ControllerInterface
     * @throws NoSuchControllerException
     */
    private function createControllerFrom(RouteRequest $request): ControllerInterface
    {
        return ObjectManageable::createObject($request->getControllerObjectName());
    }
}
