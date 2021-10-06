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
     * The user with session edeb126f7862e85884fd1bfa7bcefaf3 has group 1.
     * So we should give the access
     */
    public function group_middleware_can_pass_if_admin(AcceptanceTester $I)
    {
        $I = $this->setAccessHeadersFor($I);

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/in-group/admin');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['success' => true]);
    }

    /**
     * This route requires user that makes a request is the same as in param for access,
     * or user from admin list can also perform the request
     * The user with session edeb126f7862e85884fd1bfa7bcefaf3 has uid <1>
     * We pass <user> in params with <22>, but it's not an owner of the resource.
     * But our admin user has uid <1>, so we should give the access
     */
    public function user_middleware_can_pass_if_admin(AcceptanceTester $I)
    {
        $I = $this->setAccessHeadersFor($I);

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/user/admin?user=22&title=demo');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['user' => 22]);
    }

    /**
     * This route requires user that makes a request is the same as in param for access.
     * The user with session edeb126f7862e85884fd1bfa7bcefaf3 has uid <1>
     * We pass <user> in params with same identifier
     * So we should give the access
     */
    public function user_middleware_can_pass(AcceptanceTester $I)
    {
        $I = $this->setAccessHeadersFor($I);

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/own?user=1&title=demo');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['user' => 1]);
    }

    /**
     * This route requires user that makes a request is the same as in param for access.
     * The user with session edeb126f7862e85884fd1bfa7bcefaf3 has uid <1>
     * We pass <user> in params with identifier that equal <999>
     * So we should deny the request
     */
    public function user_middleware_can_block(AcceptanceTester $I)
    {
        $I = $this->setAccessHeadersFor($I);

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/own?user=999&title=demo');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseCodeIs(403);
        $I->seeResponseContainsJson(['error' => 'User is not a resource owner.']);
    }

    /**
     * This route requires group of UID 999 for access.
     * The user with session edeb126f7862e85884fd1bfa7bcefaf3 has group 1.
     * So we should deny the request
     */
    public function group_middleware_can_block(AcceptanceTester $I)
    {
        $I = $this->setAccessHeadersFor($I);

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/in-group-blocked');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseCodeIs(403);
        $I->seeResponseContainsJson(['error' => 'User does not belong to required group.']);
    }

    /**
     * This route requires group of UID 1 | 2 for access.
     * The user with session edeb126f7862e85884fd1bfa7bcefaf3 has group 1.
     * So we should give the access
     */
    public function group_middleware_can_pass(AcceptanceTester $I)
    {
        $I = $this->setAccessHeadersFor($I);

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/in-group');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['success' => true]);
    }

    /**
     * User can be tapped only 2 times.
     * On the third tap we should block the request
     */
    public function throttle_middleware_blocks_dos(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');

        foreach (range(0, 1) as $step) {
            $I->sendGET('https://routes.ddev.site/api/demo/throttle');
            $I->seeResponseContainsJson(['success' => true]);
        }

        $I->sendGET('https://routes.ddev.site/api/demo/throttle');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseCodeIs(429);
        $I->seeResponseContainsJson(['error' => 'Too Many Attempts.']);
    }

    /**
     * Route requires authenticated user, but the current session is anonymous.
     * The request should be blocked
     */
    public function auth_middleware_requires_user_to_be_logged_in(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/auth-required');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseCodeIs(401);
        $I->seeResponseContainsJson(['error' => 'Authentication required.']);
    }

    /**
     * Route requires authenticated user and we have one.
     * But user does not have a proper CSRF token
     * The request should be blocked
     */
    public function auth_middleware_requires_proper_csrf_token(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Cookie', $this->getCookieValue());

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/auth-required');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseCodeIs(401);
        $I->seeResponseContainsJson(['error' => 'CSRF token mismatch.']);
    }

    /**
     * Route requires authenticated user and we have one, csrf token is also correct.
     * So we should give the access
     */
    public function auth_middleware_can_pass(AcceptanceTester $I)
    {
        $I = $this->setAccessHeadersFor($I);

        $I->sendGET('https://routes.ddev.site/api/demo/middleware/auth-required');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['success' => true]);
    }

    public function admin_backend_user_required(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Cookie', 'fe_typo_user=9f752511cb182cd1865a67cd72d7af2a;be_typo_user=xxx');
        $I->haveHttpHeader('X-CSRF-TOKEN', $this->getCsrfValue());
        $I->sendGET('https://routes.ddev.site/api/demo/middleware');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->dontSeeResponseCodeIs(200);
    }

    /**
     * The route requires authenticated user. But when we trigger
     * the route, we use HTML type, not JSON.
     * In this case we should redirect user to login page.
     */
    public function auth_middleware_redirects_when_not_logged_in_and_not_json_request(AcceptanceTester $I)
    {
        $I->verifyRedirect('https://routes.ddev.site/api/demo/middleware', '/login');
    }

    private function setAccessHeadersFor(AcceptanceTester $session): AcceptanceTester
    {
        $session->haveHttpHeader('Accept', 'application/json');

        return $this->authenticate($session);
    }

    private function authenticate(AcceptanceTester $session): AcceptanceTester
    {
        $session->haveHttpHeader('Cookie', $this->getCookieValue());
        $session->haveHttpHeader('X-CSRF-TOKEN', $this->getCsrfValue());

        return $session;
    }

    private function getCookieValue(): string
    {
        $FE = '67174c7c2403012f09475d25ad738300'; // From Browser
        $BE = '0b312e169ced8fc66f48a0e354793dec'; // From Browser

        return 'fe_typo_user=' . $FE . ';be_typo_user=' . $BE . '';
    }

    private function getCsrfValue(): string
    {
        return '828bc61287eaa44efba758f43f91cc217e36d334'; // From Browser
    }
}
