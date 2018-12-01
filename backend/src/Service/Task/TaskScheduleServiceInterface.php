<?php

namespace App\Service\Task;

use App\Entity\Task;

/**
 * Interface TaskScheduleServiceInterface.
 */
interface TaskScheduleServiceInterface
{
    /**
     * @param Task[]    $tasks
     * @param \DateTime $start
     *
     * @return Task[]
     */
    public function filter(array $tasks, \DateTime $start): array;
}
