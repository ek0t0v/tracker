<?php

namespace App\Service\Task;

use App\Entity\Task;
use App\Response\Task\TaskDto;

/**
 * Interface TaskServiceInterface.
 */
interface TaskServiceInterface
{
    /**
     * @param \DateTime      $start
     * @param \DateTime|null $end
     *
     * @return TaskDto[]
     */
    public function get(\DateTime $start, \DateTime $end = null): array;

    /**
     * @param string         $name
     * @param \DateTime      $startDate
     * @param \DateTime|null $endDate
     * @param array|null     $schedule
     *
     * @return TaskDto
     */
    public function create(string $name, \DateTime $startDate, \DateTime $endDate = null, array $schedule = null): TaskDto;

    /**
     * @param Task   $task
     * @param string $name
     *
     * @return TaskDto
     */
    public function rename(Task $task, string $name): TaskDto;
}
