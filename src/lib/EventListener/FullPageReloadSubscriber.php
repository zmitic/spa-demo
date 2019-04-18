<?php

declare(strict_types=1);

namespace App\lib\EventListener;

use App\lib\Service\TreeBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;
use function array_reverse;
use function iterator_to_array;

class FullPageReloadSubscriber
{
    private $twig;

    private $treeBuilder;

    public function __construct(Environment $twig, TreeBuilder $treeBuilder)
    {
        $this->twig = $twig;
        $this->treeBuilder = $treeBuilder;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();
        if (!$event->isMasterRequest()) {
            return;
        }
        if ($request->isXmlHttpRequest()) {
            return;
        }
        $route = $request->attributes->get('_route');
        $routesToRender = $this->treeBuilder->getTree($request, $route);
        $routes = iterator_to_array($routesToRender);
        $routes = array_reverse($routes);
        if (!$routes) {
            return;
        }

        $request->attributes->set('spa-routes', $routes);
        $html = $this->twig->render('base.html.twig');

        $response = new Response($html);
        $event->setResponse($response);
    }
}
