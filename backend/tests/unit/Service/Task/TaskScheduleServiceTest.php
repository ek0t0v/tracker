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

    public function testFilterWithWorkTask()
    {
        $task = new Task();
        $task->setName('Work');
        $task->setStartDate(new \DateTime('2018-10-29'));
        $task->setSchedule([1, 1, 1, 1, 1, 0, 0]);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-10-18'));
        $this->assertCount(0, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-10-29'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-10-30'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-10-31'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-01'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-02'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-03'));
        $this->assertCount(0, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-04'));
        $this->assertCount(0, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-05'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-10'));
        $this->assertCount(0, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-15'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2019-03-15'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2019-03-17'));
        $this->assertCount(0, $result);
    }

    public function testFilterWithExercisesTask()
    {
        $task = new Task();
        $task->setName('Exercises');
        $task->setStartDate(new \DateTime('2018-11-01'));
        $task->setEndDate(new \DateTime('2018-12-01'));
        $task->setSchedule([1, 1, 1, 0]);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-10-04'));
        $this->assertCount(0, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-01'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-02'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-03'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-04'));
        $this->assertCount(0, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-05'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-20'));
        $this->assertCount(0, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-21'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-12-01'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-12-02'));
        $this->assertCount(0, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-12-03'));
        $this->assertCount(0, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2019-12-03'));
        $this->assertCount(0, $result);
    }

    public function testFilterWithReadingTask()
    {
        $task = new Task();
        $task->setName('Reading');
        $task->setStartDate(new \DateTime('2018-11-19'));
        $task->setSchedule([1]);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-18'));
        $this->assertCount(0, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-19'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-20'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-12-01'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2019-02-19'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2020-01-20'));
        $this->assertCount(1, $result);
    }

    public function testFilterWithSingleTask()
    {
        $task = new Task();
        $task->setName('Single task');
        $task->setStartDate(new \DateTime('2018-11-07'));

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-05'));
        $this->assertCount(0, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-07'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-08'));
        $this->assertCount(0, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-12-01'));
        $this->assertCount(0, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2019-05-06'));
        $this->assertCount(0, $result);
    }
}
