<?php

namespace Task\Service;

use Task\Doctrine\DBAL\Type\TaskChangeStateType;
use Task\Entity\Task;
use Task\Entity\TaskChange;
use Task\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class GetOverdueService.
 */
class GetOverdueService
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
     * GetOverdueService constructor.
     *
     * @param EntityManagerInterface $em
     * @param TokenStorageInterface  $tokenStorage
     */
    public function __construct(
        EntityManagerInterface $em,
        TokenStorageInterface $tokenStorage
    ) {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @throws \Exception
     *
     * @return array
     */
    public function get(): array
    {
        /**
         * @var TaskRepository $taskRepository
         */
        $taskRepository = $this->em->getRepository(Task::class);
        $tasks = $taskRepository->findOverdueTasks($this->tokenStorage->getToken()->getUser());

        $tasksHash = [];
        $yesterday = new \DateTime();
        $yesterday->add(\DateInterval::createFromDateString('yesterday'));
        $oneDayInterval = new \DateInterval('P1D');

        /**
         * @var Task $task
         */
        foreach ($tasks as $task) {
            $period = new \DatePeriod($task->getStartDate(), $oneDayInterval, $yesterday);

            foreach (array_reverse(iterator_to_array($period)) as $date) {
                /**
                 * @var TaskChange[] $changes
                 */
                $changes = array_filter($task->getChanges()->toArray(), function (TaskChange $change) use ($date) {
                    return $change->getForDate() == $date;
                });

                $changes = array_values($changes);
                $change = count($changes) > 0 ? $changes[0] : null;

                if ($task->isScheduled($date) && (is_null($change) || TaskChangeStateType::IN_PROGRESS === $change->getState())) {
                    $tasksHash[] = [
                        'task' => $task,
                        'forDate' => $date,
                        'date' => $date,
                    ];

                    $transfersHash = [];

                    // Группирует переносы, превращает цепочки переносов в один перенос.
                    foreach ($task->getTransfers() as $transfer) {
                        $transfersHash[$transfer->getForDate()->format('Y-m-d')] = $transfer->getTransferTo();
                    }

                    foreach ($transfersHash as $forDate => $to) {
                        // Задача перенесена на сегодня откуда-нибудь (но не с сегодняшнего дня) - добавляем задачу.
                        if ($to == $date) {
                            $tasksHash[] = [
                                'task' => $task,
                                'forDate' => new \DateTime($forDate),
                                'date' => $date,
                            ];
                        }
                    }
                }
            }
        }

        return $tasksHash;
    }
}
