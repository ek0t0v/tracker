<?php

namespace Task\Entity;

use Doctrine\ORM\Mapping as ORM;
use User\Entity\User;

/**
 * Class TaskEvent.
 *
 * @ORM\Table(name="task_events")
 * @ORM\Entity(repositoryClass="Task\Repository\TaskEventRepository")
 */
class TaskEvent
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
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * createTask
     * renameTask
     * removeTask
     * cancelTask
     * updateRepeatType
     * updateRepeatValue.
     *
     * @var string
     *
     * @ORM\Column(name="event", type="string")
     */
    private $event;

    /**
     * @var array
     *
     * @ORM\Column(name="data", type="json")
     */
    private $data;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;
}
