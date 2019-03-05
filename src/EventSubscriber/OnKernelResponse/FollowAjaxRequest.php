<?php

declare(strict_types=1);

namespace App\EventSubscriber\OnKernelResponse;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class FollowAjaxRequest implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

    public function onKernelResponse(FilterResponseEvent $event): void
    {
        $response = $event->getResponse();

        $response->headers->set('Symfony-Debug-Toolbar-Replace', 1);
    }
}
