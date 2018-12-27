<?php

namespace App\Service\Task;

use App\Dto\ApiResponse\TaskDto;
use App\Entity\Task;
use App\Entity\TaskTransfer;
use App\Repository\TaskRepository;
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
     * @var DtoService
     */
    private $taskDtoService;

    /**
     * TaskService constructor.
     *
     * @param EntityManagerInterface $em
     * @param TokenStorageInterface  $tokenStorage
     * @param DtoService             $taskDtoService
     */
    public function __construct(
        EntityManagerInterface $em,
        TokenStorageInterface $tokenStorage,
        DtoService $taskDtoService
    ) {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->taskDtoService = $taskDtoService;
    }

    /**
     * @param \DateTime $date
     *
     * @return TaskDto[]
     */
    public function getTasksByDate(\DateTime $date): array
    {
        /**
         * @var TaskRepository $taskRepository
         */
        $taskRepository = $this->em->getRepository(Task::class);
        $tasks = $taskRepository->findByStartDate($date, $this->tokenStorage->getToken()->getUser());

        $resultsForDate = $this->getActualTasksByDate($tasks, $date);
        $dto = [];

        foreach ($resultsForDate as $result) {
            $dto[] = $this->taskDtoService->create($result['task'], $result['forDate'], $date);
        }

        return $this->sortByPosition($dto);
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
        /**
         * @var TaskRepository $taskRepository
         */
        $taskRepository = $this->em->getRepository(Task::class);
        $tasks = $taskRepository->findByStartDate($start, $this->tokenStorage->getToken()->getUser());

        // Увеличивает на 1 секунду, чтобы период включал в себя последний день.
        $end->setTime(0, 0, 1);

        $oneDayInterval = new \DateInterval('P1D');
        $period = new \DatePeriod($start, $oneDayInterval, $end);

        $dto = [];

        foreach (array_reverse(iterator_to_array($period)) as $date) {
            $dtoByDate = [];

            foreach ($this->getActualTasksByDate($tasks, $date) as $result) {
                $dtoByDate[] = $this->taskDtoService->create($result['task'], $result['forDate'], $date);
            }

            foreach ($this->sortByPosition($dtoByDate) as $item) {
                $dto[] = $item;
            }
        }

        return $dto;
    }

    /**
     * @todo Сделать ограничения на перемещение задач, например, нельзя перемещать готовые/отмененные задачи.
     *
     * @param Task      $task
     * @param \DateTime $forDate
     * @param \DateTime $to
     *
     * @return TaskDto
     */
    public function transferTask(Task $task, \DateTime $forDate, \DateTime $to): TaskDto
    {
        $transfer = new TaskTransfer();
        $transfer->setTask($task);
        $transfer->setForDate($forDate);
        $transfer->setTransferTo($to);

        $this->em->persist($transfer);

        $this->em->flush();

        return $this->taskDtoService->create($task, $task->getStartDate());
    }

    /**
     * @param array     $tasks
     * @param \DateTime $date
     *
     * @return array
     */
    private function getActualTasksByDate(array $tasks, \DateTime $date): array
    {
        $result = [];

        /**
         * @var Task $task
         */
        foreach ($tasks as $task) {
            if ($task->isScheduled($date)) {
                $result[] = [
                    'task' => $task,
                    'forDate' => $date,
                ];
            }

            $transfersHash = [];

            // Группирует переносы, превращает цепочки переносов в один перенос.
            foreach ($task->getTransfers() as $transfer) {
                $transfersHash[$transfer->getForDate()->format('Y-m-d')] = $transfer->getTransferTo();
            }

            foreach ($transfersHash as $forDate => $to) {
                // Задача перенесена на сегодня откуда-нибудь (но не с сегодняшнего дня) - добавляем задачу.
                if ($to == $date) {
                    $result[] = [
                        'task' => $task,
                        'forDate' => new \DateTime($forDate),
                    ];
                }
            }
        }

        return $result;
    }

    /**
     * @param TaskDto[] $tasks
     *
     * @return TaskDto[]
     */
    private function sortByPosition(array $tasks): array
    {
        $result = array_filter($tasks, function ($task) {
            return is_null($task->position);
        });

        foreach ($tasks as $task) {
            if (!is_null($task->position)) {
                array_splice($result, $task->position, 0, [$task]);
            }
        }

        return $result;
    }
}
