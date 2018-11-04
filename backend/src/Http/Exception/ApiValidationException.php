<?php

namespace App\Http\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ApiValidationException.
 */
class ApiValidationException extends BadRequestHttpException
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $violations;

    /**
     * ApiValidationException constructor.
     *
     * @param ConstraintViolationListInterface $violations
     */
    public function __construct(ConstraintViolationListInterface $violations)
    {
        parent::__construct('Validation Failed', null, 400, []);

        $this->violations = $violations;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
