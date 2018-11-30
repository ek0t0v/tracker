<?php

namespace App\Service\Task;

use App\Entity\Task;
use App\Response\Task\TaskDto;
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
     * @var TaskTransferServiceInterface
     */
    private $taskTransferService;

    /**
     * TaskService constructor.
     *
     * @param EntityManagerInterface       $em
     * @param TokenStorageInterface        $tokenStorage
     * @param TaskScheduleServiceInterface $taskScheduleService
     * @param TaskChangeServiceInterface $taskChangeService
     * @param TaskTransferServiceInterface $taskTransferService
     */
    public function __construct(
        EntityManagerInterface $em,
        TokenStorageInterface $tokenStorage,
        TaskScheduleServiceInterface $taskScheduleService,
        TaskChangeServiceInterface $taskChangeService,
        TaskTransferServiceInterface $taskTransferService
    ) {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->taskScheduleService = $taskScheduleService;
        $this->taskChangeService = $taskChangeService;
        $this->taskTransferService = $taskTransferService;
    }

    /**
     * {@inheritdoc}
     */
    public function get(\DateTime $start, \DateTime $end = null): array
    {
        $tasks = $this->em->getRepository(Task::class)->findByDate($start);
        $transferredTasks = $this->taskTransferService->findTransferredTasks($start);
        $tasks = $this->taskScheduleService->filter($tasks, $start);
        $tasks = $this->taskTransferService->filterTransferredTasks($tasks, $start);
        $tasks = array_merge($tasks, $transferredTasks);

        $result = [];

        foreach ($tasks as $task) {
            // применить изменения и создать DTO

            $result[] = new TaskDto($task->getId(), $task->getName(), 'in_progress', 0);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $name, \DateTime $startDate, \DateTime $endDate = null, array $schedule = null): TaskDto
    {
    }

    /**
     * {@inheritdoc}
     */
    public function rename(Task $task, string $name): TaskDto
    {
    }
}
