<?php

namespace App\Service\Task;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class TaskChangeService.
 */
class TaskChangeService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * TaskChangeService constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Task      $task
     * @param \DateTime $forDate
     * @param int       $position
     *
     * @return Task
     */
    public function updatePosition(Task $task, \DateTime $forDate, int $position): Task
    {
        return new Task();
    }

    /**
     * @param Task      $task
     * @param \DateTime $forDate
     * @param string    $state
     *
     * @return Task
     */
    public function updateState(Task $task, \DateTime $forDate, string $state): Task
    {
        return new Task();
    }
}
