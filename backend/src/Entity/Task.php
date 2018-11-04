<?php

namespace App\Entity;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
