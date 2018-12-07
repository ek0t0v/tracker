<?php

namespace App\Service\Task;

use App\Doctrine\DBAL\Type\TaskChangeStateType;
use App\Entity\Task;
use App\Response\Task\TaskDto;

/**
 * Class TaskDtoService.
 */
class TaskDtoService
{
    /**
     * @param Task      $task
     * @param \DateTime $forDate
     *
     * @return TaskDto
     */
    public function create(Task $task, \DateTime $forDate): TaskDto
    {
        $dto = new TaskDto();
        $dto->id = $task->getId();
        $dto->name = $task->getName();
        $dto->start = $task->getStartDate();
        $dto->end = $task->getEndDate();
        $dto->forDate = $forDate;
        $dto->schedule = $task->getSchedule();
        $dto->state = TaskChangeStateType::IN_PROGRESS;

        foreach ($task->getChanges() as $change) {
            if ($change->getForDate() != $forDate) {
                continue;
            }

            if (!is_null($change->getState())) {
                $dto->state = $change->getState();
            }

            if (!is_null($change->getPosition())) {
                $dto->position = $change->getPosition();
            }
        }

        return $dto;
    }
}
