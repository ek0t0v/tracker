<?php

namespace Tests\api\Task;

use Codeception\Util\HttpCode;
use Task\Request\CreateTaskRequest;
use Task\Validator\Constraint\TaskEnd;
use Tests\ApiTester;

/**
 * Class CreateTaskValidationCest.
 *
 * @see CreateTaskRequest
 */
class CreateTaskValidationCest
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
    public function nameIsNull(ApiTester $I)
    {
        $I->sendPOST('/tasks');

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'name' => [
                'This value should not be null.',
            ],
        ]);
    }

    /**
     * @param ApiTester $I
     */
    public function nameIsNotString(ApiTester $I)
    {
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
    public function startIsNull(ApiTester $I)
    {
        $I->sendPOST('/tasks');

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'start' => [
                'This value should not be null.',
            ],
        ]);
    }

    /**
     * @param ApiTester $I
     */
    public function startIsBlank(ApiTester $I)
    {
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
    }

    /**
     * @param ApiTester $I
     */
    public function startIsNotDate(ApiTester $I)
    {
        $I->sendPOST('/tasks', [
            'start' => 'not date',
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
    public function endIsBlank(ApiTester $I)
    {
        $I->sendPOST('/tasks', [
            'end' => '',
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'end' => [
                'This value should not be blank.',
            ],
        ]);
    }

    /**
     * @param ApiTester $I
     */
    public function endIsNotDate(ApiTester $I)
    {
        $I->sendPOST('/tasks', [
            'end' => 'not date',
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
    public function endEqualsStart(ApiTester $I)
    {
        $I->sendPOST('/tasks', [
            'start' => '2019-01-02',
            'end' => '2019-01-02',
        ]);

        $taskEndConstraint = new TaskEnd();

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'end' => [
                $taskEndConstraint->message,
            ],
        ]);
    }

    /**
     * @param ApiTester $I
     */
    public function endLessThanStart(ApiTester $I)
    {
        $I->sendPOST('/tasks', [
            'start' => '2019-01-02',
            'end' => '2019-01-01',
        ]);

        $taskEndConstraint = new TaskEnd();

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'end' => [
                $taskEndConstraint->message,
            ],
        ]);
    }

    /**
     * @param ApiTester $I
     */
    public function repeatTypeIsNull(ApiTester $I)
    {
        $I->assertTrue(false, 'Not implemented!');
    }

    /**
     * @param ApiTester $I
     */
    public function repeatTypeIsBlank(ApiTester $I)
    {
        $I->assertTrue(false, 'Not implemented!');
    }

    /**
     * @param ApiTester $I
     */
    public function invalidRepeatType(ApiTester $I)
    {
        $I->assertTrue(false, 'Not implemented!');
    }

    /**
     * @param ApiTester $I
     */
    public function repeatValueIsNotArray(ApiTester $I)
    {
        $I->assertTrue(false, 'Not implemented!');
    }

    /**
     * @param ApiTester $I
     */
    public function invalidRepeatValue(ApiTester $I)
    {
        $I->assertTrue(false, 'Not implemented!');
    }
}
