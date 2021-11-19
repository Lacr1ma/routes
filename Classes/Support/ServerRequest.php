<?php
declare(strict_types = 1);

namespace LMS\Routes\Support;

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
class ServerRequest
{
    /**
     * Retrieve the current server request.
     */
    public static function getInstance(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }

    /**
     * Check whether the current server request encodes data using <urlencoded>.
     */
    public static function isFormSubmit(): bool
    {
        $type = ServerRequest::getInstance()->getHeaderLine('content-type');

        return (bool)strpos($type, 'x-www-form-urlencoded');
    }

    /**
     * Check whether data can be converted to json
     */
    public static function isJson(string $data): bool
    {
        json_decode($data);

        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Adds a new query parameter to the current request.
     *
     * @param mixed $value
     */
    public static function withParameter(string $name, $value, string $namespace): void
    {
        $existingNamespaceValues = ServerRequest::getParametersFor($namespace);

        $GLOBALS['TYPO3_REQUEST'] = ServerRequest::getInstance()->withQueryParams([
            $namespace => array_merge([$name => $value], $existingNamespaceValues)
        ]);
    }

    /**
     * Retrieve the request data which was sent directly in body.
     * Typically, used in PATCH and PUT request types.
     *
     * @return array<string, mixed>
     */
    public static function formBody(): array
    {
        return (array)ServerRequest::getInstance()->getParsedBody();
    }

    /**
     * Check whether a current server request has a query parameter with a given name
     * and give it back.
     *
     * @return array<string, mixed>
     */
    private static function getParametersFor(string $name): array
    {
        $allQueryParameters = ServerRequest::getInstance()->getQueryParams();

        return $allQueryParameters[$name] ?? [];
    }
}
