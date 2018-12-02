<?php

namespace App\Request\Task;

use App\Http\RequestDtoInterface;
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
     * @Assert\Date
     */
    public $start;

    /**
     * @var \DateTime|null
     *
     * @Assert\Date
     */
    public $end;

    /**
     * @var array|null
     *
     * @Assert\Type("array")
     * @TaskSchedule
     */
    public $schedule;
}
