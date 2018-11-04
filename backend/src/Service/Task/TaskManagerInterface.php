<?php

namespace App\Service\Task;

use App\Entity\Task;

/**
 * Interface TaskManagerInterface.
 */
interface TaskManagerInterface
{
    /**
     * @param string $name
     *
     * @return Task
     */
    public function add(string $name): Task;

    /**
     * @param array|int[] $ids
     */
    public function remove(array $ids);

    /**
     * @param Task   $task
     * @param string $name
     *
     * @return Task
     */
    public function rename(Task $task, string $name): Task;

    /**
     * @param Task $task
     * @param int  $position
     *
     * @return Task
     */
    public function move(Task $task, int $position): Task;
}
