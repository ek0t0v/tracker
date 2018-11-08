<?php

namespace App\Service\Task;

use App\Entity\Task;
use App\Entity\User;

/**
 * Interface TaskManagerInterface.
 */
interface TaskManagerInterface
{
    /**
     * @param string $name
     * @param User   $user
     *
     * @return Task
     */
    public function add(string $name, User $user): Task;

    /**
     * @param array|int[] $ids
     * @param User        $user
     */
    public function remove(array $ids, User $user);

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
