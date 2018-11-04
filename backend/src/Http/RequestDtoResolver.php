<?php

namespace App\Http;

use App\Http\Exception\ApiJsonException;
use App\Http\Exception\ApiValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RequestDtoResolver.
 */
final class RequestDtoResolver implements ArgumentValueResolverInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * RequestDtoResolver constructor.
     *
     * @param SerializerInterface $serializer
     * @param ValidatorInterface  $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        $reflection = new \ReflectionClass($argument->getType());

        return $reflection->implementsInterface(RequestDtoInterface::class);
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        if (!$this->isJson($request->getContent())) {
            throw new ApiJsonException();
        }

        $dto = $this->serializer->deserialize($request->getContent(), $argument->getType(), 'json');
        $violations = $this->validator->validate($dto);

        if (count($violations)) {
            throw new ApiValidationException($violations);
        }

        yield $dto;
    }

    /**
     * @param $string
     *
     * @return bool
     */
    private function isJson($string): bool
    {
        json_decode($string);

        return JSON_ERROR_NONE === json_last_error();
    }
}
