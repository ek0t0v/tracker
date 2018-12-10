<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class NotPastValidator.
 */
class NotPastValidator extends ConstraintValidator
{
    /**
     * @param mixed      $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (new \DateTime('midnight') > new \DateTime($value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
