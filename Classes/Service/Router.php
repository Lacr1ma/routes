<?php
declare(strict_types = 1);

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

use LMS\Routes\Loader\Yaml as YamlFileLoader;
use LMS\Facade\Extbase\TypoScriptConfiguration as TS;
use Symfony\Component\Routing\Router as SymfonyRouter;
use Symfony\Component\{HttpFoundation\Request, Routing\RequestContext};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait Router
{
    use YamlFileLoader;

    /**
     * @param  string $fileName
     *
     * @return \Symfony\Component\Routing\Router
     */
    public function getRouter(string $fileName = 'Routes'): SymfonyRouter
    {
        return new SymfonyRouter($this->getLoader(), $fileName, $this->getRouteOptions(), $this->getRequestContext());
    }

    /**
     * @return array
     */
    private function getRouteOptions(): array
    {
        $cacheDirectory = TS::getSettings('tx_routes')['cacheDirectoryPath'] ?: '';

        return $cacheDirectory ? ['cache_dir' => $cacheDirectory] : [];
    }

    /**
     * @return \Symfony\Component\Routing\RequestContext
     */
    private function getRequestContext(): RequestContext
    {
        return (new RequestContext())->fromRequest(Request::createFromGlobals());
    }
}
