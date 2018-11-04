<?php

namespace App\Request\Task;

use App\Http\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RenameTaskRequest.
 */
class RenameTaskRequest implements RequestDtoInterface
{
    /**
     * @var string
     *
     * @Assert\NotNull()
     */
    public $name;
}
