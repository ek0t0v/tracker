<?php

namespace Tests\api\Task;

use Tests\ApiTester;
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
    public function transferTaskToValidationTest(ApiTester $I)
    {
        $I->sendPUT('/tasks/1/2018-11-01/transfer');

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'to' => [
                'This value should not be null.',
                'This value should not be blank.',
            ],
        ]);

        $I->sendPUT('/tasks/1/2018-11-01/transfer', [
            'to' => '',
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'to' => [
                'This value should not be blank.',
            ],
        ]);

        $I->sendPUT('/tasks/1/2018-11-01/transfer', [
            'to' => 'invalid date',
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'to' => [
                'This value is not a valid date.',
            ],
        ]);

        $I->sendPUT('/tasks/1/2018-11-01/transfer', [
            'to' => '2018-12-01',
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'to' => [
                'Cannot set past date.',
            ],
        ]);
    }

    /**
     * @param ApiTester $I
     */
    public function transferTaskTest(ApiTester $I)
    {
        $to = new \DateTime();

        $I->sendPUT('/tasks/5/2018-12-01/transfer', [
            'to' => $to->format('Y-m-d'),
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
            'transfers' => [],
            'isTransferred' => false,
            'repeatType' => null,
            'repeatValue' => null,
            'position' => null,
        ], json_decode($I->grabResponse(), true));
    }
}
