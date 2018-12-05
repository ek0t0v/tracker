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
     * @var TaskChangeService
     */
    private $taskChangeService;

    /**
     * TaskDtoService constructor.
     *
     * @param TaskChangeService $taskChangeService
     */
    public function __construct(TaskChangeService $taskChangeService)
    {
        $this->taskChangeService = $taskChangeService;
    }

    /**
     * @param Task           $task
     * @param \DateTime|null $forDate
     *
     * @return TaskDto
     */
    public function create(Task $task, \DateTime $forDate = null): TaskDto
    {
        $dto = new TaskDto();
        $dto->id = $task->getId();
        $dto->name = $task->getName();
        $dto->start = $task->getStartDate();
        $dto->end = $task->getEndDate();
        $dto->forDate = !is_null($forDate) ? $forDate : $task->getStartDate();
        $dto->schedule = $task->getSchedule();
        $dto->state = TaskChangeStateType::IN_PROGRESS;

        //foreach ($task->getChanges() as $change) {
        //    switch ($change->getAction()) {
        //        case TaskChangeActionType::UPDATE_STATE:
        //            $dto->state = $change->getState();
        //
        //            break;
        //        case TaskChangeActionType::UPDATE_POSITION:
        //            $dto->position = $change->getPosition();
        //
        //            break;
        //    }
        //}

        return $dto;
    }
}
