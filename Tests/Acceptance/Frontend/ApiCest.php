<?php
declare(strict_types = 1);

namespace LMS\Routes\Tests\Acceptance\Frontend;

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
class ApiCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function demo_middleware(AcceptanceTester $I)
    {
        $I->sendGET('demo/middleware');
        $I->seeResponseContains('login_form');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function demo_list(AcceptanceTester $I)
    {
        $I->sendGET('demo/entity');
        $I->seeResponseContains('title');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function demo_show(AcceptanceTester $I)
    {
        $I->sendGET('demo/entity/1');
        $I->seeResponseContains('title');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function demo_create(AcceptanceTester $I)
    {
        $I->sendPOST('demo/entity', ['data' => ['title' => 'new']]);
        $I->seeResponseContainsJson(['success' => true]);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function demo_update(AcceptanceTester $I)
    {
        $I->sendPUT('demo/entity/1?data[title]=Title 1');
        $I->seeResponseContainsJson(['success' => true]);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function demo_delete(AcceptanceTester $I)
    {
        $I->sendDELETE('demo/entity/4');
        $I->seeResponseContains('success');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function HTTPS(AcceptanceTester $I)
    {
        $I->sendGET('demo/https/only');
        $I->seeResponseCodeIs(404);

        $I->sendGET('https://routes.ddev.site/api/demo/https/only');
        $I->seeResponseContainsJson(['success' => true]);
    }


    /**
     * @param AcceptanceTester $I
     */
    public function params_default_values_applied(AcceptanceTester $I)
    {
        $I->sendPOST('demo/test/with_params');

        $I->seeResponseContainsJson(['title' => 'default-title', 'description' => 'default-description']);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function requirements_applied(AcceptanceTester $I)
    {
        $I->sendGET('demo/entity/1');
        $I->seeResponseContainsJson(['uid' => 1, 'title' => 'Title 1']);

        $I->sendGET('demo/entity/1a');
        $I->seeResponseContains('<!DOCTYPE html>');
    }
}
