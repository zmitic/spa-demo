<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarReviewRepository")
 */
class CarReview
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Car", inversedBy="reviews")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $car;

    /** @ORM\Column(type="text", nullable=false) */
    private $review;

    public function __construct(Car $car, string  $review)
    {
        $this->car = $car;
        $this->review = $review;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getReview(): string
    {
        return $this->review;
    }

    public function getCar(): Car
    {
        return $this->car;
    }
}
