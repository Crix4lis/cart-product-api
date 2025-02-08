<?php
declare(strict_types=1);

namespace Task\App\Common\SymfonyKernelEventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Task\App\Cart\Domain\Exception\TooManyProductsInCartException;
use Task\App\Common\Exception\ConflictException;
use Task\App\Common\Exception\DataLayerException;
use Task\App\Common\Exception\InvalidInputException;
use Task\App\Common\Exception\NotFoundException;

class HandleSymfonyApiErrors
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        if (
            $e instanceof ConflictException ||
            $e instanceof InvalidInputException ||
            $e instanceof TooManyProductsInCartException
        ) {
            $event->setResponse(new JsonResponse(["error_message" => $e->getMessage()], $e->getCode()));
            return;
        }

        if ($e instanceof NotFoundException) {
            $event->setResponse(new JsonResponse([], $e->getCode()));
            return;
        }

        if ($e instanceof DataLayerException) {
            $event->setResponse(new JsonResponse(["error_message" => "Internal server error (db error)"], 500));
            return;
        }

        $event->setResponse(new JsonResponse(["error_message" => "Internal Server error"], 500));
    }
}
