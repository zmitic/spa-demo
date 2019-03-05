<?php

declare(strict_types=1);

namespace App\lib\Annotation;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationAnnotation;

/**
 * @Annotation
 */
class Outlet extends ConfigurationAnnotation
{
    /**
     * @var string
     */
    private $parent;

    public function getAliasName(): string
    {
        return 'outlet';
    }

    public function allowArray(): bool
    {
        return false;
    }

    public function setParent(string $parent): void
    {
        $this->parent = $parent;
    }

    public function getParent(): string
    {
        return $this->parent;
    }
}
