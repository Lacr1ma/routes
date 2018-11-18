<?php
declare(strict_types = 1);

namespace LMS\Routes\Support\Route;

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

use LMS\Routes\Support\ServerRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait Arguments
{
    /**
     * @var array
     */
    private $arguments = [];

    /**
     * Return the list of the arguments related to current Extbase request
     *
     * @api
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Set all the arguments from the coming route config. Or if the key is empty try to find in globals
     *
     * @param array $configuration
     */
    protected function initializeArguments(array $configuration): void
    {
        foreach ($this->removeMetadataFrom($configuration) as $name => $value) {
            $this->arguments[$name] = GeneralUtility::_GP($name) ?? $value;
        }

        $this->initializeBodyParameters();
    }

    /**
     * Check if there's any arguments passed inside request Body
     */
    private function initializeBodyParameters(): void
    {
        $bodyParameters = json_decode(ServerRequest::getInstance()->getBody()->__toString(), true);

        if (\is_array($bodyParameters)) {
            $this->arguments = array_merge($this->arguments, $bodyParameters);
        }
    }

    /**
     * Remove all the keys that are not related to extbase argument
     *
     * @param  array $configuration
     *
     * @return array
     */
    private function removeMetadataFrom(array $configuration): array
    {
        foreach ($configuration as $name => $value) {
            if (strpos($name, '_') === 0) {
                unset($configuration[$name]);
            }
        }

        return $configuration;
    }
}
