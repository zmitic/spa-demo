<?php

declare(strict_types=1);

namespace App\lib\Twig;

use function sprintf;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class OutletFilter extends AbstractExtension
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function outlet(string $html): string
    {
        $request = $this->getRequest();
        if (!$request) {
            return $html;
        }

        $routeName = $request->get('_route');

        return sprintf('<outlet route-name="%s">%s</outlet>', $routeName, $html);
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

        return $stack->getCurrentRequest();
    }
}
