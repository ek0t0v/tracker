<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TaskChange.
 *
 * @ORM\Table(name="task_changes")
 * @ORM\Entity(repositoryClass="App\Repository\TaskChangeRepository")
 */
class TaskChange
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
     * @ORM\Column(name="for_date", type="date")
     */
    private $forDate;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return \DateTime|null
     */
    public function getForDate(): ?\DateTime
    {
        return $this->forDate;
    }

    /**
     * @param \DateTime $forDate
     *
     * @return TaskChange
     */
    public function setForDate(\DateTime $forDate): self
    {
        $this->forDate = $forDate;

        return $this;
    }
}
