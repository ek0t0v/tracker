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
     * @todo Проверка на существование задачи в этот день - если задачи нет, не можем менять статус в тот день.
     *
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
     * @Assert\Choice(callback={"App\Doctrine\DBAL\Type\TaskChangeStateType", "getChoices"})
     */
    public $state;
}
