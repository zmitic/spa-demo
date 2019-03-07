<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository")
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /** @ORM\Column(type="string", nullable=false) */
    private $name;

    /** @ORM\Column(type="string", nullable=false) */
    private $description;

    /** @ORM\OneToMany(targetEntity="CarReview", mappedBy="car") */
    private $reviews;

    public function __construct(string $name, string  $description)
    {
        $this->name = $name;
        $this->reviews = new ArrayCollection();
        $this->description = $description;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /** @return CarReview[] */
    public function getReviews(): array
    {
        return $this->reviews->toArray();
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
