<?php
declare(strict_types = 1);
namespace LMS\Routes\Traits;

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

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait ServerRequest
{
    /**
     * Retrieve the current Server Request
     *
     * @api
     * @return \Psr\Http\Message\ServerRequestInterface
     */
    public static function getInstance(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }

    /**
     * Add new parameter values to the Server Request
     *
     * @api
     * @param string $name
     * @param string $value
     * @param string $namespace
     */
    public static function withParameter(string $name, string $value, string $namespace): void
    {
        $existingNamespaceValues = ServerRequest::getParametersFor($namespace);

        $GLOBALS['TYPO3_REQUEST'] = ServerRequest::getInstance()->withQueryParams([
            $namespace => array_merge([$name => $value], $existingNamespaceValues)
        ]);
    }

    /**
     * Retrieve the defined server request parameters for passed name
     *
     * @param  string $name
     * @return array
     */
    private static function getParametersFor(string $name): array
    {
        $allQueryParameters = ServerRequest::getInstance()->getQueryParams();

        return $allQueryParameters[$name] ?? [];
    }
}
