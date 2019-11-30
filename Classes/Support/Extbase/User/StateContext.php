<?php
declare(strict_types = 1);

namespace LMS\Routes\Support\Extbase\User;

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
use TYPO3\CMS\Core\Context\{Context, Exception\AspectNotFoundException};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class StateContext
{
    /**
     * Determine whether user is logged in
     *
     * @return bool
     */
    public static function isLoggedIn(): bool
    {
        try {
            return (bool)self::getTypo3Context()->getPropertyFromAspect('frontend.user', 'isLoggedIn');
        } catch (AspectNotFoundException $e) {
            return false;
        }
    }

    /**
     * Just syntax sugar
     *
     * @return bool
     */
    public static function isNotLoggedIn(): bool
    {
        return !self::isLoggedIn();
    }

    /**
     * Retrieve the Context Instance
     *
     * @return \TYPO3\CMS\Core\Context\Context
     */
    public static function getTypo3Context(): Context
    {
        return GeneralUtility::makeInstance(Context::class);
    }
}
