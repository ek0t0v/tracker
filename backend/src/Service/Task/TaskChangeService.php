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
    public function getLatestChanges(Task $task, \DateTime $start): array
    {
        $changesHash = [];

        foreach ($task->getChanges() as $change) {
            if ($change->getForDate() != $start) {
                continue;
            }

            $newerChange = array_key_exists($change->getAction(), $changesHash)
                && $change->getId() > $changesHash[$change->getAction()]->getId();

            if (!array_key_exists($change->getAction(), $changesHash) || $newerChange) {
                $changesHash[$change->getAction()] = $change;
            }
        }

        $changes = [];

        foreach ($changesHash as $element) {
            $changes[] = $element;
        }

        return $changes;
    }
}
