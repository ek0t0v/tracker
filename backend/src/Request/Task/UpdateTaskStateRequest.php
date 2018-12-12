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
     * @var string
     *
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Choice(callback={"App\Doctrine\DBAL\Type\TaskChangeStateType", "getChoices"})
     */
    public $state;
}
