<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class TaskSchedule.
 *
 * @Annotation
 */
class TaskSchedule extends Constraint
{
    /**
     * @var string
     */
    public $message = 'Invalid schedule.';

    /**
     * @return string
     */
    public function validatedBy(): string
    {
        return 'task_schedule';
    }
}
