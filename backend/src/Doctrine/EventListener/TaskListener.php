<?php

namespace App\Doctrine\EventListener;

use App\Entity\Task;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TaskListener.
 */
final class TaskListener
{
    /**
     * @param Task $task
     *
     * @ORM\PrePersist
     */
    public function prePersist(Task $task)
    {
        $task->setUpdatedAt(new \DateTime());
        $task->setCreatedAt(new \DateTime());
    }

    /**
     * @todo Установить/обновить updatedAt если произошли изменения.
     *
     * @param Task $task
     *
     * @ORM\PreUpdate
     */
    public function preUpdate(Task $task)
    {
    }
}
