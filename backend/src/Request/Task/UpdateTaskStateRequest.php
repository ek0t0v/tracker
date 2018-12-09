<?php

namespace App\Request\Task;

use App\Http\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UpdateTaskStateRequest.
 */
class UpdateTaskStateRequest implements RequestDtoInterface
{
    /**
     * @var \DateTime
     *
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Date
     */
    public $forDate;

    /**
     * @var string
     *
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    public $state;
}
