<?php
declare(strict_types = 1);

namespace LMS\Routes\Middleware\Api;

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

use TYPO3\CMS\Core\Utility\HttpUtility;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use LMS\Facade\Extbase\{Response, User\StateContext, TypoScriptConfiguration};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class Authenticate
{
    /**
     * Redirect to login page if not authorized
     */
    public function process(): void
    {
        if (StateContext::isLoggedIn()) {
            return;
        }

        if (!Response::isJson()) {
            HttpUtility::redirect($this->loginPageUrl());
        }

        throw new MethodNotAllowedException([], 'Authentication required.');
    }

    /**
     * @return string
     */
    private function loginPageUrl(): string
    {
        $pid = (int)TypoScriptConfiguration::getSettings('tx_routes')['redirect.']['loginPage'];

        return "/index.php?id={$pid}";
    }
}
