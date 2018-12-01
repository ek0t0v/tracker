<?php

namespace App\Tests;

use App\Doctrine\DBAL\Type\TaskChangeActionType;
use App\Doctrine\DBAL\Type\TaskChangeStateType;
use App\Entity\Task;
use App\Entity\TaskChange;
use App\Service\Task\TaskChangeServiceInterface;
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
     * @var TaskChangeServiceInterface
     */
    private $taskChangeService;

    /**
     * @throws ModuleException
     */
    protected function _before()
    {
        $this->taskChangeService = $this->tester->getSymfonyService(TaskChangeServiceInterface::class);
    }

    /**
     * @throws \Exception
     */
    public function testGetLatestChanges()
    {
        $task = new Task();
        $task->setStartDate(new \DateTime('2018-11-01'));
        $task->setName('Test task');

        try {
            $change1 = $this->make(TaskChange::class, [
                'id' => 1,
                'action' => TaskChangeActionType::RENAME,
                'name' => 'Test task (renamed 1)',
                'forDate' => new \DateTime('2018-11-01'),
            ]);

            $change2 = $this->make(TaskChange::class, [
                'id' => 2,
                'action' => TaskChangeActionType::RENAME,
                'name' => 'Test task (renamed 2)',
                'forDate' => new \DateTime('2018-11-01'),
            ]);

            $change3 = $this->make(TaskChange::class, [
                'id' => 3,
                'action' => TaskChangeActionType::UPDATE_STATE,
                'state' => TaskChangeStateType::DONE,
                'forDate' => new \DateTime('2018-11-01'),
            ]);

            $change4 = $this->make(TaskChange::class, [
                'id' => 4,
                'action' => TaskChangeActionType::UPDATE_STATE,
                'state' => TaskChangeStateType::DONE,
                'forDate' => new \DateTime('2018-11-02'),
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create TaskChange mock objects.');
        }

        $task->addChange($change1);
        $task->addChange($change2);
        $task->addChange($change3);
        $task->addChange($change4);

        $latestChanges = $this->taskChangeService->getLatestChanges($task, new \DateTime('2018-11-01'));

        $this->assertCount(2, $latestChanges);

        $this->assertEquals('Test task (renamed 2)', $latestChanges[0]->getName());
        $this->assertEquals(new \DateTime('2018-11-01'), $latestChanges[0]->getForDate());

        $this->assertEquals(TaskChangeStateType::DONE, $latestChanges[1]->getState());
        $this->assertEquals(new \DateTime('2018-11-01'), $latestChanges[1]->getForDate());
    }
}
