<?php

namespace App\Http\Request\Task;

use App\Http\RequestDTOInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MoveTaskRequest.
 */
class MoveTaskRequest implements RequestDTOInterface
{
    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(0)
     */
    public $position;
}
