<?php

namespace App\Service\Task;

use App\Doctrine\DBAL\Type\TaskChangeActionType;
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
        $name = $task->getName();
        $state = 'in_progress';
        $position = null;

        foreach ($changes as $change) {
            switch ($change->getAction()) {
                case TaskChangeActionType::RENAME:
                    $name = $change->getName();

                    break;
                case TaskChangeActionType::UPDATE_STATE:
                    $state = $change->getState();

                    break;
                case TaskChangeActionType::UPDATE_POSITION:
                    $position = $change->getPosition();

                    break;
            }
        }

        return new TaskDto($task->getId(), $name, $state, $position);
    }
}
