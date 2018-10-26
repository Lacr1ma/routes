<?php
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

use LMS\Routes\Domain\Model\YamlConfiguration;
use LMS\Routes\Traits\{ServerRequest, ObjectManageable};
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Core\Bootstrap;
use TYPO3\CMS\Core\Http\{HtmlResponse, JsonResponse};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class RouteHandler
{
    use ObjectManageable, ServerRequest;

    /**
     * @var string
     */
    private $output;

    /**
     * @param  YamlConfiguration $route
     */
    public function __construct(YamlConfiguration $route)
    {
        $this->initializeQueryParameters($route);

        $this->run([
            'vendorName'    => $route->getVendor(),
            'pluginName'    => $route->getPlugin(),
            'extensionName' => $route->getExtension()
        ]);
    }

    /**
     * @api
     * @return ResponseInterface
     */
    public function sendResponse(): ResponseInterface
    {
        $response = $this->createJsonResponse();
        if ($response === null ) {
            return new HtmlResponse($this->output);
        }

        return $response;
    }

    /**
     * @param \LMS\Routes\Domain\Model\YamlConfiguration $route
     */
    private function initializeQueryParameters(YamlConfiguration $route): void
    {
        $plugin = $route->getPluginNameSpace();

        ServerRequest::withParameter('action', $route->getAction(), $plugin);

        foreach ($route->getArguments() as $name => $value) {
            ServerRequest::withParameter($name, $value, $plugin);
        }
    }

    /**
     * @param array $config
     * @return void
     */
    private function run(array $config): void
    {
        /** @var \TYPO3\CMS\Extbase\Core\Bootstrap $bootstrap */
        $bootstrap = ObjectManageable::createObject(Bootstrap::class);

        $this->output = $bootstrap->run('', $config);
    }

    /**
     * @return JsonResponse|null
     */
    private function createJsonResponse(): ?JsonResponse
    {
        if ($GLOBALS['TSFE']->contentType !== 'application/json') {
            return null;
        }

        $this->output = json_decode($this->output, true);
        return new JsonResponse($this->output);
    }
}
