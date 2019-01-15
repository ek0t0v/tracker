<?php

namespace Task\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Class TaskEnd.
 */
class TaskEnd extends Constraint
{
    /**
     * @var string
     */
    public $message = 'End date must be greater than start date.';

    /**
     * @return string
     */
    public function validatedBy(): string
    {
        return 'task_end';
    }
}
