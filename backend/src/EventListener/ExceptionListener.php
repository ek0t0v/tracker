<?php

namespace App\EventListener;

use App\Http\Exception\ApiJsonException;
use App\Http\Exception\ApiValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        switch (true) {
            case $exception instanceof ApiValidationException:
                $result = [];

                foreach ($exception->getViolations() as $violation) {
                    $result[$violation->getPropertyPath()][] = $violation->getMessage();
                }

                $response = $this->buildResponse(
                    'Validation error.',
                    $result
                );

                break;
            case $exception instanceof ApiJsonException:
                $response = $this->buildResponse('Invalid json.');

                break;
            case $exception instanceof NotFoundHttpException:
                $response = $this->buildResponse('Not found.');

                break;
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
     * @param string     $message
     * @param array|null $violations
     *
     * @return JsonResponse
     */
    private function buildResponse(string $message = '', $violations = null): JsonResponse
    {
        $responseArray = [
            'message' => $message,
        ];

        if (!is_null($violations)) {
            $responseArray['violations'] = $violations;
        }

        return new JsonResponse($responseArray);
    }
}
