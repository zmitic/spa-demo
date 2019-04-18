<?php

declare(strict_types=1);

namespace App\EventSubscriber\KernelReset;

use Symfony\Component\Cache\ResettableInterface;
use Symfony\Contracts\Service\ResetInterface;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;
use function var_dump;

class EMResetter implements ResetInterface, ResettableInterface
{
    private $entryPointLookup;

    public function __construct(EntrypointLookupInterface $entryPointLookup)
    {
        $this->entryPointLookup = $entryPointLookup;
    }

    public function reset()
    {
        var_dump(123);
        $this->entryPointLookup->reset();
    }
}
