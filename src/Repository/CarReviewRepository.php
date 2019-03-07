<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CarReview;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CarReview|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarReview|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarReview[]    findAll()
 * @method CarReview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarReviewRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CarReview::class);
    }


}
