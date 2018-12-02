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
        $I->amBearerAuthenticated($I->getAccessToken('test_user_1@mail.ru', 'passw0rd'));
    }

    /**
     * @param ApiTester $I
     */
    public function getTasksStartDateValidationTest(ApiTester $I)
    {
        $I->sendGET('/tasks');
        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'start' => [
                'This value should not be null.',
            ],
        ]);

        $I->sendGET('/tasks?start=invalid_date');
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
    public function getTasksEndDateValidationTest(ApiTester $I)
    {
        $I->sendGET('/tasks?end=invalid_date');
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
    public function getTasksByDateTest(ApiTester $I)
    {
        $I->sendGET('/tasks?start=2018-10-29'); // Если взять 2018-12-02, то там должна быть только одна задача - "Чтение".
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $responseAsArray = json_decode($I->grabResponse(), true);

        $I->assertArrayHasKey('items', $responseAsArray);
        $I->assertCount(1, $responseAsArray['items']);
    }

    /**
     * @param ApiTester $I
     */
    public function getTasksByDateRangeTest(ApiTester $I)
    {
        $I->sendGET('/tasks?start=2018-11-01&end=2018-12-01');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
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
}
