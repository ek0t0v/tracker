<?php

namespace App\Service\Task;

use App\Doctrine\DBAL\Type\TaskChangeActionType;
use App\Entity\TaskChange;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class TaskTransferService.
 */
class TaskTransferService implements TaskTransferServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * TaskTransferService constructor.
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
