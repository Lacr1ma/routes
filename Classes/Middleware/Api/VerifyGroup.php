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
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class VerifyGroup extends AbstractRouteMiddleware
{
    /**
     * {@inheritDoc}
     */
    public function process(): void
    {
        $actual = $this->getUserGroupsUserBelongTo();
        $expected = $this->getRouteGroups();

        if ((bool)array_intersect($actual, $expected)) {
            return;
        }

        $this->deny('User does not belong to required group.', 403);
    }

    /**
     *  Fetch all the groups current user belong to
     *
     * @return array
     */
    public function getUserGroupsUserBelongTo(): array
    {
        return explode(',', $this->fetchUserProperty('usergroup'));
    }

    /**
     *  Retrieve group that guards the route
     *
     * @return array
     */
    protected function getRouteGroups(): array
    {
        return $this->getProperties();
    }
}
