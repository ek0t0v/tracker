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
        if (in_array($request->getMethod(), ['POST', 'PUT']) && !$this->isJson($request->getContent())) {
            throw new ApiJsonException();
        }

        $bodyAsArray = json_decode($request->getContent(), true);

        $data = !is_null($bodyAsArray)
            ? json_encode(array_merge($bodyAsArray, $request->query->all()))
            : json_encode($request->query->all());

        $dto = $this->serializer->deserialize($data, $argument->getType(), 'json');
        $violations = $this->validator->validate($dto);

        if (count($violations)) {
            throw new ApiValidationException($violations);
        }

        yield $dto;
    }

    /**
     * @param string $string
     *
     * @return bool
     */
    private function isJson(string $string): bool
    {
        json_decode($string);

        return JSON_ERROR_NONE === json_last_error();
    }
}
