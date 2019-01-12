<?php

namespace Common\Tests;

use Codeception\Util\HttpCode;

/**
 * Class CreateUserCest.
 */
class CreateUserCest
{
    /**
     * @param ApiTester $I
     */
    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    /**
     * @param ApiTester $I
     */
    public function createUserEmailValidationTest(ApiTester $I)
    {
        $I->sendPOST('/users');

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'email' => [
                'This value should not be null.',
                'This value should not be blank.',
            ],
        ]);

        $I->sendPOST('/users', [
            'email' => 'test@mail',
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'email' => [
                'This value is not a valid email address.',
            ],
        ]);

        $I->sendPOST('/users', [
            'email' => 'test_user_1@mail.ru',
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'email' => [
                'A user with this email address already exists.',
            ],
        ]);
    }

    /**
     * @param ApiTester $I
     */
    public function createUserPasswordValidationTest(ApiTester $I)
    {
        $I->sendPOST('/users', [
            'email' => 'test2@mail.ru',
            'password' => 'aa',
        ]);

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'password' => [
                'This value is too short. It should have 6 characters or more.',
            ],
        ]);
    }

    /**
     * @param ApiTester $I
     */
    public function createUserTest(ApiTester $I)
    {
        $I->sendPOST('/users', [
            'email' => 'test2@mail.ru',
            'password' => 'passw0rd',
        ]);

        $I->seeResponseCodeIs(HttpCode::CREATED);
    }
}
