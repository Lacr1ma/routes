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

use DateTime;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class RateLimiter
{
    private FrontendInterface $cache;

    public function __construct(FrontendInterface $cache)
    {
        $this->cache = $cache;
    }

    public function availableAt(int $delayInMinutes): int
    {
        $now = new DateTime();

        $now->modify("+$delayInMinutes minutes");

        return $now->getTimestamp();
    }

    /**
     * Determine if the given key has been "accessed" too many times.
     */
    public function tooManyAttempts(string $key, int $maxAttempts): bool
    {
        if ($this->attempts($key) >= $maxAttempts) {
            return $this->cache->has($key . '_timer');
        }

        return false;
    }

    /**
     * Increment the counter for a given key for a given decay time.
     */
    public function hit(string $key, int $decayMinutes = 1): void
    {
        $this->cache->set(
            $key . '_timer', $this->availableAt($decayMinutes), [], $decayMinutes
        );

        $hits = (int)$this->cache->get($key) + 1;

        $this->cache->set($key, $hits, [], $decayMinutes);
    }

    /**
     * Get the number of attempts for the given key.
     */
    public function attempts(string $key): int
    {
        return (int)$this->cache->get($key) ?: 0;
    }
}
