<?php

namespace Common\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class NotPast.
 *
 * @Annotation
 */
class NotPast extends Constraint
{
    /**
     * @var string
     */
    public $message = 'Cannot set past date.';

    /**
     * @return string
     */
    public function validatedBy(): string
    {
        return 'not_past';
    }
}
