<?php

namespace App\Doctrine\EventListener;

use App\Entity\TaskChange;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TaskChangeListener.
 */
final class TaskChangeListener
{
    /**
     * @param TaskChange $change
     *
     * @ORM\PrePersist()
     */
    public function prePersist(TaskChange $change)
    {
        $change->setCreatedAt(new \DateTime());
    }
}
