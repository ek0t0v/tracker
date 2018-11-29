<?php

namespace App\Service\Task;

use App\Entity\Task;

/**
 * Interface TaskServiceInterface.
 */
interface TaskServiceInterface
{
    /**
     * @param \DateTime      $start
     * @param \DateTime|null $end
     *
     * @return array
     */
    public function get(\DateTime $start, \DateTime $end = null): array;

    /**
     * @param string         $name
     * @param \DateTime      $startDate
     * @param \DateTime|null $endDate
     * @param array|null     $schedule
     *
     * @return Task
     */
    public function create(string $name, \DateTime $startDate, \DateTime $endDate = null, array $schedule = null): Task;

    /**
     * @param Task   $task
     * @param string $name
     *
     * @return Task
     */
    public function rename(Task $task, string $name): Task;
}
