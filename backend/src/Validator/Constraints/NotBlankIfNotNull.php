<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class NotBlankIfNotNull.
 *
 * @Annotation
 */
class NotBlankIfNotNull extends Constraint
{
    /**
     * @var string
     */
    public $message = 'This value should not be blank.';

    /**
     * @return string
     */
    public function validatedBy(): string
    {
        return 'not_blank_if_not_null';
    }
}
