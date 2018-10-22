<?php
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait ObjectManageable
{
    /**
     * Returns a fresh or existing instance of the object specified by $objectName.
     *
     * @api
     * @param string $objectName The name of the object to return an instance of
     * @return object The object instance
     */
    public static function createObject(string $objectName)
    {
        return self::getObjectManager()->get($objectName);
    }

    /**
     * Returns a fresh or existing instance of the object specified by $objectName.
     *
     * @api
     * @return ObjectManager|object
     */
    public static function getObjectManager(): ObjectManager
    {
        return GeneralUtility::makeInstance(ObjectManager::class);
    }
}
