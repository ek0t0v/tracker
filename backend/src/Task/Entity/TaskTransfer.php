<?php

namespace Task\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TaskTransfer.
 *
 * @ORM\Table(name="task_transfers")
 * @ORM\Entity(repositoryClass="Task\Repository\TaskTransferRepository")
 * @ORM\EntityListeners({"Task\Doctrine\EventListener\TaskTransferListener"})
 */
class TaskTransfer
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Task
     *
     * @ORM\ManyToOne(targetEntity="Task")
     * @ORM\JoinColumn(name="task_id", referencedColumnName="id")
     */
    private $task;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="transfer_to", type="date")
     */
    private $transferTo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="for_date", type="date")
     */
    private $forDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTime|null
     */
    public function getTransferTo(): ?\DateTime
    {
        return $this->transferTo;
    }

    /**
     * @param \DateTime $transferTo
     *
     * @return TaskTransfer
     */
    public function setTransferTo(\DateTime $transferTo): self
    {
        $this->transferTo = $transferTo;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getForDate(): ?\DateTime
    {
        return $this->forDate;
    }

    /**
     * @param \DateTime $forDate
     *
     * @return TaskTransfer
     */
    public function setForDate(\DateTime $forDate): self
    {
        $this->forDate = $forDate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return TaskTransfer
     */
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Task|null
     */
    public function getTask(): ?Task
    {
        return $this->task;
    }

    /**
     * @param Task|null $task
     *
     * @return TaskTransfer
     */
    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }
}
