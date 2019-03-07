<?php

declare(strict_types=1);

namespace App\lib\EventListener;

use App\lib\Service\TreeBuilder;
use function dump;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;
use function array_reverse;
use function iterator_to_array;

class PartialLoadSubscriber implements EventSubscriberInterface
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
        // only when loaded via ajax
        if (!$request->isXmlHttpRequest()) {
            return;
        }

        $activeRouteName = $request->headers->get('active');
        if (!$activeRouteName) {
            return;
        }
        $routeToJump = $request->attributes->get('_route');
        if ($activeRouteName === $routeToJump) {
            $event->setResponse(new Response());

            return;
        }

        $tree = $this->treeBuilder->getTree($request, $routeToJump);

        $routes = iterator_to_array($tree);
        $routes = array_reverse($routes);
        dump('From: '.$activeRouteName, 'To: '.$routeToJump, $routes);
        $event->setResponse(new Response());

        return;
        if ($this->isDownTheTree($routes, $activeRouteName, $routeToJump)) {
        }

        if (!$routes) {
            return;
        }

        $request->attributes->set('spa-routes', $routes);
        $html = $this->twig->render('root.html.twig');

        $response = new Response($html);
        $event->setResponse($response);
    }

    private function isDownTheTree(array $tree, $activeRouteName, $routeToJump)
    {
    }
}
