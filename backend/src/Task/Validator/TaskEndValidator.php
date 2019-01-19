<?php

namespace Task\Validator;

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Task\Request\CreateTaskRequest;
use Task\Validator\Constraint\TaskEnd;

/**
 * Class TaskEndValidator.
 */
class TaskEndValidator
{
    /**
     * @param CreateTaskRequest         $object
     * @param ExecutionContextInterface $context
     */
    public function validate(CreateTaskRequest $object, ExecutionContextInterface $context)
    {
        if (is_null($object->end) || is_null($object->start)) {
            return;
        }

        try {
            $end = new \DateTime($object->end);
        } catch (\Exception $e) {
            return;
        }

        if (0 === $end->diff(new \DateTime($object->start))->invert) {
            $context->setNode($object->end, $object, null, 'end');
            $constraint = new TaskEnd();
            $context->buildViolation($constraint->message)->addViolation();
        }
    }
}
