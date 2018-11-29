<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TaskChange.
 *
 * @ORM\Table(name="task_changes")
 * @ORM\Entity(repositoryClass="App\Repository\TaskChangeRepository")
 * @ORM\EntityListeners({"App\Doctrine\EventListener\TaskChangeListener"})
 */
class TaskChange
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
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
     * @see TaskChangeActionType
     *
     * @var string
     *
     * @ORM\Column(name="action", type="task_change_action")
     */
    private $action;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="task_change_state", nullable=true)
     */
    private $state;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="transfer_from", type="date", nullable=true)
     */
    private $transferFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="transfer_to", type="date", nullable=true)
     */
    private $transferTo;

    /**
     * За какой день изменение.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="for_date", type="datetime")
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
     * @return null|string
     */
    public function getAction(): ?string
    {
        return $this->action;
    }

    /**
     * @param string $action
     *
     * @return TaskChange
     */
    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     *
     * @return TaskChange
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param null|string $state
     *
     * @return TaskChange
     */
    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int|null $position
     *
     * @return TaskChange
     */
    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getTransferFrom(): ?\DateTimeInterface
    {
        return $this->transferFrom;
    }

    /**
     * @param \DateTimeInterface|null $transferFrom
     *
     * @return TaskChange
     */
    public function setTransferFrom(?\DateTimeInterface $transferFrom): self
    {
        $this->transferFrom = $transferFrom;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getTransferTo(): ?\DateTimeInterface
    {
        return $this->transferTo;
    }

    /**
     * @param \DateTimeInterface|null $transferTo
     *
     * @return TaskChange
     */
    public function setTransferTo(?\DateTimeInterface $transferTo): self
    {
        $this->transferTo = $transferTo;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getForDate(): ?\DateTimeInterface
    {
        return $this->forDate;
    }

    /**
     * @param \DateTimeInterface $forDate
     *
     * @return TaskChange
     */
    public function setForDate(\DateTimeInterface $forDate): self
    {
        $this->forDate = $forDate;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     *
     * @return TaskChange
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
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
     * @return TaskChange
     */
    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }
}
