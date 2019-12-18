<?php
declare(strict_types = 1);

namespace LMS\Routes\Tests\Acceptance\Middleware;

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

use LMS\Routes\Tests\Acceptance\Support\AcceptanceTester;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class Cest
{
    /**
     * @param AcceptanceTester $I
     */
    public function throttle_middleware_blocks_dos(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');

        foreach (range(0, 1) as $step) {
            $I->sendGET('demo/throttle');
            $I->seeResponseContainsJson(['success' => true]);
        }

        $I->sendGET('demo/throttle');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['error' => 'Too Many Attempts.']);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function auth_middleware_requires_user_to_be_logged_in(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('demo/middleware');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['error' => 'Authentication required.']);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function auth_middleware_requires_proper_csrf_token(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Cookie', 'fe_typo_user=53574eb0bafe1c0a4d8a2cfc0cf726da');
        $I->sendGET('demo/middleware');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['error' => 'CSRF token mismatch.']);
    }

    /**
     * We have an editor session, but not admin
     *
     * @param AcceptanceTester $I
     */
    public function admin_backend_user_required(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Cookie', 'fe_typo_user=53574eb0bafe1c0a4d8a2cfc0cf726da;be_typo_user=ff83dfd81e20b34c27d3e97771a4525a');
        $I->haveHttpHeader('X-CSRF-TOKEN', '53574eb0bafe1c0a4d8a2cfc0cf726da');
        $I->sendGET('demo/middleware');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['error' => 'Admin user is required.']);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function active_backend_session_pass(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Cookie', 'fe_typo_user=53574eb0bafe1c0a4d8a2cfc0cf726da;be_typo_user=886526ce72b86870739cc41991144ec1');
        $I->haveHttpHeader('X-CSRF-TOKEN', '53574eb0bafe1c0a4d8a2cfc0cf726da');
        $I->sendGET('demo/middleware');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['success' => true]);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function auth_redirect_when_not_logged_in_and_not_json_request(AcceptanceTester $I)
    {
        $I->sendGET('demo/middleware');

        $I->seeHttpHeader('Content-Type', 'text/html; charset=utf-8');
        $I->seeResponseContains('<title>Auth</title>');
    }
}
