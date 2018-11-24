<?php

namespace App\Tests;

use Codeception\Util\HttpCode;

/**
 * Class GetTasksCest.
 */
class GetTasksCest
{
    /**
     * @param ApiTester $I
     *
     * @throws
     */
    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated($I->getAccessToken());
    }

    /**
     * @param ApiTester $I
     */
    public function getTasksTest(ApiTester $I)
    {
        $I->sendGET('/tasks');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->assertCount(4, json_decode($I->grabResponse(), true));
    }
}
