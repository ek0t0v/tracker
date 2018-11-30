<?php

namespace App\Service\Task;

/**
 * Interface TaskTransferServiceInterface.
 */
interface TaskTransferServiceInterface
{
    /**
     * @param \DateTime $start
     *
     * @return array
     */
    public function findTransferredTasks(\DateTime $start): array;

    /**
     * @param array     $tasks
     * @param \DateTime $start
     *
     * @return mixed
     */
    public function filterTransferredTasks(array $tasks, \DateTime $start);
}
