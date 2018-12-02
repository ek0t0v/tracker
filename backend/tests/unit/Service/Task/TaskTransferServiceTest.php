<?php

namespace App\Tests;

use App\Doctrine\DBAL\Type\TaskChangeActionType;
use App\Entity\Task;
use App\Entity\TaskChange;
use App\Service\Task\TaskScheduleServiceInterface;
use App\Service\Task\TaskTransferServiceInterface;
use Codeception\Exception\ModuleException;
use Codeception\Test\Unit;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class TaskTransferServiceTest.
 */
class TaskTransferServiceTest extends Unit
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
     * @var TaskTransferServiceInterface
     */
    private $taskTransferService;

    /**
     * @throws ModuleException
     */
    protected function _before()
    {
        $this->taskScheduleService = $this->tester->getSymfonyService(TaskScheduleServiceInterface::class);
        $this->taskTransferService = $this->tester->getSymfonyService(TaskTransferServiceInterface::class);
    }

    /**
     * @throws \Exception
     */
    public function testFilterTransferredTasks()
    {
        try {
            $task = $this->make(Task::class, [
                'name' => 'Task',
                'startDate' => new \DateTime('2018-11-01'),
                'schedule' => [1, 1, 1, 0],
                'changes' => new ArrayCollection(),
            ]);

            $transferToChange = $this->make(TaskChange::class, [
                'action' => TaskChangeActionType::TRANSFER_TO,
                'transferTo' => new \DateTime('2018-11-04'),
                'forDate' => new \DateTime('2018-11-03'),
            ]);

            $transferFromChange = $this->make(TaskChange::class, [
                'action' => TaskChangeActionType::TRANSFER_FROM,
                'transferFrom' => new \DateTime('2018-11-03'),
                'forDate' => new \DateTime('2018-11-04'),
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create mock objects.');
        }

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-01'));
        $result = $this->taskTransferService->filterTransferredTasks($result, new \DateTime('2018-11-01'));
        $this->assertCount(1, $result);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-04'));
        $result = $this->taskTransferService->filterTransferredTasks($result, new \DateTime('2018-11-04'));
        $this->assertCount(0, $result);

        $task->addChange($transferToChange);

        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-03'));
        $result = $this->taskTransferService->filterTransferredTasks($result, new \DateTime('2018-11-03'));
        $this->assertCount(0, $result);

        $task->removeChange($transferToChange);
        $task->addChange($transferFromChange);

        $transferredTasks = [$task];
        $result = $this->taskScheduleService->filter([$task], new \DateTime('2018-11-04'));
        $result = $this->taskTransferService->filterTransferredTasks($result, new \DateTime('2018-11-04'));
        $result = array_merge($result, $transferredTasks);
        $this->assertCount(1, $result);
    }
}
