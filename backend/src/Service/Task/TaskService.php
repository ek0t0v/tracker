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
     * @param \DateTime      $start
     * @param \DateTime|null $end
     *
     * @return TaskDto[]
     */
    public function get(\DateTime $start, \DateTime $end = null): array
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $tasks = $this->em->getRepository(Task::class)->findByDate($start, $user);

        $result = [];

        foreach ($tasks as $task) {
            if ($this->taskScheduleService->isTaskScheduled($task, $start)) {
                $result[] = $this->taskDtoService->create($task, $start);
            }

            $transfersHash = [];

            // Группирует переносы, превращает цепочки переносов в один перенос.
            foreach ($task->getTransfers() as $transfer) {
                $transfersHash[$transfer->getForDate()->format('Y-m-d')] = $transfer->getTransferTo();
            }

            foreach ($transfersHash as $forDate => $to) {
                // Задача за сегодняшний день перенесена и не вернулась потом на сегодня - убираем задачу.
                if (new \DateTime($forDate) == $start && $to != $start) {
                    unset($result[count($result) - 1]);

                    continue;
                }

                // Задача перенесена на сегодня откуда-нибудь (но не с сегодняшнего дня) - добавляем задачу.
                if ($to == $start) {
                    $result[] = $this->taskDtoService->create($task, new \DateTime($forDate));
                }
            }
        }

        return array_values($result);
    }

    /**
     * @param \DateTime $start
     *
     * @return Task[]
     */
    public function getOverdueTasks(\DateTime $start): array
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
}
