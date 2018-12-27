<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class TaskRepeatValue.
 *
 * @Annotation
 */
class TaskRepeatValue extends Constraint
{
    /**
     * @var string
     */
    public $message = 'Invalid repeatValue.';

    /**
     * @return string
     */
    public function validatedBy(): string
    {
        return 'task_repeat_value';
    }
}
