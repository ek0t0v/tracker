<?php

namespace App\Service\Task;

use App\Entity\Task;

/**
 * Interface TaskTransferServiceInterface.
 */
interface TaskTransferServiceInterface
{
    /**
     * @param \DateTime $start
     *
     * @return Task[]
     */
    public function findTransferredTasks(\DateTime $start): array;

    /**
     * @param array     $tasks
     * @param \DateTime $start
     *
     * @return Task[]
     */
    public function filterTransferredTasks(array $tasks, \DateTime $start): array;
}
