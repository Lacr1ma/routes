<?php
declare(strict_types = 1);
namespace LMS\Routes\Support\Extbase;

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
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher as ExtbaseDispatcher;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait Dispatcher
{
    /**
     * Dispatches a signal by calling the registered Slot methods
     *
     * @api
     * @param  string $class
     * @param  string $signalName
     * @param  array  $arguments
     * @return mixed
     */
    protected function emit(string $class, string $signalName, array $arguments = [])
    {
        try {
            return $this->getDispatcherInstance()->dispatch($class, $signalName, $arguments);
        } catch (InvalidSlotReturnException | InvalidSlotException $e) {
            return false;
        }
    }

    /**
     * Create the Extbase Dispatcher Instance
     *
     * @api
     * @return \TYPO3\CMS\Extbase\SignalSlot\Dispatcher|Object
     */
    protected function getDispatcherInstance(): ExtbaseDispatcher
    {
        return GeneralUtility::makeInstance(ExtbaseDispatcher::class);
    }
}
