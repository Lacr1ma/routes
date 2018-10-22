<?php
namespace LMS\Routes\Service;

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

use LMS\Routes\Loader\Yaml as YamlRouteDefinitionLoader;
use Symfony\Component\Routing\Router as SymfonyRouter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait Router
{
    use YamlRouteDefinitionLoader;

    /**
     * @api
     * @return SymfonyRouter
     */
    public function getRouter(): SymfonyRouter
    {
        $requestContext = (new RequestContext())->fromRequest(Request::createFromGlobals());

        return new SymfonyRouter($this->getLoader(),'Routes.yml', $this->getOptions(), $requestContext);
    }

    /**
     * @return array
     */
    private function getOptions(): array
    {
        return [
            'cache_dir' => self::getSettings()['cacheDirectoryPath']
        ];
    }
}
