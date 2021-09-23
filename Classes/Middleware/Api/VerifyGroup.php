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

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @psalm-suppress PropertyNotSetInConstructor
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

        if (array_intersect($actual, $expected)) {
            return;
        }

        $this->deny('User does not belong to required group.', 403);
    }

    /**
     * Fetch all the groups current user belong to
     */
    private function getUserGroupsUserBelongTo(): array
    {
        $userGroups = $this->user->fetchUserProperty('usergroup');

        return GeneralUtility::intExplode(',', $userGroups, true);
    }

    /**
     * Retrieve group that guards the route
     */
    private function getRouteGroups(): array
    {
        if ($this->strStart(array_last($this->getProperties()), 'tx_')) {
            $accessGroups = array_slice($this->getProperties(), 0, -1);

            return array_merge($accessGroups, $this->getAdminGroups());
        }

        return $this->getProperties();
    }

    /**
     * Find all admin users related to current request
     */
    private function getAdminGroups(): array
    {
        $ext = $this->getAdminExtensionName();

        $adminGroups = $this->getSettings($ext)['middleware.']['admin.']['groups'];

        return GeneralUtility::intExplode(',', $adminGroups, true);
    }

    private function strStart(string $value, string $prefix): string
    {
        $quoted = preg_quote($prefix, '/');

        return $prefix.preg_replace('/^(?:'.$quoted.')+/u', '', $value);
    }
}
