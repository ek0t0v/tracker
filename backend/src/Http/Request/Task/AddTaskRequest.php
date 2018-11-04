<?php

namespace App\Http\Request\Task;

use App\Http\RequestDTOInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AddTaskRequest.
 */
class AddTaskRequest implements RequestDTOInterface
{
    /**
     * @var string
     *
     * @Assert\NotNull()
     */
    public $name;
}
