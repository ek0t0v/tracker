<?php

namespace Common\Tests;

use Common\Entity\Task;
use Common\Entity\TaskChange;
use Common\Service\Task\DtoService;
use Codeception\Exception\ModuleException;
use Codeception\Test\Unit;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class TaskDtoServiceTest.
 */
class TaskDtoServiceTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var DtoService
     */
    private $taskDtoService;

    /**
     * @throws ModuleException
     */
    protected function _before()
    {
        $this->taskDtoService = $this->tester->getSymfonyService(DtoService::class);
    }

    /**
     * @throws \Exception
     */
    public function testCreate()
    {
        try {
            /**
             * @var Task $task
             */
            $task = $this->make(Task::class, [
                'id' => 1,
                'name' => 'Task',
                'startDate' => new \DateTime('2018-11-01'),
                'changes' => new ArrayCollection(),
                'transfers' => new ArrayCollection(),
            ]);

            /**
             * @var TaskChange $markTaskAsDoneChange
             */
            $markTaskAsDoneChange = $this->make(TaskChange::class, [
                'state' => 'done',
                'forDate' => new \DateTime('2018-11-01'),
            ]);

            /**
             * @var TaskChange $markTaskAsCancelledChange
             */
            $markTaskAsCancelledChange = $this->make(TaskChange::class, [
                'state' => 'cancelled',
                'forDate' => new \DateTime('2018-11-01'),
            ]);

            /**
             * @var TaskChange $updatePositionChange
             */
            $updatePositionChange = $this->make(TaskChange::class, [
                'position' => 1,
                'forDate' => new \DateTime('2018-11-01'),
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create mock objects.');
        }

        $task->addChange($markTaskAsDoneChange);

        $dto = $this->taskDtoService->create($task, new \DateTime('2018-11-01'));
        $this->assertEquals('done', $dto->state);

        $task->removeChange($markTaskAsDoneChange);
        $task->addChange($markTaskAsCancelledChange);

        $dto = $this->taskDtoService->create($task, new \DateTime('2018-11-01'));
        $this->assertEquals('cancelled', $dto->state);

        $task->removeChange($markTaskAsCancelledChange);
        $task->addChange($updatePositionChange);

        $dto = $this->taskDtoService->create($task, new \DateTime('2018-11-01'));
        $this->assertEquals(1, $dto->position);
    }
}
