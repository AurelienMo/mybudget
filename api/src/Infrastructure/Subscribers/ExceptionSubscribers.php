<?php

namespace MyBudget\Infrastructure\Subscribers;

use MyBudget\Domain\Exceptions\Http\AbstractHttpBadRequestException;
use MyBudget\Domain\Exceptions\Http\AbstractHttpConflictException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscribers implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onException',
            KernelEvents::RESPONSE => 'onResponse',
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $statusCode = $exception->getCode() >= 400 ? $exception->getCode() : 500;
        $message = $exception->getMessage();
        if ($exception instanceof AbstractHttpConflictException) {
            $statusCode = $exception->getStatusCode();
            $message = json_encode($exception->getData());
        } else if ($exception instanceof AbstractHttpBadRequestException) {
            $statusCode = $exception->getStatusCode();
            $message = json_encode($exception->getErrors());
        }

        $event->setResponse(new Response($message, $statusCode, ['Content-Type' => 'application/json']));
    }

    public function onResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        $response->headers->set('Content-Type', 'application/json');

        $event->setResponse($response);
    }
}
