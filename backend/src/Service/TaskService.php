<?php

namespace App\Service;

use App\Response\Task\TaskDto;

/**
 * Class TaskService.
 */
class TaskService
{
    /**
     * @param \DateTime $date
     *
     * @return array
     */
    public function getTasksByDate(\DateTime $date): array
    {
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @throws \Exception
     *
     * @return TaskDto[]
     */
    public function getTasksByDateRange(\DateTime $start, \DateTime $end): array
    {
    }
}
