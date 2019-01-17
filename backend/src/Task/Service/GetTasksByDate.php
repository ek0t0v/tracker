<?php

namespace Task\Service;

use Task\Entity\Task;
use Task\Entity\TaskTransfer;
use User\Entity\User;
use Task\Repository\TaskRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Task\Service\Schedule\Context;

/**
 * Class GetTasksByDate.
 */
class GetTasksByDate
{
    /**
     * @var TaskRepository
     */
    private $repository;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var Context
     */
    private $scheduleContext;

    /**
     * GetTasksByDate constructor.
     *
     * @param TaskRepository        $repository
     * @param TokenStorageInterface $tokenStorage
     * @param Context               $scheduleContext
     */
    public function __construct(
        TaskRepository $repository,
        TokenStorageInterface $tokenStorage,
        Context $scheduleContext
    ) {
        $this->repository = $repository;
        $this->tokenStorage = $tokenStorage;
        $this->scheduleContext = $scheduleContext;
    }

    /**
     * @param \DateTime $date
     *
     * @return array
     */
    public function getByDate(\DateTime $date): array
    {
        /**
         * @var User $user
         */
        $user = $this->tokenStorage->getToken()->getUser();
        $allTasks = $this->repository->findAllByUser($user);

        $tasksWithoutTransfers = $this->getActualTasksWithoutTransfers($date, $allTasks);
        $transferredToDateTasks = $this->getTransferredToDateTasks($date, $allTasks);

        return array_merge($tasksWithoutTransfers, $transferredToDateTasks);
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return array
     */
    public function getByDateRange(\DateTime $start, \DateTime $end): array
    {
        /**
         * @var User $user
         */
        $user = $this->tokenStorage->getToken()->getUser();
        $allTasks = $this->repository->findAllByUser($user);

        // Увеличивает на 1 секунду, чтобы период включал в себя последний день.
        $end->setTime(0, 0, 1);

        try {
            $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);
        } catch (\Exception $e) {
            die;
        }

        $result = [];

        /**
         * @var \DateTime $date
         */
        foreach (array_reverse(iterator_to_array($period)) as $date) {
            $tasksWithoutTransfers = $this->getActualTasksWithoutTransfers($date, $allTasks);
            $transferredToDateTasks = $this->getTransferredToDateTasks($date, $allTasks);

            $result[$date->format('Y-m-d')] = array_merge($tasksWithoutTransfers, $transferredToDateTasks);
        }

        return $result;
    }

    /**
     * @param \DateTime $date
     * @param Task[]    $tasks
     *
     * @return array
     */
    private function getActualTasksWithoutTransfers(\DateTime $date, array $tasks): array
    {
        $result = [];

        foreach ($tasks as $task) {
            $transfers = $task->getTransfers()->toArray();
            $actualTransfers = array_filter($transfers, function (TaskTransfer $transfer) use ($date) {
                return $transfer->getForDate() == $date;
            });

            if (!empty($actualTransfers)) {
                continue;
            }

            if (!$task->getRepeatType() && $task->getStartDate() == $date) {
                $result[] = [
                    'task' => $task,
                    'forDate' => $date,
                ];
            }

            if ($task->getRepeatType() && $task->getStartDate() <= $date && (is_null($task->getEndDate()) || $task->getEndDate() >= $date)) {
                $this->scheduleContext->setContextByTaskRepeatType($task->getRepeatType());

                if ($this->scheduleContext->isScheduled($date, $task->getStartDate(), $task->getRepeatValue())) {
                    $result[] = [
                        'task' => $task,
                        'forDate' => $date,
                    ];
                }
            }
        }

        return $result;
    }

    /**
     * @param \DateTime $date
     * @param array     $tasks
     *
     * @return array
     */
    private function getTransferredToDateTasks(\DateTime $date, array $tasks): array
    {
        /**
         * @var User $user
         */
        $user = $this->tokenStorage->getToken()->getUser();

        $timezone = new \DateTimeZone($user->getSettings()->getTimezone());
        $result = [];

        foreach ($tasks as $task) {
            $transfersHash = [];

            /**
             * @var TaskTransfer $transfer
             */
            foreach ($task->getTransfers() as $transfer) {
                $transfersHashKey = $transfer->getForDate()->setTimezone($timezone);

                $transfersHash[$transfersHashKey->format('Y-m-d')] = [
                    'forDate' => $transfersHashKey,
                    'to' => $transfer->getTransferTo()->setTimezone($timezone),
                ];
            }

            foreach ($transfersHash as $transfer) {
                // Задача перенесена на сегодня откуда-нибудь (но не с сегодняшнего дня) - добавляем задачу.
                if ($transfer['to'] == $date) {
                    $result[] = [
                        'task' => $task,
                        'forDate' => $transfer['forDate'],
                    ];
                }
            }
        }

        return $result;
    }
}
