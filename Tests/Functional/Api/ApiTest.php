<?php

declare(strict_types = 1);

namespace LMS\Routes\Tests\Functional\Api;

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

use LMS\Routes\Tests\Functional\BaseTest;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class ApiTest extends BaseTest
{
    /**
     * @test
     */
    public function ping(): void
    {
        $response = $this->callEndpoint('ping');

        $this->assertStringContainsString('{"status":"pong"}', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function auth_middleware_can_pass(): void
    {
        $response = $this->callEndpoint('demo/middleware/auth-required');

        $this->assertStringContainsString('{"success":true}', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function admin_backend_user_required(): void
    {
        $response = $this->callEndpoint('demo/middleware', true, true, false);

        $this->assertStringContainsString('Admin user is required', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function group_middleware_can_pass(): void
    {
        $response = $this->callEndpoint('demo/middleware/in-group');

        $this->assertStringContainsString('{"success":true}', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function group_middleware_can_pass_if_admin(): void
    {
        $response = $this->callEndpoint('demo/middleware/in-group/admin');

        $this->assertStringContainsString('{"success":true}', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function group_middleware_can_block(): void
    {
        $response = $this->callEndpoint('demo/middleware/in-group-blocked');

        $this->assertStringContainsString('User does not belong to required group.', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function user_middleware_can_block(): void
    {
        $response = $this->callEndpoint('demo/middleware/own?user=999&title=demo');

        $this->assertStringContainsString('User is not a resource owner.', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function auth_middleware_requires_proper_csrf_token(): void
    {
        $response = $this->callEndpoint('demo/middleware/auth-required', false, false);

        $this->assertNotEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function throttle_middleware_blocks_dos(): void
    {
        foreach (range(0, 1) as $step) {
            $response = $this->callEndpoint('demo/throttle', false, false);

            $this->assertStringContainsString('{"success":true}', (string)$response->getBody());
        }

        $response = $this->callEndpoint('demo/throttle', false, false);

        $this->assertStringContainsString('Too Many Attempts.', (string)$response->getBody());
    }
}
