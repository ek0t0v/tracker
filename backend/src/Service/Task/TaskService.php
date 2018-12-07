<?php

namespace App\Service\Task;

use App\Entity\Task;
use App\Response\Task\TaskDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class TaskService.
 */
class TaskService
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
     * @var TaskScheduleService
     */
    private $taskScheduleService;

    /**
     * @var TaskChangeService
     */
    private $taskChangeService;

    /**
     * @var TaskDtoService
     */
    private $taskDtoService;

    /**
     * TaskService constructor.
     *
     * @param EntityManagerInterface $em
     * @param TokenStorageInterface  $tokenStorage
     * @param TaskScheduleService    $taskScheduleService
     * @param TaskChangeService      $taskChangeService
     * @param TaskDtoService         $taskDtoService
     */
    public function __construct(
        EntityManagerInterface $em,
        TokenStorageInterface $tokenStorage,
        TaskScheduleService $taskScheduleService,
        TaskChangeService $taskChangeService,
        TaskDtoService $taskDtoService
    ) {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->taskScheduleService = $taskScheduleService;
        $this->taskChangeService = $taskChangeService;
        $this->taskDtoService = $taskDtoService;
    }

    /**
     * @param \DateTime $date
     *
     * @return TaskDto[]
     */
    public function getTasksByDate(\DateTime $date): array
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $tasks = $this->em->getRepository(Task::class)->findByStartDate($date, $user);

        return $this->getActualTasksAsDtoByDate($tasks, $date);
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @throws \Exception
     *
     * @return TaskDto[]
     */
    public function getTasksByDateRange(\DateTime $start, \DateTime $end): array
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $tasks = $this->em->getRepository(Task::class)->findByStartDate($start, $user);

        // Увеличивает end на 1 секунду, чтобы период включал в себя последний день.
        $end->setTime(0, 0, 1);

        $oneDayInterval = new \DateInterval('P1D');
        $period = new \DatePeriod($start, $oneDayInterval, $end);

        $result = [];

        foreach ($period as $date) {
            $resultsForDate = $this->getActualTasksAsDtoByDate($tasks, $date);

            foreach ($resultsForDate as $dto) {
                $result[] = $dto;
            }
        }

        return $result;
    }

    /**
     * @return TaskDto[]
     */
    public function getOverdueTasks(): array
    {
        return [];
    }

    /**
     * @param string         $name
     * @param \DateTime      $startDate
     * @param \DateTime|null $endDate
     * @param array|null     $schedule
     *
     * @return TaskDto
     */
    public function create(string $name, \DateTime $startDate, \DateTime $endDate = null, array $schedule = null): TaskDto
    {
        $task = new Task();
        $task->setUser($this->tokenStorage->getToken()->getUser());
        $task->setName($name);
        $task->setStartDate($startDate);
        $task->setEndDate($endDate);
        $task->setSchedule($schedule);

        $this->em->persist($task);

        $this->em->flush();

        return $this->taskDtoService->create($task);
    }

    /**
     * @param array     $tasks
     * @param \DateTime $date
     *
     * @return TaskDto[]
     */
    private function getActualTasksAsDtoByDate(array $tasks, \DateTime $date): array
    {
        $result = [];

        /**
         * @var Task $task
         */
        foreach ($tasks as $task) {
            if ($this->taskScheduleService->isTaskScheduled($task, $date)) {
                $result[] = $this->taskDtoService->create($task, $date);
            }

            $transfersHash = [];

            // Группирует переносы, превращает цепочки переносов в один перенос.
            foreach ($task->getTransfers() as $transfer) {
                $transfersHash[$transfer->getForDate()->format('Y-m-d')] = $transfer->getTransferTo();
            }

            foreach ($transfersHash as $forDate => $to) {
                // Задача за сегодняшний день перенесена и не вернулась потом на сегодня - убираем задачу.
                if (new \DateTime($forDate) == $date && $to != $date) {
                    unset($result[count($result) - 1]);

                    continue;
                }

                // Задача перенесена на сегодня откуда-нибудь (но не с сегодняшнего дня) - добавляем задачу.
                if ($to == $date) {
                    $result[] = $this->taskDtoService->create($task, new \DateTime($forDate));
                }
            }
        }

        return array_values($result);
    }
}
