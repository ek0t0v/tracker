<?php

namespace App\EventListener;

use App\Http\Exception\ApiJsonException;
use App\Http\Exception\ApiValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Class ExceptionListener.
 */
class ExceptionListener
{
    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $response = null;

        if ($exception instanceof ApiValidationException) {
            $result = [];

            foreach ($exception->getViolations() as $violation) {
                $result[$violation->getPropertyPath()][] = $violation->getMessage();
            }

            $response = $this->buildResponse(
                0,
                'Validation error.',
                Response::HTTP_UNPROCESSABLE_ENTITY,
                $result
            );
        }

        if ($exception instanceof ApiJsonException) {
            $response = $this->buildResponse(0, 'Invalid json.');
        }

        if ($response) {
            $response->setStatusCode($this->getStatusCode($exception));
            $event->setResponse($response);
        }
    }

    /**
     * @param \Exception $exception
     *
     * @return int
     */
    private function getStatusCode(\Exception $exception): int
    {
        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    /**
     * @param int    $code
     * @param string $message
     * @param int    $status
     * @param array  $violations
     *
     * @return JsonResponse
     */
    private function buildResponse(
        int $code = 0,
        string $message = '',
        int $status = Response::HTTP_BAD_REQUEST,
        array $violations = []
    ): JsonResponse {
        return new JsonResponse([
            'code' => $code,
            'message' => $message,
            'violations' => $violations,
            'status' => $status,
        ]);
    }
}
