<?php

namespace App\Tests;

use App\Doctrine\DBAL\Type\TaskChangeActionType;
use App\Entity\Task;
use App\Entity\TaskChange;
use App\Service\Task\TaskDtoServiceInterface;
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
     * @var TaskDtoServiceInterface
     */
    private $taskDtoService;

    /**
     * @throws ModuleException
     */
    protected function _before()
    {
        $this->taskDtoService = $this->tester->getSymfonyService(TaskDtoServiceInterface::class);
    }

    /**
     * @throws \Exception
     */
    public function testCreate()
    {
        try {
            $task = $this->make(Task::class, [
                'id' => 1,
                'name' => 'Task',
                'startDate' => new \DateTime('2018-11-01'),
                'changes' => new ArrayCollection(),
            ]);

            $renameChange = $this->make(TaskChange::class, [
                'action' => TaskChangeActionType::RENAME,
                'name' => 'Task (renamed)',
                'forDate' => new \DateTime('2018-11-01'),
            ]);

            $markTaskAsDoneChange = $this->make(TaskChange::class, [
                'action' => TaskChangeActionType::UPDATE_STATE,
                'state' => 'done',
                'forDate' => new \DateTime('2018-11-01'),
            ]);

            $markTaskAsCancelledChange = $this->make(TaskChange::class, [
                'action' => TaskChangeActionType::UPDATE_STATE,
                'state' => 'cancelled',
                'forDate' => new \DateTime('2018-11-01'),
            ]);

            $updatePositionChange = $this->make(TaskChange::class, [
                'action' => TaskChangeActionType::UPDATE_POSITION,
                'position' => 1,
                'forDate' => new \DateTime('2018-11-01'),
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create mock objects.');
        }

        $dto = $this->taskDtoService->create($task, [$renameChange]);
        $this->assertEquals('Task (renamed)', $dto->name);
        $this->assertEquals('in_progress', $dto->state);
        $this->assertNull($dto->position);

        $dto = $this->taskDtoService->create($task, [$markTaskAsDoneChange]);
        $this->assertEquals('Task', $dto->name);
        $this->assertEquals('done', $dto->state);
        $this->assertNull($dto->position);

        $dto = $this->taskDtoService->create($task, [$markTaskAsCancelledChange]);
        $this->assertEquals('Task', $dto->name);
        $this->assertEquals('cancelled', $dto->state);
        $this->assertNull($dto->position);

        $dto = $this->taskDtoService->create($task, [$updatePositionChange]);
        $this->assertEquals('Task', $dto->name);
        $this->assertEquals('in_progress', $dto->state);
        $this->assertEquals(1, $dto->position);
    }
}
