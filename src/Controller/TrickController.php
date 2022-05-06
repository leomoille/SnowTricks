<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('trick/index.html.twig');
    }

    /**
     * @Route("/tricks", name="app_tricks")
     *
     * @param TrickRepository $trickRepository
     *
     * @return Response
     */
    public function tricks(TrickRepository $trickRepository): Response
    {
        $tricks = $trickRepository->findAll();

        return $this->render('trick/tricks.html.twig', [
            'tricks' => $tricks,
        ]);
    }
}
