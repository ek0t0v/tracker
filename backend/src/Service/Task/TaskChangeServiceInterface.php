<?php

namespace App\Service\Task;

use App\Entity\Task;

/**
 * Interface TaskChangeServiceInterface.
 */
interface TaskChangeServiceInterface
{
    /**
     * @param Task      $task
     * @param string    $name
     * @param \DateTime $forDate
     *
     * @return Task
     */
    public function createNameChange(Task $task, \DateTime $forDate, string $name): Task;

    /**
     * @param Task      $task
     * @param \DateTime $forDate
     * @param \DateTime $transferFrom
     * @param \DateTime $transferTo
     *
     * @return Task
     */
    public function createTransferChanges(Task $task, \DateTime $forDate, \DateTime $transferFrom, \DateTime $transferTo): Task;

    /**
     * @param Task      $task
     * @param \DateTime $forDate
     * @param int       $position
     *
     * @return Task
     */
    public function createUpdatePositionChange(Task $task, \DateTime $forDate, int $position): Task;

    /**
     * @param Task      $task
     * @param \DateTime $forDate
     * @param string    $state
     *
     * @return Task
     */
    public function createUpdateStateChange(Task $task, \DateTime $forDate, string $state): Task;

    /**
     * @param array     $tasks
     * @param \DateTime $start
     *
     * @return mixed
     */
    public function filterTransferredTasks(array $tasks, \DateTime $start);

    /**
     * @param \DateTime $start
     *
     * @return array
     */
    public function findTransferredTasks(\DateTime $start): array;
}
