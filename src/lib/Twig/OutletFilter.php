<?php

declare(strict_types=1);

namespace App\lib\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use function array_shift;

class OutletFilter extends AbstractExtension
{
    private $requestStack;

    private $twig;

    public function __construct(RequestStack $requestStack, Environment $twig)
    {
        $this->requestStack = $requestStack;
        $this->twig = $twig;
    }

    public function outlet(string $html): string
    {
        $request = $this->getRequest();
        if (!$request) {
            return $html;
        }

        $spaRoutes = $request->attributes->get('spa-routes', []);
        if (!$spaRoutes) {
            return $html;
        }
        ['path' => $routeName, 'params' => $params] = array_shift($spaRoutes);
        $request->attributes->set('spa-routes', $spaRoutes);

        return $this->twig->render('outlet.html.twig', [
            'route_name' => $routeName,
            'route_params' => $params,
            'active_route_name' => $request->attributes->get('_route'),
        ]);
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('outlet', [$this, 'outlet'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    private function getRequest(): ?Request
    {
        $stack = $this->requestStack;

        return $stack->getMasterRequest();
    }
}
