<?php

namespace App\Response\Task;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class TaskDto.
 */
class TaskDto
{
    /**
     * @var int
     *
     * @Groups({"api"})
     */
    public $id;

    /**
     * @var string
     *
     * @Groups({"api"})
     */
    public $name;

    /**
     * @var string
     *
     * @Groups({"api"})
     */
    public $state;

    /**
     * @var \DateTime
     *
     * @Groups({"api"})
     */
    public $start;

    /**
     * @var \DateTime|null
     *
     * @Groups({"api"})
     */
    public $end = null;

    /**
     * @var \DateTime
     *
     * @Groups({"api"})
     */
    public $forDate;

    /**
     * @var array|null
     *
     * @Groups({"api"})
     */
    public $schedule = null;

    /**
     * @var int|null
     *
     * @Groups({"api"})
     */
    public $position = null;
}
