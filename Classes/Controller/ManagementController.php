<?php

/** @noinspection PhpUnused */

declare(strict_types = 1);

namespace LMS\Routes\Controller;

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

use LMS\Routes\Service\Router;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class ManagementController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    use Router;

    /**
     * Render existing routes
     */
    public function indexAction(): void
    {
        $this->view->assign('routes', $this->getRouter()->getRouteCollection());
    }

    /**
     * @psalm-suppress UndefinedMethod
     * @psalm-suppress PossiblyNullReference
     */
    public function showAction(string $name): void
    {
        $uri = $this->request->getUri();
        $host = "{$uri->getScheme()}://{$uri->getHost()}";

        $this->view->assign('route', $this->getRouter()->getRouteCollection()->get($name)->setHost($host));
    }
}
