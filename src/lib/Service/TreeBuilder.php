<?php

declare(strict_types=1);

namespace App\lib\Service;

use App\lib\Annotation\Outlet;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;
use Generator;
use ReflectionMethod;

class TreeBuilder
{
    private $reader;

    private $router;

    public function __construct(Reader $reader, RouterInterface $router)
    {
        $this->reader = $reader;
        $this->router = $router;
    }

    public function getTree(Request $request, string $routeName): Generator
    {
        $routeCollection = $this->router->getRouteCollection();
        $route = $routeCollection->get($routeName);
        if (!$route) {
            return null;
        }

        if (!$outlet = $this->getOutlet($route)) {
            return;
        }

        $compiledRoute = $route->compile();
        $pathVariables = $compiledRoute->getPathVariables();
        $params = [];
        foreach ($pathVariables as $pathVariable) {
            $params[$pathVariable] = $request->get($pathVariable);
        }

        yield $routeName => ['path' => $routeName, 'params' => $params];

        $parent = $outlet->getParent();
        if (!$parent) {
            return;
        }

        yield from $this->getTree($request, $parent);
    }

    private function getOutlet(Route $route): ?Outlet
    {
        [$controllerName, $methodName] = explode('::', $route->getDefault('_controller'));
        if (!class_exists($controllerName)) {
            return null;
        }
        $reflectionMethod = new ReflectionMethod($controllerName, $methodName);
        /** @var Outlet|null $outlet */
        $outlet = $this->reader->getMethodAnnotation($reflectionMethod, Outlet::class);

        return $outlet;
    }
}
