<?php

namespace App\Service\Task;

use App\Doctrine\DBAL\Type\TaskChangeActionType;
use App\Entity\Task;
use App\Entity\TaskChange;
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
    public function filterTransferredTasks(array $tasks, \DateTime $start)
    {
        $result = [];

        foreach ($tasks as $task) {
            $lastTransferToChange = null;

            foreach ($task->getChanges() as $change) {
                if ($change->getForDate() != $start) {
                    continue;
                }

                if (TaskChangeActionType::TRANSFER_TO === $change->getAction()) {
                    $lastTransferToChange = $change;
                }
            }

            if (is_null($lastTransferToChange)) {
                $result[] = $task;
            }
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function findTransferredTasks(\DateTime $start): array
    {
        $changes = $this->em->getRepository(TaskChange::class)->findTransferredFromWithTasks($start);

        $tasksHash = [];
        $tasks = [];

        foreach ($changes as $change) {
            if (!array_key_exists($change->getTask()->getId(), $tasksHash)) {
                $tasksHash[$change->getTask()->getId()] = $change->getTask();
                $tasks[] = $change->getTask();
            }
        }

        return $tasks;
    }
}
