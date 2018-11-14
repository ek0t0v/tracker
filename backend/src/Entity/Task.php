<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Table(name="tasks")
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\EntityListeners({"App\Doctrine\EventListener\TaskListener"})
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"frontend"})
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
     * @ORM\Column(name="name", type="string", nullable=true)
     *
     * @Groups({"frontend"})
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     *
     * @Groups({"frontend"})
     *
     * @Gedmo\SortablePosition()
     */
    private $position;

    /**
     * todo: Определиться, хотим ли мы удалять тайминги, если задача удалена.
     *
     * Возможно, удаление нужно сделать не реальным удалением, а перемещением
     * задачи в архив, т.е. soft delete.
     *
     * @var Timing[]
     *
     * @ORM\OneToMany(targetEntity="Timing", mappedBy="task", orphanRemoval=true)
     */
    private $timings;

    /**
     * Task constructor.
     */
    public function __construct()
    {
        $this->timings = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     *
     * @return Task
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

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
     * @param int $position
     *
     * @return Task
     */
    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return array|Timing[]
     */
    public function getTimings(): array
    {
        return $this->timings;
    }

    /**
     * @param array|Timing[] $timings
     *
     * @return Task
     */
    public function setTimings(array $timings): self
    {
        $this->timings = $timings;

        return $this;
    }

    /**
     * @param Timing $timing
     *
     * @return Task
     */
    public function addTiming(Timing $timing): self
    {
        if (!$this->timings->contains($timing)) {
            $this->timings[] = $timing;
            $timing->setTask($this);
        }

        return $this;
    }

    /**
     * @param Timing $timing
     *
     * @return Task
     */
    public function removeFavoriteItem(Timing $timing): self
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
