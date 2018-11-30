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

    public function testGetLatestChanges()
    {
        $task = new Task();
        $task->setStartDate(new \DateTime('2018-11-01'));
        $task->setName('Test task');

        $change1 = $this->getMockBuilder(TaskChange::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $change1->method('getId')
            ->willReturn(1);
        $change1->method('getAction')
            ->willReturn(TaskChangeActionType::RENAME);
        $change1->method('getName')
            ->willReturn('Test task (renamed 1)');
        $change1->method('getForDate')
            ->willReturn(new \DateTime('2018-11-01'));

        $change2 = $this->getMockBuilder(TaskChange::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $change2->method('getId')
            ->willReturn(2);
        $change2->method('getAction')
            ->willReturn(TaskChangeActionType::RENAME);
        $change2->method('getName')
            ->willReturn('Test task (renamed 2)');
        $change2->method('getForDate')
            ->willReturn(new \DateTime('2018-11-01'));

        $change3 = $this->getMockBuilder(TaskChange::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $change3->method('getId')
            ->willReturn(3);
        $change3->method('getAction')
            ->willReturn(TaskChangeActionType::UPDATE_STATE);
        $change3->method('getState')
            ->willReturn(TaskChangeStateType::DONE);
        $change3->method('getForDate')
            ->willReturn(new \DateTime('2018-11-01'));

        $change4 = $this->getMockBuilder(TaskChange::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $change4->method('getId')
            ->willReturn(3);
        $change4->method('getAction')
            ->willReturn(TaskChangeActionType::UPDATE_STATE);
        $change4->method('getState')
            ->willReturn(TaskChangeStateType::DONE);
        $change4->method('getForDate')
            ->willReturn(new \DateTime('2018-11-02'));

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
