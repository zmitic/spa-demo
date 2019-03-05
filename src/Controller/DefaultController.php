<?php

declare(strict_types=1);

namespace App\Controller;

use App\lib\Annotation\Outlet;
use function random_int;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'var' => '333',
        ]);
    }

    /**
     * @Route("/testing", name="default_testing")
     *
     * @Outlet(parent="default")
     */
    public function testing(): Response
    {
        return $this->render('default/testing.html.twig', [
            'random' => random_int(1, 10000),
        ]);
    }

    /**
     * @Route("/testing/sub_testing", name="default_sub_testing")
     *
     * @Outlet(parent="default_testing")
     */
    public function subTesting(): Response
    {
        return $this->render('default/sub_testing.html.twig', [
            'random' => random_int(1, 10000),
        ]);
    }
}
