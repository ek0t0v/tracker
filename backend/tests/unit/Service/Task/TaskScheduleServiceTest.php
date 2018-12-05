<?php

namespace App\Tests;

use App\Entity\Task;
use App\Service\Task\TaskScheduleService;
use Codeception\Exception\ModuleException;
use Codeception\Test\Unit;

/**
 * Class TaskScheduleServiceTest.
 */
class TaskScheduleServiceTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var TaskScheduleService
     */
    private $taskScheduleService;

    /**
     * @throws ModuleException
     */
    protected function _before()
    {
        $this->taskScheduleService = $this->tester->getSymfonyService(TaskScheduleService::class);
    }

    /**
     * @param \DateTime $start
     * @param bool      $expected
     *
     * @throws \Exception
     *
     * @dataProvider workTaskDataProvider
     */
    public function testFilterWithWorkTask(\DateTime $start, bool $expected)
    {
        try {
            $task = $this->make(Task::class, [
                'name' => 'Work',
                'startDate' => new \DateTime('2018-10-29'),
                'schedule' => [1, 1, 1, 1, 1, 0, 0],
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create mock objects.');
        }

        $isTaskScheduled = $this->taskScheduleService->isTaskScheduled($task, $start);
        $this->assertEquals($expected, $isTaskScheduled);
    }

    /**
     * @param \DateTime $start
     * @param bool      $expected
     *
     * @throws \Exception
     *
     * @dataProvider exercisesTaskDataProvider
     */
    public function testFilterWithExercisesTask(\DateTime $start, bool $expected)
    {
        try {
            $task = $this->make(Task::class, [
                'name' => 'Exercises',
                'startDate' => new \DateTime('2018-11-01'),
                'endDate' => new \DateTime('2018-12-01'),
                'schedule' => [1, 1, 1, 0],
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create mock objects.');
        }

        $isTaskScheduled = $this->taskScheduleService->isTaskScheduled($task, $start);
        $this->assertEquals($expected, $isTaskScheduled);
    }

    /**
     * @param \DateTime $start
     * @param bool      $expected
     *
     * @throws \Exception
     *
     * @dataProvider readingTaskDataProvider
     */
    public function testFilterWithReadingTask(\DateTime $start, bool $expected)
    {
        try {
            $task = $this->make(Task::class, [
                'name' => 'Reading',
                'startDate' => new \DateTime('2018-11-19'),
                'schedule' => [1],
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create mock objects.');
        }

        $isTaskScheduled = $this->taskScheduleService->isTaskScheduled($task, $start);
        $this->assertEquals($expected, $isTaskScheduled);
    }

    /**
     * @param \DateTime $start
     * @param bool      $expected
     *
     * @throws \Exception
     *
     * @dataProvider singleTaskDataProvider
     */
    public function testFilterWithSingleTask(\DateTime $start, bool $expected)
    {
        try {
            $task = $this->make(Task::class, [
                'name' => 'Single task',
                'startDate' => new \DateTime('2018-11-07'),
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create mock objects.');
        }

        $isTaskScheduled = $this->taskScheduleService->isTaskScheduled($task, $start);
        $this->assertEquals($expected, $isTaskScheduled);
    }

    /**
     * @return array
     */
    public function workTaskDataProvider(): array
    {
        return [
            '2018-10-18' => [new \DateTime('2018-10-18'), false],
            '2018-11-03' => [new \DateTime('2018-11-03'), false],
            '2018-11-04' => [new \DateTime('2018-11-04'), false],
            '2018-11-10' => [new \DateTime('2018-11-10'), false],
            '2019-03-17' => [new \DateTime('2019-03-17'), false],
            '2018-10-29' => [new \DateTime('2018-10-29'), true],
            '2018-10-30' => [new \DateTime('2018-10-30'), true],
            '2018-10-31' => [new \DateTime('2018-10-31'), true],
            '2018-11-01' => [new \DateTime('2018-11-01'), true],
            '2018-11-02' => [new \DateTime('2018-11-02'), true],
            '2018-11-05' => [new \DateTime('2018-11-05'), true],
            '2018-11-15' => [new \DateTime('2018-11-15'), true],
            '2019-03-15' => [new \DateTime('2019-03-15'), true],
        ];
    }

    /**
     * @return array
     */
    public function exercisesTaskDataProvider(): array
    {
        return [
            '2018-10-04' => [new \DateTime('2018-10-04'), false],
            '2018-11-04' => [new \DateTime('2018-11-04'), false],
            '2018-11-20' => [new \DateTime('2018-11-20'), false],
            '2018-12-02' => [new \DateTime('2018-12-02'), false],
            '2018-12-03' => [new \DateTime('2018-12-03'), false],
            '2019-12-03' => [new \DateTime('2019-12-03'), false],
            '2018-11-01' => [new \DateTime('2018-11-01'), true],
            '2018-11-02' => [new \DateTime('2018-11-02'), true],
            '2018-11-03' => [new \DateTime('2018-11-03'), true],
            '2018-11-05' => [new \DateTime('2018-11-05'), true],
            '2018-11-21' => [new \DateTime('2018-11-21'), true],
            '2018-12-01' => [new \DateTime('2018-12-01'), true],
        ];
    }

    /**
     * @return array
     */
    public function readingTaskDataProvider(): array
    {
        return [
            '2018-11-18' => [new \DateTime('2018-11-18'), false],
            '2018-11-19' => [new \DateTime('2018-11-19'), true],
            '2018-11-20' => [new \DateTime('2018-11-20'), true],
            '2018-12-01' => [new \DateTime('2018-12-01'), true],
            '2019-02-19' => [new \DateTime('2019-02-19'), true],
            '2020-01-20' => [new \DateTime('2020-01-20'), true],
        ];
    }

    /**
     * @return array
     */
    public function singleTaskDataProvider(): array
    {
        return [
            '2018-11-05' => [new \DateTime('2018-11-05'), false],
            '2018-11-08' => [new \DateTime('2018-11-08'), false],
            '2018-12-01' => [new \DateTime('2018-12-01'), false],
            '2019-05-06' => [new \DateTime('2019-05-06'), false],
            '2018-11-07' => [new \DateTime('2018-11-07'), true],
        ];
    }
}
