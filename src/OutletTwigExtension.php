<?php

declare(strict_types=1);

namespace App;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class OutletTwigExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('outlet', [$this, 'outlet'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    public function outlet(): string
    {
        return '<div></div>';
    }
}
