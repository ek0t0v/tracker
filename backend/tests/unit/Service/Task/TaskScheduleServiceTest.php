<?php

namespace App\Tests;

use App\Entity\Task;
use App\Service\Task\TaskScheduleServiceInterface;
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
     * @var TaskScheduleServiceInterface
     */
    private $taskScheduleService;

    /**
     * @throws ModuleException
     */
    protected function _before()
    {
        $this->taskScheduleService = $this->tester->getSymfonyService(TaskScheduleServiceInterface::class);
    }

    /**
     * @param \DateTime $start
     * @param int       $expectedTasksCountAfterFilter
     *
     * @throws \Exception
     *
     * @dataProvider workTaskDataProvider
     */
    public function testFilterWithWorkTask(\DateTime $start, int $expectedTasksCountAfterFilter)
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

        $result = $this->taskScheduleService->filter([$task], $start);
        $this->assertCount($expectedTasksCountAfterFilter, $result);
    }

    /**
     * @param \DateTime $start
     * @param int       $expectedTasksCountAfterFilter
     *
     * @throws \Exception
     *
     * @dataProvider exercisesTaskDataProvider
     */
    public function testFilterWithExercisesTask(\DateTime $start, int $expectedTasksCountAfterFilter)
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

        $result = $this->taskScheduleService->filter([$task], $start);
        $this->assertCount($expectedTasksCountAfterFilter, $result);
    }

    /**
     * @param \DateTime $start
     * @param int       $expectedTasksCountAfterFilter
     *
     * @throws \Exception
     *
     * @dataProvider readingTaskDataProvider
     */
    public function testFilterWithReadingTask(\DateTime $start, int $expectedTasksCountAfterFilter)
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

        $result = $this->taskScheduleService->filter([$task], $start);
        $this->assertCount($expectedTasksCountAfterFilter, $result);
    }

    /**
     * @param \DateTime $start
     * @param int       $expectedTasksCountAfterFilter
     *
     * @throws \Exception
     *
     * @dataProvider singleTaskDataProvider
     */
    public function testFilterWithSingleTask(\DateTime $start, int $expectedTasksCountAfterFilter)
    {
        try {
            $task = $this->make(Task::class, [
                'name' => 'Single task',
                'startDate' => new \DateTime('2018-11-07'),
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create mock objects.');
        }

        $result = $this->taskScheduleService->filter([$task], $start);
        $this->assertCount($expectedTasksCountAfterFilter, $result);
    }

    /**
     * @return array
     */
    public function workTaskDataProvider(): array
    {
        return [
            '2018-10-18' => [new \DateTime('2018-10-18'), 0],
            '2018-11-03' => [new \DateTime('2018-11-03'), 0],
            '2018-11-04' => [new \DateTime('2018-11-04'), 0],
            '2018-11-10' => [new \DateTime('2018-11-10'), 0],
            '2019-03-17' => [new \DateTime('2019-03-17'), 0],
            '2018-10-29' => [new \DateTime('2018-10-29'), 1],
            '2018-10-30' => [new \DateTime('2018-10-30'), 1],
            '2018-10-31' => [new \DateTime('2018-10-31'), 1],
            '2018-11-01' => [new \DateTime('2018-11-01'), 1],
            '2018-11-02' => [new \DateTime('2018-11-02'), 1],
            '2018-11-05' => [new \DateTime('2018-11-05'), 1],
            '2018-11-15' => [new \DateTime('2018-11-15'), 1],
            '2019-03-15' => [new \DateTime('2019-03-15'), 1],
        ];
    }

    /**
     * @return array
     */
    public function exercisesTaskDataProvider(): array
    {
        return [
            '2018-10-04' => [new \DateTime('2018-10-04'), 0],
            '2018-11-04' => [new \DateTime('2018-11-04'), 0],
            '2018-11-20' => [new \DateTime('2018-11-20'), 0],
            '2018-12-02' => [new \DateTime('2018-12-02'), 0],
            '2018-12-03' => [new \DateTime('2018-12-03'), 0],
            '2019-12-03' => [new \DateTime('2019-12-03'), 0],
            '2018-11-01' => [new \DateTime('2018-11-01'), 1],
            '2018-11-02' => [new \DateTime('2018-11-02'), 1],
            '2018-11-03' => [new \DateTime('2018-11-03'), 1],
            '2018-11-05' => [new \DateTime('2018-11-05'), 1],
            '2018-11-21' => [new \DateTime('2018-11-21'), 1],
            '2018-12-01' => [new \DateTime('2018-12-01'), 1],
        ];
    }

    /**
     * @return array
     */
    public function readingTaskDataProvider(): array
    {
        return [
            '2018-11-18' => [new \DateTime('2018-11-18'), 0],
            '2018-11-19' => [new \DateTime('2018-11-19'), 1],
            '2018-11-20' => [new \DateTime('2018-11-20'), 1],
            '2018-12-01' => [new \DateTime('2018-12-01'), 1],
            '2019-02-19' => [new \DateTime('2019-02-19'), 1],
            '2020-01-20' => [new \DateTime('2020-01-20'), 1],
        ];
    }

    /**
     * @return array
     */
    public function singleTaskDataProvider(): array
    {
        return [
            '2018-11-05' => [new \DateTime('2018-11-05'), 0],
            '2018-11-08' => [new \DateTime('2018-11-08'), 0],
            '2018-12-01' => [new \DateTime('2018-12-01'), 0],
            '2019-05-06' => [new \DateTime('2019-05-06'), 0],
            '2018-11-07' => [new \DateTime('2018-11-07'), 1],
        ];
    }
}
