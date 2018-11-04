<?php

namespace App\Doctrine\EventListener;

use App\Entity\Task;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TaskListener.
 */
class TaskListener
{
    /**
     * @param Task               $task
     * @param PreUpdateEventArgs $event
     *
     * @ORM\PreUpdate
     */
    public function preUpdateHandler(Task $task, PreUpdateEventArgs $event)
    {
    }
}
