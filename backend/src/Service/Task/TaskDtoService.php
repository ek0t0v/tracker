<?php

namespace App\Service\Task;

use App\Doctrine\DBAL\Type\TaskChangeActionType;
use App\Doctrine\DBAL\Type\TaskChangeStateType;
use App\Entity\Task;
use App\Response\Task\TaskDto;

/**
 * Class TaskDtoService.
 */
class TaskDtoService implements TaskDtoServiceInterface
{
    /**
     * @var TaskChangeServiceInterface
     */
    private $taskChangeService;

    /**
     * TaskDtoService constructor.
     *
     * @param TaskChangeServiceInterface $taskChangeService
     */
    public function __construct(TaskChangeServiceInterface $taskChangeService)
    {
        $this->taskChangeService = $taskChangeService;
    }

    /**
     * {@inheritdoc}
     */
    public function create(Task $task, array $changes): TaskDto
    {
        $dto = new TaskDto();
        $dto->id = $task->getId();
        $dto->name = $task->getName();
        $dto->start = $task->getStartDate();
        $dto->end = $task->getEndDate();
        $dto->schedule = $task->getSchedule();
        $dto->state = TaskChangeStateType::IN_PROGRESS;

        foreach ($changes as $change) {
            switch ($change->getAction()) {
                case TaskChangeActionType::UPDATE_STATE:
                    $dto->state = $change->getState();

                    break;
                case TaskChangeActionType::UPDATE_POSITION:
                    $dto->position = $change->getPosition();

                    break;
            }
        }

        return $dto;
    }
}
