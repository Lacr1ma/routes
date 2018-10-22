<?php
namespace LMS\Routes\Domain\Model;

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

use TYPO3\CMS\Core\Utility\{MathUtility, GeneralUtility};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class YamlConfiguration
{
    /**
     * @var string
     */
    private $controllerFQCN;

    /**
     * @var string
     */
    private $action;

    /**
     * @var string
     */
    private $format;

    /**
     * @var array
     */
    private $arguments = [];

    /**
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        [$this->controllerFQCN, $this->action] = explode('::', $configuration['_controller']);
        $this->format = $configuration['_format'] ?? 'html';

        $this->initializeArguments($configuration);
    }

    /**
     * @param array $configuration
     */
    private function initializeArguments(array $configuration): void
    {
        foreach ($configuration as $key => $value) {
            if (strpos($key,'_') === 0) {
                continue;
            }

            $value = GeneralUtility::_GP($key) ?? $value;
            if (MathUtility::canBeInterpretedAsInteger($value)) {
                $value = (int) $value;
            }

            $this->arguments[$key] = $value;
        }
    }

    /**
     * @return string
     */
    public function getControllerFQCN(): string
    {
        return $this->controllerFQCN;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
