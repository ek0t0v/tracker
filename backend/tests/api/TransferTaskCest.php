<?php

namespace App\Tests\api;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class TransferTaskCest.
 */
class TransferTaskCest
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
    public function transferTaskForDateValidationTest(ApiTester $I)
    {
        $I->sendPOST('/tasks/1/transfer');

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'forDate' => [
                'This value should not be null.',
            ],
        ]);

        $I->sendPOST('/tasks/1/transfer', [
            'forDate' => '',
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'forDate' => [
                'This value should not be blank.',
            ],
        ]);

        $I->sendPOST('/tasks/1/transfer', [
            'forDate' => 'invalid date',
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'forDate' => [
                'This value is not a valid date.',
            ],
        ]);
    }

    /**
     * @param ApiTester $I
     */
    public function transferTaskToValidationTest(ApiTester $I)
    {
        $I->sendPOST('/tasks/1/transfer');

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'to' => [
                'This value should not be null.',
            ],
        ]);

        $I->sendPOST('/tasks/1/transfer', [
            'to' => '',
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'forDate' => [
                'This value should not be blank.',
            ],
        ]);

        $I->sendPOST('/tasks/1/transfer', [
            'to' => 'invalid date',
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'to' => [
                'This value is not a valid date.',
            ],
        ]);

        $I->sendPOST('/tasks/1/transfer', [
            'forDate' => '2018-12-01',
            'to' => '2018-12-01',
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'to' => [
                'This value should not be equal to forDate.',
            ],
        ]);
    }

    /**
     * @param ApiTester $I
     */
    public function transferTaskTest(ApiTester $I)
    {
        $I->sendPOST('/tasks/5/transfer', [
            'forDate' => '2018-12-01',
            'to' => '2018-12-02',
        ]);

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->assertEquals([
            'id' => 5,
            'name' => 'Single task 2',
            'state' => 'in_progress',
            'start' => '2018-12-01T00:00:00+00:00',
            'end' => null,
            'forDate' => '2018-12-01T00:00:00+00:00',
            'schedule' => null,
            'position' => null,
        ], json_decode($I->grabResponse(), true));
    }
}
