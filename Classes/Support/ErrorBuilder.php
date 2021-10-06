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

use Exception;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class ErrorBuilder
{
    private Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function messageFor(Exception $exception): string
    {
        $message = $exception->getMessage();

        if ($message === '') {
            $message = basename(str_replace('\\', '/', get_class($exception)));
        }

        return $this->buildErrorWith($message);
    }

    private function buildErrorWith(string $message): string
    {
        if ($this->response->isJson()) {
            return (string)json_encode(['error' => $message]);
        }

        return $message;
    }
}
