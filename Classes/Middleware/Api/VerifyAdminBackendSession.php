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

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class VerifyAdminBackendSession extends AbstractRouteMiddleware
{
    /**
     * Ensure an activate backend session exist and user is actually admin
     *
     * {@inheritDoc}
     */
    public function process(): void
    {
        if (!$this->isAdmin()) {
            $this->deny('Admin user is required.', 403);
        }

        if ($this->getActiveSessionID() !== $this->getCookieSessionID()) {
            $this->deny('BE session mismatch', 403);
        }
    }

    /**
     * @return string
     */
    private function getCookieSessionID(): string
    {
        return $this->getRequest()->getCookieParams()['be_typo_user'] ?: '';
    }

    /**
     * @return string
     */
    private function getActiveSessionID(): string
    {
        return $this->backendUser()['ses_id'] ?: '';
    }

    /**
     * Tells us weather the associated with the current request BE User is an admin
     *
     * @return bool
     */
    private function isAdmin(): bool
    {
        return (bool)$this->backendUser()['admin'] ?: false;
    }

    /**
     * Retrieve the currently logged in BE User who is associated with the request
     *
     * @return array
     */
    private function backendUser(): array
    {
        return $GLOBALS['BE_USER']->user ?: [];
    }
}
