<?php

namespace App\Service\Task;

use App\Entity\Task;
use App\Entity\TaskTransfer;
use App\Entity\User;
use App\Repository\TaskRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Service\Schedule\Context;

/**
 * Class GetByDateService.
 */
class GetByDateService
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
     * GetByDateService constructor.
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

        // модифицировать $date на основе часового пояса пользователя

        $tasksWithoutTransfers = $this->getActualTasksWithoutTransfers($date, $allTasks);

        // добавить задачи, которые были перенесены на $date

        return [];
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @throws \Exception
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

        // модифицировать $start и $end на основе часового пояса пользователя

        // Увеличивает на 1 секунду, чтобы период включал в себя последний день.
        $end->setTime(0, 0, 1);
        $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);

        foreach (array_reverse(iterator_to_array($period)) as $date) {
            $tasksWithoutTransfers = $this->getActualTasksWithoutTransfers($date, $allTasks);

            // добавляем задачи, которые были перенесены на $date
        }

        return [];
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
            $actualTransfers = array_filter($task->getTransfers(), function (TaskTransfer $transfer) use ($date) {
                return $transfer->getForDate() == $date;
            });

            if (!empty($actualTransfers)) {
                continue;
            }

            if (is_null($task->getRepeatType()) && $task->getStartDate() == $date) {
                $result[] = $task;
            }

            if ($task->getRepeatType()) {
                $this->scheduleContext->setContextByTaskRepeatType($task->getRepeatType());

                if ($this->scheduleContext->isScheduled($date)) {
                    $result[] = $task;
                }
            }
        }

        return $result;
    }
}
