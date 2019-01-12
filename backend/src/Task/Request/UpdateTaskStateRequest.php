<?php

namespace Task\Request;

use Common\Http\RequestDtoInterface;
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
     * @Assert\Choice(callback={"Task\Doctrine\DBAL\Type\TaskChangeStateType", "getChoices"})
     */
    public $state;
}
