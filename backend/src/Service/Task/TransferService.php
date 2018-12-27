<?php

namespace App\Service\Task;

use App\Entity\Task;
use App\Entity\TaskTransfer;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class TransferService.
 */
class TransferService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * TransferService constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @todo Сделать ограничения на перемещение задач, например, нельзя перемещать готовые/отмененные задачи.
     *
     * @param Task      $task
     * @param \DateTime $forDate
     * @param \DateTime $to
     *
     * @return TaskTransfer
     */
    public function transfer(Task $task, \DateTime $forDate, \DateTime $to): TaskTransfer
    {
        $transfer = new TaskTransfer();
        $transfer->setTask($task);
        $transfer->setForDate($forDate);
        $transfer->setTransferTo($to);

        $this->em->persist($transfer);

        $this->em->flush();

        return $transfer;
    }
}
