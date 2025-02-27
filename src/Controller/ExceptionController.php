<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

class ExceptionController extends AbstractController
{
    public function showException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HandlerFailedException && $exception->getPrevious()) {
            $exception = $exception->getPrevious();
        }

        $response = $this->buildResponse($exception);
        $event->setResponse($response);
    }

    private function buildResponse(Throwable $exception): Response
    {
        $body = [
            "message" => $exception->getMessage()
        ];
        $code = !$this->isValidStatusCode($exception->getCode()) ? 500 : $exception->getCode();
        return new JsonResponse($body, $code);
    }

    public static function isValidStatusCode(int $statusCode): bool
    {
        return in_array($statusCode, array_keys(Response::$statusTexts), true);
    }
}
