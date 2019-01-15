<?php

namespace Task\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class TaskRepeatValueValidator.
 */
class TaskRepeatValueValidator extends ConstraintValidator
{
    /**
     * @param mixed      $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!is_array($value)) {
            return;
        }

        if (count($value) < 2 || !in_array(1, $value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
