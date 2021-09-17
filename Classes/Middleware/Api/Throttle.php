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

use LMS\Facade\Traits\Throttler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class Throttle extends AbstractRouteMiddleware
{
    /**
     * {@inheritDoc}
     */
    public function process(): void
    {
        $this->throttler()->incrementAttempts();

        if ($this->throttler()->hasTooManyAttempts()) {
            $this->deny('Too Many Attempts.', 429);
        }
    }

    protected function throttler(): Throttler
    {
        $max = (int)$this->getProperties()[0];
        $decay = (int)$this->getProperties()[1];

        return GeneralUtility::makeInstance(Throttler::class, $max, $decay);
    }
}
