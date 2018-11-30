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
                'This value should not be blank.',
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

        // Нужно ли? Если упадет другой тест, проверяющий результат - упадет
        // и этот, что может привести к путанице.
        $I->sendGET('/tasks?start=2018-11-27');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(HttpCode::OK);
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
            'start' => [
                'This value should not be null.',
                'This value should not be blank.',
            ],
            'end' => [
                'This value is not a valid date.',
            ],
        ]);

        $I->sendGET('/tasks?end=2018-12-12');
        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'start' => [
                'This value should not be null.',
                'This value should not be blank.',
            ],
        ]);

        $I->sendGET('/tasks?start=2018-11-27&end=2018-12-12');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(HttpCode::OK);
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
    public function createTaskTest(ApiTester $I)
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
    public function changeTaskStateTest(ApiTester $I)
    {
    }

    /**
     * @param ApiTester $I
     */
    public function changeTaskPositionTest(ApiTester $I)
    {
    }
}
