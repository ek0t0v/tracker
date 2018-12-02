<?php

namespace App\Service\Task;

use App\Entity\Task;
use App\Response\Task\TaskDto;

/**
 * Interface TaskDtoServiceInterface.
 */
interface TaskDtoServiceInterface
{
    /**
     * @param Task  $task
     * @param array $changes
     *
     * @return TaskDto
     */
    public function create(Task $task, array $changes = []): TaskDto;
}
