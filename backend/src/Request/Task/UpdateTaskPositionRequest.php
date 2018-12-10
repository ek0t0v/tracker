<?php

namespace App\Request\Task;

use App\Http\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UpdateTaskPositionRequest.
 */
class UpdateTaskPositionRequest implements RequestDtoInterface
{
    /**
     * @todo Проверка на существование задачи в этот день - если задачи нет, не можем менять позицию в тот день.
     *
     * @var \DateTime
     *
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Date
     */
    public $forDate;

    /**
     * @var int
     *
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Type("integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    public $position;
}
