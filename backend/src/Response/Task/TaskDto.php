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
     * @var int
     *
     * @Groups({"api"})
     */
    public $position;

    /**
     * TaskDto constructor.
     *
     * @param int    $id
     * @param string $name
     * @param string $state
     * @param int    $position
     */
    public function __construct(int $id, string $name, string $state, int $position)
    {
        $this->id = $id;
        $this->name = $name;
        $this->state = $state;
        $this->position = $position;
    }
}
