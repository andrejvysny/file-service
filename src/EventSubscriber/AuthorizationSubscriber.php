<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AuthorizationSubscriber implements EventSubscriberInterface
{

    public function onKernelRequest(RequestEvent $event): void
    {
        $key = $event->getRequest()->headers->get('Authorization');


        //TODO: do some verification
        if ($key !== 'mykey'){

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
