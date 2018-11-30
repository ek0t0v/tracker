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
    private $taskScheduleService;

    /**
     * @var TaskChangeServiceInterface
     */
    private $taskChangeService;

    /**
     * TaskService constructor.
     *
     * @param EntityManagerInterface       $em
     * @param TokenStorageInterface        $tokenStorage
     * @param TaskScheduleServiceInterface $taskScheduleService
     * @param TaskChangeServiceInterface $taskChangeService
     */
    public function __construct(
        EntityManagerInterface $em,
        TokenStorageInterface $tokenStorage,
        TaskScheduleServiceInterface $taskScheduleService,
        TaskChangeServiceInterface $taskChangeService
    ) {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->taskScheduleService = $taskScheduleService;
        $this->taskChangeService = $taskChangeService;
    }

    /**
     * {@inheritdoc}
     */
    public function get(\DateTime $start, \DateTime $end = null): array
    {
        $tasks = $this->em->getRepository(Task::class)->findByDate($start);
        $transferredTasks = $this->taskChangeService->findTransferredTasks($start);
        $tasks = $this->taskScheduleService->filter($tasks, $start);
        $tasks = $this->taskChangeService->filterTransferredTasks($tasks, $start);
        $tasks = array_merge($tasks, $transferredTasks);

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
