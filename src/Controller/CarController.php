<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Car;
use App\Entity\CarReview;
use App\EventSubscriber\KernelReset\EMResetter;
use App\Repository\CarRepository;
use App\Repository\CarReviewRepository;
use HTC\SpaBundle\Annotation\Outlet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{

    /**
     * @Route("/", name="default")
     *
     * @Outlet(parent=null)
     */
    public function index(CarRepository $carRepository, EMResetter $EMResetter): Response
    {
        return $this->render('default/index.html.twig', [
            'cars' => $carRepository->findAll(),
        ]);
    }

    /**
     * @Route("/detailed/{id}", name="car_detailed")
     *
     * @Outlet(parent="default")
     */
    public function detailed(Car $car): Response
    {
        return $this->render('default/detailed.html.twig', [
            'car' => $car,
        ]);
    }

    /**
     * @Route("/detailed/{id}/reviews", name="car_reviews")
     *
     * @Outlet(parent="car_detailed")
     */
    public function reviews(Car $car, CarReviewRepository $repository): Response
    {
        $reviews = $repository->createQueryBuilder('o')
            ->addSelect('car')
            ->leftJoin('o.car', 'car')
            ->where('o.car = :car')->setParameter('car', $car)
            ->getQuery()->getResult();

        return $this->render('default/reviews.html.twig', [
            'reviews' => $reviews,
            'car' => $car,
        ]);
    }

    /**
     * @Route("/detailed/{id}/reviews/{review_id}", name="car_review_one")
     *
     * @Entity(name="carReview", expr="repository.find(review_id)")
     *
     * @Outlet(parent="car_reviews")
     */
    public function review(CarReview $carReview): Response
    {
        return $this->render('default/review_one.html.twig', [
            'review' => $carReview,
        ]);
    }
}
