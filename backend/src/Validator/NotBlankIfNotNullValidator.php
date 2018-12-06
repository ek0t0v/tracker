<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class NotBlankIfNotNullValidator.
 */
class NotBlankIfNotNullValidator extends ConstraintValidator
{
    /**
     * @param mixed      $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (is_null($value)) {
            return;
        }

        if ('' === $value) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
