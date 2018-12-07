<?php

namespace App\Tests;

use Codeception\Example;
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

        $I->sendGET('/tasks?start=');

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'start' => [
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
    }

    /**
     * @param ApiTester $I
     */
    public function getTasksEndDateValidationTest(ApiTester $I)
    {
        $I->sendGET('/tasks?end=');

        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'end' => [
                'This value should not be blank.',
            ],
        ]);

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
    public function getTasksByDateRangeTest(ApiTester $I)
    {
        $I->sendGET('/tasks?start=2018-11-01&end=2018-12-01');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }

    /**
     * @param ApiTester $I
     * @param Example   $example
     *
     * @dataProvider getTasksByDateDataProvider
     */
    public function getTasksByDateTest(ApiTester $I, Example $example)
    {
        $I->sendGET('/tasks?start='.$example['date']);

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->assertEquals($example['response'], json_decode($I->grabResponse(), true));
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
    }

    /**
     * @return array
     */
    protected function getTasksByDateDataProvider(): array
    {
        return [
            '2018-10-29' => [
                'date' => '2018-10-29',
                'response' => [
                    'items' => [
                        [
                            'id' => 2,
                            'name' => 'Work',
                            'state' => 'in_progress',
                            'start' => '2018-10-29T00:00:00+00:00',
                            'end' => null,
                            'forDate' => '2018-10-29T00:00:00+00:00',
                            'schedule' => [1, 1, 1, 1, 1, 0, 0],
                            'position' => null,
                        ],
                    ],
                ],
            ],
            '2018-12-02' => [
                'date' => '2018-12-02',
                'response' => [
                    'items' => [
                        [
                            'id' => 3,
                            'name' => 'Reading',
                            'state' => 'in_progress',
                            'start' => '2018-11-19T00:00:00+00:00',
                            'end' => null,
                            'forDate' => '2018-12-02T00:00:00+00:00',
                            'schedule' => [1],
                            'position' => null,
                        ],
                    ],
                ],
            ],
            '2018-11-03' => [
                'date' => '2018-11-03',
                'response' => [
                    'items' => [],
                ],
            ],
            '2018-11-04' => [
                'date' => '2018-11-04',
                'response' => [
                    'items' => [
                        [
                            'id' => 1,
                            'name' => 'Exercises',
                            'state' => 'in_progress',
                            'start' => '2018-11-01T00:00:00+00:00',
                            'end' => '2018-12-01T00:00:00+00:00',
                            'forDate' => '2018-11-03T00:00:00+00:00',
                            'schedule' => [1, 1, 1, 0],
                            'position' => null,
                        ],
                    ],
                ],
            ],
            '2018-11-06' => [
                'date' => '2018-11-06',
                'response' => [
                    'items' => [
                        [
                            'id' => 2,
                            'name' => 'Work',
                            'state' => 'in_progress',
                            'start' => '2018-10-29T00:00:00+00:00',
                            'end' => null,
                            'forDate' => '2018-11-06T00:00:00+00:00',
                            'schedule' => [1, 1, 1, 1, 1, 0, 0],
                            'position' => null,
                        ],
                    ],
                ],
            ],
            '2018-11-08' => [
                'date' => '2018-11-08',
                'response' => [
                    'items' => [
                        [
                            'id' => 4,
                            'name' => 'Single task 1',
                            'state' => 'in_progress',
                            'start' => '2018-11-07T00:00:00+00:00',
                            'end' => null,
                            'forDate' => '2018-11-07T00:00:00+00:00',
                            'schedule' => null,
                            'position' => null,
                        ],
                        [
                            'id' => 2,
                            'name' => 'Work',
                            'state' => 'in_progress',
                            'start' => '2018-10-29T00:00:00+00:00',
                            'end' => null,
                            'forDate' => '2018-11-08T00:00:00+00:00',
                            'schedule' => [1, 1, 1, 1, 1, 0, 0],
                            'position' => null,
                        ],
                    ],
                ],
            ],
            '2018-11-09' => [
                'date' => '2018-11-09',
                'response' => [
                    'items' => [
                        [
                            'id' => 2,
                            'name' => 'Work',
                            'state' => 'in_progress',
                            'start' => '2018-10-29T00:00:00+00:00',
                            'end' => null,
                            'forDate' => '2018-11-09T00:00:00+00:00',
                            'schedule' => [1, 1, 1, 1, 1, 0, 0],
                            'position' => null,
                        ],
                        [
                            'id' => 1,
                            'name' => 'Exercises',
                            'state' => 'in_progress',
                            'start' => '2018-11-01T00:00:00+00:00',
                            'end' => '2018-12-01T00:00:00+00:00',
                            'forDate' => '2018-11-09T00:00:00+00:00',
                            'schedule' => [1, 1, 1, 0],
                            'position' => null,
                        ],
                        [
                            'id' => 1,
                            'name' => 'Exercises',
                            'state' => 'in_progress',
                            'start' => '2018-11-01T00:00:00+00:00',
                            'end' => '2018-12-01T00:00:00+00:00',
                            'forDate' => '2018-11-06T00:00:00+00:00',
                            'schedule' => [1, 1, 1, 0],
                            'position' => null,
                        ],
                    ],
                ],
            ],
            '2018-11-22' => [
                'date' => '2018-11-22',
                'response' => [
                    'items' => [
                        [
                            'id' => 2,
                            'name' => 'Work',
                            'state' => 'in_progress',
                            'start' => '2018-10-29T00:00:00+00:00',
                            'end' => null,
                            'forDate' => '2018-11-22T00:00:00+00:00',
                            'schedule' => [1, 1, 1, 1, 1, 0, 0],
                            'position' => null,
                        ],
                        [
                            'id' => 1,
                            'name' => 'Exercises',
                            'state' => 'in_progress',
                            'start' => '2018-11-01T00:00:00+00:00',
                            'end' => '2018-12-01T00:00:00+00:00',
                            'forDate' => '2018-11-22T00:00:00+00:00',
                            'schedule' => [1, 1, 1, 0],
                            'position' => null,
                        ],
                    ],
                ],
            ],
            '2018-11-23' => [
                'date' => '2018-11-23',
                'response' => [
                    'items' => [
                        [
                            'id' => 3,
                            'name' => 'Reading',
                            'state' => 'in_progress',
                            'start' => '2018-11-19T00:00:00+00:00',
                            'end' => null,
                            'forDate' => '2018-11-23T00:00:00+00:00',
                            'schedule' => [1],
                            'position' => null,
                        ],
                        [
                            'id' => 3,
                            'name' => 'Reading',
                            'state' => 'in_progress',
                            'start' => '2018-11-19T00:00:00+00:00',
                            'end' => null,
                            'forDate' => '2018-11-22T00:00:00+00:00',
                            'schedule' => [1],
                            'position' => null,
                        ],
                        [
                            'id' => 2,
                            'name' => 'Work',
                            'state' => 'in_progress',
                            'start' => '2018-10-29T00:00:00+00:00',
                            'end' => null,
                            'forDate' => '2018-11-23T00:00:00+00:00',
                            'schedule' => [1, 1, 1, 1, 1, 0, 0],
                            'position' => null,
                        ],
                        [
                            'id' => 1,
                            'name' => 'Exercises',
                            'state' => 'in_progress',
                            'start' => '2018-11-01T00:00:00+00:00',
                            'end' => '2018-12-01T00:00:00+00:00',
                            'forDate' => '2018-11-23T00:00:00+00:00',
                            'schedule' => [1, 1, 1, 0],
                            'position' => null,
                        ],
                    ],
                ],
            ],
            '2018-12-07' => [
                'date' => '2018-12-07',
                'response' => [
                    'items' => [
                        [
                            'id' => 3,
                            'name' => 'Reading',
                            'state' => 'in_progress',
                            'start' => '2018-11-19T00:00:00+00:00',
                            'end' => null,
                            'forDate' => '2018-12-07T00:00:00+00:00',
                            'schedule' => [1],
                            'position' => null,
                        ],
                        [
                            'id' => 2,
                            'name' => 'Work',
                            'state' => 'in_progress',
                            'start' => '2018-10-29T00:00:00+00:00',
                            'end' => null,
                            'forDate' => '2018-12-07T00:00:00+00:00',
                            'schedule' => [1, 1, 1, 1, 1, 0, 0],
                            'position' => null,
                        ],
                        [
                            'id' => 1,
                            'name' => 'Exercises',
                            'state' => 'in_progress',
                            'start' => '2018-11-01T00:00:00+00:00',
                            'end' => '2018-12-01T00:00:00+00:00',
                            'forDate' => '2018-11-29T00:00:00+00:00',
                            'schedule' => [1, 1, 1, 0],
                            'position' => null,
                        ],
                    ],
                ],
            ],
        ];
    }
}
