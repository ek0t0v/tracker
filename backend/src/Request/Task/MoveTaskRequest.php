<?php

namespace App\Request\Task;

use App\Http\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MoveTaskRequest.
 */
class MoveTaskRequest implements RequestDtoInterface
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
