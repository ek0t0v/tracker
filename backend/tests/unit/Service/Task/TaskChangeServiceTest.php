<?php

namespace App\Tests;

use App\Doctrine\DBAL\Type\TaskChangeActionType;
use App\Entity\Task;
use App\Entity\TaskChange;
use App\Service\Task\TaskChangeServiceInterface;
use App\Service\Task\TaskScheduleServiceInterface;
use Codeception\Exception\ModuleException;
use Codeception\Test\Unit;

/**
 * Class TaskChangeServiceTest.
 */
class TaskChangeServiceTest extends Unit
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
     * @var TaskChangeServiceInterface
     */
    private $taskChangeService;

    /**
     * @throws ModuleException
     */
    protected function _before()
    {
        $this->taskScheduleService = $this->tester->getSymfonyService(TaskScheduleServiceInterface::class);
        $this->taskChangeService = $this->tester->getSymfonyService(TaskChangeServiceInterface::class);
    }

    public function testFilterTransferredTasks()
    {
        $task = new Task();
        $task->setName('Exercises');
        $task->setStartDate(new \DateTime('2018-11-01'));
        $task->setEndDate(new \DateTime('2018-12-01'));
        $task->setSchedule([1, 1, 1, 0]);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-01'));
        $result = $this->taskChangeService->filterTransferredTasks($result, new \DateTime('2018-11-01'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-04'));
        $result = $this->taskChangeService->filterTransferredTasks($result, new \DateTime('2018-11-04'));
        $this->assertCount(0, $result);

        $transferToChange = new TaskChange();
        $transferToChange->setAction(TaskChangeActionType::TRANSFER_TO);
        $transferToChange->setTransferTo(new \DateTime('2018-11-04'));
        $transferToChange->setForDate(new \DateTime('2018-11-03'));

        $task->addChange($transferToChange);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-03'));
        $result = $this->taskChangeService->filterTransferredTasks($result, new \DateTime('2018-11-03'));
        $this->assertCount(0, $result);

        $transferFromChange = new TaskChange();
        $transferFromChange->setAction(TaskChangeActionType::TRANSFER_FROM);
        $transferFromChange->setTransferFrom(new \DateTime('2018-11-03'));
        $transferFromChange->setForDate(new \DateTime('2018-11-04'));

        $task->removeChange($transferToChange);
        $task->addChange($transferFromChange);

        $transferredTasks = [$task];
        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-04'));
        $result = $this->taskChangeService->filterTransferredTasks($result, new \DateTime('2018-11-04'));
        $result = array_merge($result, $transferredTasks);
        $this->assertCount(1, $result);
    }

    public function testFindTransferredTasks()
    {
        $this->assertTrue(false, 'Need to implement!');
    }
}
