<?php

namespace Tests\api\Task;

use Task\Doctrine\DBAL\Type\TaskRepeatTypeType;
use Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class CreateTaskCest.
 */
class CreateTaskCest
{
    /**
     * @param ApiTester $I
     *
     * @throws
     */
    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated($I->getAccessToken('test_user_1@mail.ru', 'passw0rd'));
    }

    /**
     * @param ApiTester $I
     */
    public function createTaskTest(ApiTester $I)
    {
        $I->sendPOST('/tasks', [
            'name' => 'Another task',
            'start' => '2018-11-01',
        ]);

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $responseAsArray = json_decode($I->grabResponse(), true);

        $I->assertEquals('Another task', $responseAsArray['name']);
        $I->assertEquals('2018-11-01T00:00:00+00:00', $responseAsArray['start']);

        $I->sendPOST('/tasks', [
            'name' => 'Another task',
            'start' => '2018-11-01',
            'end' => '2018-12-01',
            'repeatType' => TaskRepeatTypeType::CUSTOM,
            'repeatValue' => [1, 1, 0],
        ]);

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $responseAsArray = json_decode($I->grabResponse(), true);

        $I->assertEquals('Another task', $responseAsArray['name']);
        $I->assertEquals('2018-11-01T00:00:00+00:00', $responseAsArray['start']);
        $I->assertEquals('2018-12-01T00:00:00+00:00', $responseAsArray['end']);
        $I->assertEquals(TaskRepeatTypeType::CUSTOM, $responseAsArray['repeatType']);
        $I->assertEquals([1, 1, 0], $responseAsArray['repeatValue']);
    }
}
