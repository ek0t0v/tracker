<?php

namespace App\Service\Task;

use App\Entity\Task;
use App\Entity\TaskChange;
use App\Entity\User;
use App\Repository\TaskChangeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class PositionService.
 */
class PositionService
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
     * PositionService constructor.
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
     * todo: Оптимизировать UPDATE-запросы (сейчас выполняются по одному).
     *
     * @param Task      $task
     * @param \DateTime $forDate
     * @param int       $position
     *
     * @return TaskChange
     */
    public function update(Task $task, \DateTime $forDate, int $position): TaskChange
    {
        /**
         * @var TaskChangeRepository $taskChangeRepository
         */
        $taskChangeRepository = $this->em->getRepository(TaskChange::class);

        /**
         * @var User $user
         */
        $user = $this->tokenStorage->getToken()->getUser();

        $changes = $taskChangeRepository->findByForDate($forDate, $user);
        $currentChange = null;

        /**
         * @var TaskChange $change
         */
        foreach ($changes as $change) {
            if ($change->getTask() === $task) {
                $currentChange = $change;

                $currentChange->setPosition($position);

                $this->em->persist($currentChange);

                continue;
            }

            if ($change->getPosition() >= $position) {
                $change->setPosition($change->getPosition() + 1);

                $this->em->persist($change);
            }
        }

        if (is_null($currentChange)) {
            $currentChange = new TaskChange();
            $currentChange->setTask($task);
            $currentChange->setForDate($forDate);
            $currentChange->setPosition($position);

            $this->em->persist($currentChange);
        }

        $this->em->flush();

        return $currentChange;
    }
}
