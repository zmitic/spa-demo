<?php

declare(strict_types=1);

namespace App\EventSubscriber\KernelReset;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EMResetter implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.reset' => 'onKernelReset'
        ];
    }

    public function onKernelReset(): void
    {
    }
}
