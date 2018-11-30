<?php

namespace App\Service\Task;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class TaskChangeService.
 */
class TaskChangeService implements TaskChangeServiceInterface
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
     * {@inheritdoc}
     */
    public function createNameChange(Task $task, \DateTime $forDate, string $name): Task
    {
        return new Task();
    }

    /**
     * {@inheritdoc}
     */
    public function createTransferChanges(Task $task, \DateTime $forDate, \DateTime $transferFrom, \DateTime $transferTo): Task
    {
        return new Task();
    }

    /**
     * {@inheritdoc}
     */
    public function createUpdatePositionChange(Task $task, \DateTime $forDate, int $position): Task
    {
        return new Task();
    }

    /**
     * {@inheritdoc}
     */
    public function createUpdateStateChange(Task $task, \DateTime $forDate, string $state): Task
    {
        return new Task();
    }

    /**
     * {@inheritdoc}
     */
    public function getLastChanges(Task $task): array
    {
        // TODO: Implement getLastChanges() method.
    }
}
