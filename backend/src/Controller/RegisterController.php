<?php

namespace App\Controller;

use App\Request\User\UserRegisterRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegisterController.
 *
 * @Route("/api/user")
 */
class RegisterController extends ApiController
{
    /**
     * @param UserRegisterRequest $request
     *
     * @return JsonResponse
     *
     * @Route("/register", name="api_user_register", methods={"POST"})
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        return $this->apiResponse();
    }
}
