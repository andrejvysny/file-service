<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AccessSubscriber implements EventSubscriberInterface
{

    private const ALLOWED_CLIENTS = [
        '127.0.0.1',
        "172.21.0.1"
    ];


    public function onKernelRequest(RequestEvent $event): void
    {

        $client = $event->getRequest()->getClientIp();

        if (!in_array($client, self::ALLOWED_CLIENTS)){

            $event->setResponse(new JsonResponse());
        }
        // ...
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
