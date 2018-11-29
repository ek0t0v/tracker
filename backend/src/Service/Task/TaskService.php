<?php

namespace App\Service\Task;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class TaskService.
 */
class TaskService implements TaskServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var TaskScheduleServiceInterface
     */
    private $taskSchedule;

    /**
     * TaskService constructor.
     *
     * @param EntityManagerInterface       $em
     * @param TokenStorageInterface        $tokenStorage
     * @param TaskScheduleServiceInterface $taskSchedule
     */
    public function __construct(
        EntityManagerInterface $em,
        TokenStorageInterface $tokenStorage,
        TaskScheduleServiceInterface $taskSchedule
    ) {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->taskSchedule = $taskSchedule;
    }

    /**
     * {@inheritdoc}
     */
    public function get(\DateTime $start, \DateTime $end = null): array
    {
        $tasks = is_null($end)
            ? $this->em->getRepository(Task::class)->findByStartDate($start)
            : $this->em->getRepository(Task::class)->findByDateRange($start, $end);

        $tasks = $this->taskSchedule->filter($tasks, $start);

        return $tasks;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $name, \DateTime $startDate, \DateTime $endDate = null, array $schedule = null): Task
    {
        return new Task();
    }

    /**
     * {@inheritdoc}
     */
    public function rename(Task $task, string $name): Task
    {
        return new Task();
    }
}
