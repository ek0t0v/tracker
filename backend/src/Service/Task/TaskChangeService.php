<?php

namespace App\Service\Task;

use App\Entity\Task;

/**
 * Class TaskChangeService.
 */
class TaskChangeService implements TaskChangeServiceInterface
{
    public function createNameChange(Task $task, \DateTime $forDate, string $name): Task
    {
        // TODO: Implement createNameChange() method.
    }

    public function createTransferChanges(Task $task, \DateTime $forDate, \DateTime $transferFrom, \DateTime $transferTo): Task
    {
        // TODO: Implement createTransferChanges() method.
    }

    public function createUpdatePositionChange(Task $task, \DateTime $forDate, int $position): Task
    {
        // TODO: Implement createUpdatePositionChange() method.
    }

    public function createUpdateStateChange(Task $task, \DateTime $forDate, string $state): Task
    {
        // TODO: Implement createUpdateStateChange() method.
    }
}
