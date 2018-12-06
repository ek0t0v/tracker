<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Task.
 *
 * @ORM\Table(name="tasks")
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\EntityListeners({"App\Doctrine\EventListener\TaskListener"})
 */
class Task
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date")
     */
    private $startDate;

    /**
     * Удаления как такового не будет - чтобы удалить задачу, нужно установить endDate.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $endDate;

    /**
     * Если расписания нет - то задача одноразовая.
     *
     * @var int[]|null
     *
     * @ORM\Column(name="schedule", type="array", nullable=true)
     */
    private $schedule;

    /**
     * @var TaskChange[]
     *
     * @ORM\OneToMany(targetEntity="TaskChange", mappedBy="task")
     */
    private $changes;

    /**
     * @var TaskTransfer[]
     *
     * @ORM\OneToMany(targetEntity="TaskTransfer", mappedBy="task")
     */
    private $transfers;

    /**
     * @var TaskTiming[]
     *
     * @ORM\OneToMany(targetEntity="TaskTiming", mappedBy="task")
     */
    private $timings;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * Task constructor.
     */
    public function __construct()
    {
        $this->changes = new ArrayCollection();
        $this->timings = new ArrayCollection();
        $this->transfers = new ArrayCollection();
    }

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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Task
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     *
     * @return Task
     */
    public function setStartDate(\DateTime $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime|null $endDate
     *
     * @return Task
     */
    public function setEndDate(?\DateTime $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getSchedule(): ?array
    {
        return $this->schedule;
    }

    /**
     * @param array|null $schedule
     *
     * @return Task
     */
    public function setSchedule(?array $schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return Task
     */
    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
     * @return Task
     */
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     *
     * @return Task
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|TaskChange[]
     */
    public function getChanges(): Collection
    {
        return $this->changes;
    }

    /**
     * @param TaskChange $change
     *
     * @return Task
     */
    public function addChange(TaskChange $change): self
    {
        if (!$this->changes->contains($change)) {
            $this->changes[] = $change;
            $change->setTask($this);
        }

        return $this;
    }

    /**
     * @param TaskChange $change
     *
     * @return Task
     */
    public function removeChange(TaskChange $change): self
    {
        if ($this->changes->contains($change)) {
            $this->changes->removeElement($change);
            // set the owning side to null (unless already changed)
            if ($change->getTask() === $this) {
                $change->setTask(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TaskTransfer[]
     */
    public function getTransfers(): Collection
    {
        return $this->transfers;
    }

    /**
     * @param TaskTransfer $transfer
     *
     * @return Task
     */
    public function addTransfer(TaskTransfer $transfer): self
    {
        if (!$this->transfers->contains($transfer)) {
            $this->transfers[] = $transfer;
            $transfer->setTask($this);
        }

        return $this;
    }

    /**
     * @param TaskTransfer $transfer
     *
     * @return Task
     */
    public function removeTransfer(TaskTransfer $transfer): self
    {
        if ($this->transfers->contains($transfer)) {
            $this->transfers->removeElement($transfer);
            // set the owning side to null (unless already changed)
            if ($transfer->getTask() === $this) {
                $transfer->setTask(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TaskTiming[]
     */
    public function getTimings(): Collection
    {
        return $this->timings;
    }

    /**
     * @param TaskTiming $timing
     *
     * @return Task
     */
    public function addTiming(TaskTiming $timing): self
    {
        if (!$this->timings->contains($timing)) {
            $this->timings[] = $timing;
            $timing->setTask($this);
        }

        return $this;
    }

    /**
     * @param TaskTiming $timing
     *
     * @return Task
     */
    public function removeTiming(TaskTiming $timing): self
    {
        if ($this->timings->contains($timing)) {
            $this->timings->removeElement($timing);
            // set the owning side to null (unless already changed)
            if ($timing->getTask() === $this) {
                $timing->setTask(null);
            }
        }

        return $this;
    }
}
