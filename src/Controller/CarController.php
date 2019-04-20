<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Car;
use App\Entity\CarReview;
use App\Repository\CarRepository;
use App\Repository\CarReviewRepository;
use HTC\SpaBundle\Annotation\Outlet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

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
     * @Route("/car/{id}", name="car_menu")
     *
     * @Outlet(parent="default")
     */
    public function carMenu(Car $car, Request $request): Response
    {
        return $this->render('default/car_menu.html.twig', [
            'car' => $car,
        ]);
    }

    /**
     * @Route("/car/{id}/detailed", name="car_detailed")
     *
     * @Outlet(parent="car_menu")
     */
    public function detailed(Car $car): Response
    {
        return $this->render('default/detailed.html.twig', [
            'car' => $car,
        ]);
    }

    /**
     * @Route("/car/{id}/reviews", name="car_reviews")
     *
     * @Outlet(parent="car_menu")
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
     * @Route("/car/{id}/reviews/new_review", name="car_write_review")
     *
     * @Outlet(parent="car_reviews")
     */
    public function writeReview(Car $car, Request $request): Response
    {

        $form = $this->createFormBuilder(null)
            ->add('body', TextType::class, [
                'constraints' => [
                    new Length(['min' => 3])
                ]
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('car_reviews', ['id' => $car->getId()]);
        }

        return $this->render('default/review_new.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/car/{id}/reviews/{review_id}", name="car_review_one")
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
