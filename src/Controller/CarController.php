<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Car;
use App\lib\Annotation\Outlet;
use App\Repository\CarRepository;
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
    public function index(CarRepository $carRepository): Response
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
    public function reviews(Car $car): Response
    {
        return $this->render('default/reviews.html.twig', [
            'reviews' => $car->getReviews(),
        ]);
    }
}
