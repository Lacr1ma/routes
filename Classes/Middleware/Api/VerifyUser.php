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
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class VerifyUser extends AbstractRouteMiddleware
{
    /**
     * {@inheritDoc}
     */
    public function process(): void
    {
        if ($this->getUser() === $this->getRequestUserID()) {
            return;
        }
 
        $this->deny('User is not a resource owner.', 403);
    }

    /**
     * Retrieves the value of the action parameter that contains <user identifier>
     *
     * @return int
     */
    public function getRequestUserID(): int
    {
        return (int)$this->getQuery()[$this->getUserPropertyName()];
    }

    /**
     * Retrieve the name of the parameter that related to user field
     *
     * @return string
     */
    public function getUserPropertyName(): string
    {
        return (string)$this->getProperties()[0];
    }
}
