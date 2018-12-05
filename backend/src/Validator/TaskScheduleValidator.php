<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class TaskScheduleValidator.
 */
class TaskScheduleValidator extends ConstraintValidator
{
    /**
     * @param mixed      $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        // В CreateTaskRequest есть проверка schedule на тип - должно быть массивом,
        // однако срабатывает и TaskSchedule проверка.
        // @todo Придумать как поправить assert'ы, убрать is_array отсюда.
        if (!is_array($value)) {
            return;
        }

        if (0 === count($value)) {
            $this->context->buildViolation($constraint->message)->addViolation();

            return;
        }

        $invalidSchedule = true;

        foreach ($value as $item) {
            if (1 === $item) {
                $invalidSchedule = false;

                break;
            }
        }

        if ($invalidSchedule) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
