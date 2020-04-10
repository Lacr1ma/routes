<?php
declare(strict_types = 1);

namespace LMS\Routes\Tests\Acceptance\Requirements;

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
     * Since v10 it's probably should be deleted.
     *
     * @param AcceptanceTester $I
     */
    public function custom_format_applied(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendPOST('https://routes.ddev.site/api/demo/custom/view');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
//        $I->seeResponseContainsJson(['ok' => true]);
        $I->seeResponseContainsJson(['success' => true]);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function https_protocol_requirement_applied(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('https://routes.ddev.site/api/demo/https/only');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['success' => true]);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function https_protocol_requirement_required(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('http://routes.ddev.site/api/demo/https/only');

        $I->seeResponseCodeIs(200);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function host_requirement_applied(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('https://routes.ddev.site/api/demo/custom/host');

        $I->seeResponseCodeIs(404);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function proper_host_requirement_applied(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('https://m.routes.ddev.site/api/demo/custom/host');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['success' => true]);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function host_requirement_required(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('https://routes.ddev.site/api/demo/custom/host');

        $I->seeResponseCodeIs(404);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function params_default_values_applied(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('https://routes.ddev.site/api/demo/test/with_params');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['title' => 'default-title', 'description' => 'default-description']);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function requirement_integer_only_required(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('https://routes.ddev.site/api/demo/photos/1a');

        $I->seeResponseCodeIs(404);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function requirement_integer_only_applied(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('https://routes.ddev.site/api/demo/photos/1');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['uid' => 1, 'title' => 'Title 1']);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function response_format_is_html_when_accept_header_missing(AcceptanceTester $I)
    {
        $I->sendGET('https://routes.ddev.site/api/demo/photos');

        $I->seeHttpHeader('Content-Type', 'text/html; charset=utf-8');
    }
}
