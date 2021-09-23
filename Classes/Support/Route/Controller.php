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

use LMS\Routes\Support\Request;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class Controller
{
    private Request $request;
    private string $controllerFQCN;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function initializeController(string $controllerFQCN): void
    {
        $this->controllerFQCN = $controllerFQCN;
    }

    public function getController(): string
    {
        return $this->request->getControllerNameBasedOn($this->controllerFQCN);
    }

    public function getExtension(): string
    {
        return $this->request->getExtensionNameBasedOn($this->controllerFQCN);
    }

    public function getVendor(): string
    {
        return $this->request->getVendorNameBasedOn($this->controllerFQCN);
    }
}
