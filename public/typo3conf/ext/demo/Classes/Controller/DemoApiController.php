<?php

declare(strict_types = 1);

namespace LMS\Demo\Controller;

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

use Psr\Http\Message\ResponseInterface;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class DemoApiController extends Base\ApiResourceController
{
    /**
     * {@inheritdoc}
     */
    protected function getRootName(): string
    {
        return 'entity';
    }

    /**
     * Created for VerifyUser Middleware.
     * We allow the access to this action only if user that makes a request is
     * the same as mentioned in params
     */
    public function checkOwnerAction(int $user, string $title): ResponseInterface
    {
        $this->view->assign('value', compact('user', 'title'));

        return $this->jsonResponse();
    }

    public function testAction(): ResponseInterface
    {
        $this->view->assign('value', ['success' => true]);

        return $this->jsonResponse();
    }

    public function testWithParamsAction(string $title, string $description): ResponseInterface
    {
        $this->view->assign('value', compact('title', 'description'));

        return $this->jsonResponse();
    }

    public function updateRawAction(int $uid): ResponseInterface
    {
         // $GLOBALS['TYPO3_REQUEST']->getParsedBody() as alternative

        return $this->jsonResponse(
            (string)json_encode(
                $this->request->getArguments()
            )
        );
    }
}
