<?php

namespace App\EventListener\Kernel\Exception;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

#[AsEventListener('kernel.exception')]
class ApiExceptionJsonResponse
{
    public function __invoke(ExceptionEvent $event)
    {
        $request = $event->getRequest();
        $isApiRoute = !\str_starts_with($request->getPathInfo(), '/api');
        if ($isApiRoute) {
            return;
        }

        $exception = $event->getThrowable();
        $response = new JsonResponse([
            'ok' => false,
            'response' => $exception->getMessage(),
        ]);
        if ($exception instanceof HttpException) {
            $response->setStatusCode($exception->getStatusCode());
        }

        $event->setResponse($response);
    }
}
