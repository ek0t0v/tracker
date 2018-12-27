<?php

namespace App\Service\Task;

use App\Doctrine\DBAL\Type\TaskChangeStateType;
use App\Dto\ApiResponse\TaskDto;
use App\Entity\Task;

/**
 * Class DtoService.
 */
class DtoService
{
    /**
     * @param Task           $task
     * @param \DateTime      $forDate
     * @param \DateTime|null $start
     *
     * @return TaskDto
     */
    public function create(Task $task, \DateTime $forDate, \DateTime $start = null): TaskDto
    {
        $dto = new TaskDto();
        $dto->id = $task->getId();
        $dto->name = $task->getName();
        $dto->start = $task->getStartDate();
        $dto->end = $task->getEndDate();
        $dto->forDate = $forDate;
        $dto->repeatType = $task->getRepeatType();
        $dto->repeatValue = $task->getRepeatValue();
        $dto->schedule = $task->getSchedule();
        $dto->state = TaskChangeStateType::IN_PROGRESS;

        foreach ($task->getTransfers() as $transfer) {
            if ($transfer->getForDate() == $forDate) {
                $dto->transfers[] = $transfer->getTransferTo();
            }
        }

        if (!is_null($start) && count($dto->transfers) > 0 && $dto->transfers[count($dto->transfers) - 1] != $start) {
            $dto->isTransferred = true;
        }

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
