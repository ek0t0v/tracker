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
     * @return array
     */
    public function filter(array $tasks, \DateTime $start): array;
}
