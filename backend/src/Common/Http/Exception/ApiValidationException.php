<?php

namespace Common\Http\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ApiValidationException.
 */
class ApiValidationException extends HttpException
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
        parent::__construct(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            'Validation Failed',
            null,
            [],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );

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
