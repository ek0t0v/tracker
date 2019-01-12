<?php

namespace Common\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ApiController.
 */
abstract class ApiController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * ApiController constructor.
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array $data
     * @param array $groups
     * @param int   $statusCode
     *
     * @return JsonResponse
     */
    public function apiResponse($data = [], array $groups = ['api'], int $statusCode = Response::HTTP_OK): JsonResponse
    {
        $json = $this->serializer->serialize($data, 'json', ['groups' => $groups]);

        $response = JsonResponse::fromJsonString($json);
        $response->setStatusCode($statusCode);

        return $response;
    }
}
