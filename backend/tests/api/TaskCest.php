<?php

namespace App\Tests;

use Codeception\Util\HttpCode;

/**
 * Class TaskCest.
 */
class TaskCest
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
     *
     * @throws
     */
    public function getTasksForTodayTest(ApiTester $I)
    {
        $I->sendGET('/tasks');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->assertCount(4, json_decode($I->grabResponse(), true));
    }

    /**
     * @param ApiTester $I
     */
    public function getTasksForDateTest(ApiTester $I)
    {
    }

    /**
     * @param ApiTester $I
     */
    public function getTasksForDateRangeTest(ApiTester $I)
    {
    }

    /**
     * @param ApiTester $I
     *
     * @throws
     */
    public function createTaskTest(ApiTester $I)
    {
        $I->sendPOST('/tasks', [
            'name' => 'task',
        ]);
        $I->seeResponseCodeIsSuccessful();
    }

    /**
     * @param ApiTester $I
     */
    public function editTaskTest(ApiTester $I)
    {
    }

    /**
     * @param ApiTester $I
     */
    public function transferTaskTest(ApiTester $I)
    {
    }

    /**
     * @param ApiTester $I
     */
    public function cancelTaskTest(ApiTester $I)
    {
    }

    /**
     * @param ApiTester $I
     */
    public function changeTaskStateTest(ApiTester $I)
    {
    }

    /**
     * @param ApiTester $I
     */
    public function deleteTaskTest(ApiTester $I)
    {
    }
}
