<?php

declare(strict_types=1);

namespace App\EventSubscriber\KernelReset;

use Symfony\Contracts\Service\ResetInterface;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;

class Resetter implements ResetInterface, EntrypointLookupInterface
{
    private $lookup;

    public function __construct(EntrypointLookupInterface $lookup)
    {
        $this->lookup = $lookup;
    }

    public function reset(): void
    {
        $this->lookup->reset();
    }

    public function getJavaScriptFiles(string $entryName): array
    {
        return $this->lookup->getJavaScriptFiles($entryName);
    }

    public function getCssFiles(string $entryName): array
    {
        return $this->lookup->getCssFiles($entryName);
    }
}
