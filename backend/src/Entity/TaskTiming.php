<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TaskTiming.
 *
 * @ORM\Table(name="task_timings")
 * @ORM\Entity(repositoryClass="App\Repository\TaskTimingRepository")
 */
class TaskTiming
{
    /**
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
     * @ORM\Column(name="started_at", type="datetime")
     */
    private $startedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ended_at", type="datetime")
     */
    private $endedAt;

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
     * @return TaskTiming
     */
    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getStartedAt(): ?\DateTime
    {
        return $this->startedAt;
    }

    /**
     * @param \DateTime $startedAt
     *
     * @return TaskTiming
     */
    public function setStartedAt(\DateTime $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getEndedAt(): ?\DateTime
    {
        return $this->endedAt;
    }

    /**
     * @param \DateTime $endedAt
     *
     * @return TaskTiming
     */
    public function setEndedAt(\DateTime $endedAt): self
    {
        $this->endedAt = $endedAt;

        return $this;
    }
}
