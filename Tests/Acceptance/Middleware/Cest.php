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
     * This route requires group of UID 5 for access,
     * or admin group (1 | 2)
     * The user with session d108a7a49509ef42b5a54f94c6b6ea13 has group 1.
     * So we should give the access
     *
     * @param AcceptanceTester $I
     */
    public function group_middleware_can_pass_if_admin(AcceptanceTester $I)
    {
        $I = $this->setAccessHeadersFor($I);

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/in-group/admin', ['no_cache' => true]);

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['success' => true]);
    }

    /**
     * This route requires user that makes a request is the same as in param for access,
     * or user from admin list can also perform the request
     * The user with session d108a7a49509ef42b5a54f94c6b6ea13 has uid <1>
     * We pass <user> in params with <22>, but it's not an owner of the resource.
     * But our admin user has uid <1>, so we should give the access
     *
     * @param AcceptanceTester $I
     */
    public function user_middleware_can_pass_if_admin(AcceptanceTester $I)
    {
        $I = $this->setAccessHeadersFor($I);

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/user/admin?user=22&title=demo', ['no_cache' => true]);

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['user' => 22]);
    }

    /**
     * This route requires user that makes a request is the same as in param for access.
     * The user with session d108a7a49509ef42b5a54f94c6b6ea13 has uid <1>
     * We pass <user> in params with same identifier
     * So we should give the access
     *
     * @param AcceptanceTester $I
     */
    public function user_middleware_can_pass(AcceptanceTester $I)
    {
        $I = $this->setAccessHeadersFor($I);

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/own?user=1&title=demo', ['no_cache' => true]);

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['user' => 1]);
    }

    /**
     * This route requires user that makes a request is the same as in param for access.
     * The user with session d108a7a49509ef42b5a54f94c6b6ea13 has uid <1>
     * We pass <user> in params with identifier that equal <999>
     * So we should deny the request
     *
     * @param AcceptanceTester $I
     */
    public function user_middleware_can_block(AcceptanceTester $I)
    {
        $I = $this->setAccessHeadersFor($I);

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/own?user=999&title=demo', ['no_cache' => true]);

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseCodeIs(403);
        $I->seeResponseContainsJson(['error' => 'User is not a resource owner.']);
    }

    /**
     * This route requires group of UID 999 for access.
     * The user with session d108a7a49509ef42b5a54f94c6b6ea13 has group 1.
     * So we should deny the request
     *
     * @param AcceptanceTester $I
     */
    public function group_middleware_can_block(AcceptanceTester $I)
    {
        $I = $this->setAccessHeadersFor($I);

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/in-group-blocked', ['no_cache' => true]);

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseCodeIs(403);
        $I->seeResponseContainsJson(['error' => 'User does not belong to required group.']);
    }

    /**
     * This route requires group of UID 1 | 2 for access.
     * The user with session d108a7a49509ef42b5a54f94c6b6ea13 has group 1.
     * So we should give the access
     *
     * @param AcceptanceTester $I
     */
    public function group_middleware_can_pass(AcceptanceTester $I)
    {
        $I = $this->setAccessHeadersFor($I);

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/in-group', ['no_cache' => true]);

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['success' => true]);
    }

    /**
     * User can be tapped only 2 times.
     * On the third tap we should block the request
     *
     * @param AcceptanceTester $I
     */
    public function throttle_middleware_blocks_dos(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');

        foreach (range(0, 1) as $step) {
            $I->sendGET('https://routes.ddev.site/api/demo/throttle');
            $I->seeResponseContainsJson(['success' => true]);
        }

        $I->sendGET('https://routes.ddev.site/api/demo/throttle', ['no_cache' => true]);

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseCodeIs(429);
        $I->seeResponseContainsJson(['error' => 'Too Many Attempts.']);
    }

    /**
     * Route requires authenticated user, but the current session is anonymous.
     * The request should be blocked
     *
     * @param AcceptanceTester $I
     */
    public function auth_middleware_requires_user_to_be_logged_in(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/auth-required', ['no_cache' => true]);

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseCodeIs(401);
        $I->seeResponseContainsJson(['error' => 'Authentication required.']);
    }

    /**
     * Route requires authenticated user and we have one.
     * But user does not have a proper CSRF token
     * The request should be blocked
     *
     * @param AcceptanceTester $I
     */
    public function auth_middleware_requires_proper_csrf_token(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Cookie', 'fe_typo_user=d108a7a49509ef42b5a54f94c6b6ea13');

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/auth-required', ['no_cache' => true]);

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseCodeIs(401);
        $I->seeResponseContainsJson(['error' => 'CSRF token mismatch.']);
    }

    /**
     * Route requires authenticated user and we have one, csrf token is also correct.
     * So we should give the access
     *
     * @param AcceptanceTester $I
     */
    public function auth_middleware_can_pass(AcceptanceTester $I)
    {
        $I = $this->setAccessHeadersFor($I);

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/auth-required', ['no_cache' => true]);

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['success' => true]);
    }

    /**
     * The route requires ADMIN BE session. We have an active BE session
     * 5084d498cc8e34241c7936f5ba3307bc66e2 , but it's only editor, not admin.
     * The request should be blocked
     *
     * @param AcceptanceTester $I
     */
    public function admin_backend_user_required(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Cookie', 'fe_typo_user=d108a7a49509ef42b5a54f94c6b6ea13;be_typo_user=262d502d4c53a48013865ac497bcab32');
        $I->haveHttpHeader('X-CSRF-TOKEN', '9505d6de2825a41fd97699d1671b9ef1d2ed78d2');
        $I->sendGET('https://routes.ddev.site/api/demo/middleware', ['no_cache' => true]);

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseCodeIs(403);
        $I->seeResponseContainsJson(['error' => 'Admin user is required.']);
    }

//    /**
//     * The route requires ADMIN BE session. We have an active BE session
//     * 886526ce72b86870739cc41991144ec1 , and it's an admin.
//     * We should give the access.
//     *
//     * @param AcceptanceTester $I
//     */
//    public function active_backend_session_pass(AcceptanceTester $I)
//    {
//        $I = $this->setAccessHeadersFor($I);
//
//        $I->sendGET('https://routes.ddev.site/api/demo/middleware', ['no_cache' => true]);
//
//        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
//        $I->seeResponseContainsJson(['success' => true]);
//    }

    /**
     * The route requires authenticated user. But when we trigger
     * the route, we use HTML type, not JSON.
     * In this case we should redirect user to login page.
     *
     * @param AcceptanceTester $I
     */
    public function auth_middleware_redirects_when_not_logged_in_and_not_json_request(AcceptanceTester $I)
    {
        $I->sendGET('https://routes.ddev.site/api/demo/middleware', ['no_cache' => true]);

        $I->seeHttpHeader('Content-Type', 'text/html; charset=utf-8');
        $I->seeResponseContains('<title>Routes Demo: Auth</title>');
    }

    /**
     * @param AcceptanceTester $session
     * @return AcceptanceTester
     */
    private function setAccessHeadersFor(AcceptanceTester $session): AcceptanceTester
    {
        $session->haveHttpHeader('Accept', 'application/json');

        return $this->authenticate($session);
    }

    /**
     * @param AcceptanceTester $session
     * @return AcceptanceTester
     */
    private function authenticate(AcceptanceTester $session): AcceptanceTester
    {
        $sessionID = '9505d6de2825a41fd97699d1671b9ef1d2ed78d2';
        $encodedSessionID = 'd108a7a49509ef42b5a54f94c6b6ea13';
        $encodedBeSession = '5c745e2eef5a51357e7a5d3678c43023';

        $session->haveHttpHeader('X-CSRF-TOKEN', $sessionID);
        $session->haveHttpHeader('Cookie', 'fe_typo_user=' . $encodedSessionID . ';be_typo_user=' . $encodedBeSession . '');

        return $session;
    }
}
