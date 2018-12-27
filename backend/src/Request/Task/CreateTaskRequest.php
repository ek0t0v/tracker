<?php

namespace App\Request\Task;

use App\Http\RequestDtoInterface;
use App\Validator\Constraints\NotBlankIfNotNull;
use App\Validator\Constraints\TaskRepeatValue;
use App\Validator\Constraints\TaskSchedule;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreateTaskRequest.
 */
class CreateTaskRequest implements RequestDtoInterface
{
    /**
     * @var string
     *
     * @Assert\NotNull
     * @Assert\Type("string")
     */
    public $name;

    /**
     * @var \DateTime
     *
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Date
     */
    public $start;

    /**
     * @var \DateTime|null
     *
     * @NotBlankIfNotNull
     * @Assert\Date
     */
    public $end;

    /**
     * @var string|null
     *
     * @NotBlankIfNotNull
     * @Assert\Choice(callback={"App\Doctrine\DBAL\Type\TaskRepeatTypeType", "getChoices"})
     */
    public $repeatType;

    /**
     * @var array|null
     *
     * @Assert\Type("array")
     * @TaskRepeatValue
     */
    public $repeatValue;

    /**
     * @var array|null
     *
     * @Assert\Type("array")
     * @TaskSchedule
     */
    public $schedule;
}
