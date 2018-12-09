<?php

namespace App\Tests\api;

use App\Tests\ApiTester;
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
    public function createTaskNameValidationTest(ApiTester $I)
    {
        $I->sendPOST('/tasks');

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'name' => [
                'This value should not be null.',
            ],
        ]);

        $I->sendPOST('/tasks', [
            'name' => false,
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'name' => [
                'This value should be of type string.',
            ],
        ]);
    }

    /**
     * @param ApiTester $I
     */
    public function createTaskStartValidationTest(ApiTester $I)
    {
        $I->sendPOST('/tasks');

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'start' => [
                'This value should not be null.',
            ],
        ]);

        $I->sendPOST('/tasks', [
            'start' => '',
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'start' => [
                'This value should not be blank.',
            ],
        ]);

        $I->sendPOST('/tasks', [
            'start' => false,
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'start' => [
                'This value is not a valid date.',
            ],
        ]);
    }

    /**
     * @param ApiTester $I
     */
    public function createTaskEndValidationTest(ApiTester $I)
    {
        $I->sendPOST('/tasks', [
            'end' => '',
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'start' => [
                'This value should not be blank.',
            ],
        ]);

        $I->sendPOST('/tasks', [
            'end' => false,
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'end' => [
                'This value is not a valid date.',
            ],
        ]);
    }

    /**
     * @param ApiTester $I
     */
    public function createTaskScheduleValidationTest(ApiTester $I)
    {
        $I->sendPOST('/tasks', [
            'schedule' => false,
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'schedule' => [
                'This value should be of type array.',
            ],
        ]);

        $I->sendPOST('/tasks', [
            'schedule' => [],
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'schedule' => [
                'Invalid schedule.',
            ],
        ]);

        $I->sendPOST('/tasks', [
            'schedule' => [0, 0, 0, 0],
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'schedule' => [
                'Invalid schedule.',
            ],
        ]);
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
            'schedule' => [1, 1, 0],
        ]);

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $responseAsArray = json_decode($I->grabResponse(), true);

        $I->assertEquals('Another task', $responseAsArray['name']);
        $I->assertEquals('2018-11-01T00:00:00+00:00', $responseAsArray['start']);
        $I->assertEquals('2018-12-01T00:00:00+00:00', $responseAsArray['end']);
        $I->assertEquals([1, 1, 0], $responseAsArray['schedule']);
    }
}
