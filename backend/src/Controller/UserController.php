<?php

namespace App\Controller;

use App\Request\User\UserRegisterRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController.
 *
 * @Route("/api/users")
 */
class UserController extends ApiController
{
    /**
     * @param UserRegisterRequest $request
     *
     * @return JsonResponse
     *
     * @Route(name="api_user_register", methods={"POST"})
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        return $this->apiResponse(null, ['frontend'], Response::HTTP_CREATED);
    }
}
