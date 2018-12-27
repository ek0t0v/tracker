<?php

namespace App\Service\Task;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class CreateTaskService.
 */
class CreateTaskService
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
     * CreateTaskService constructor.
     *
     * @param EntityManagerInterface $em
     * @param TokenStorageInterface  $tokenStorage
     */
    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param string         $name
     * @param \DateTime      $startDate
     * @param \DateTime|null $endDate
     * @param array|null     $schedule
     *
     * @return Task
     */
    public function create(string $name, \DateTime $startDate, \DateTime $endDate = null, array $schedule = null): Task
    {
        /**
         * @var User $user
         */
        $user = $this->tokenStorage->getToken()->getUser();

        $task = new Task();
        $task->setUser($user);
        $task->setName($name);
        $task->setStartDate($startDate);
        $task->setEndDate($endDate);
        $task->setSchedule($schedule);

        $this->em->persist($task);

        $this->em->flush();

        return $task;
    }
}
