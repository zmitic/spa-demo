<?php

declare(strict_types=1);

namespace App\lib\EventListener;

use App\lib\Annotation\Outlet;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class SpaSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

    public function onKernelController(FilterControllerEvent $event): void
    {
        $controller = $event->getController();
    }

    public function onKernelResponse(FilterResponseEvent $event): void
    {
        $request = $event->getRequest();
        if (!$request->isXmlHttpRequest()) {
            return;
        }

        /** @var Outlet|null $outlet */
        $outlet = $request->get('_outlet');
        $routeName = $request->get('_route');
        $response = $event->getResponse();

        $parent = $outlet ? $outlet->getParent() : null;

        $response->headers->set('spa_route', $routeName);
        $response->headers->set('spa_outlet', $parent);
    }
}
