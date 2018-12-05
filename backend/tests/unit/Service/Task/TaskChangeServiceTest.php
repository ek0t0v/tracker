<?php

namespace App\Tests;

use App\Service\Task\TaskChangeService;
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
     * @var TaskChangeService
     */
    private $taskChangeService;

    /**
     * @throws ModuleException
     */
    protected function _before()
    {
        $this->taskChangeService = $this->tester->getSymfonyService(TaskChangeService::class);
    }
}
