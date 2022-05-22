<?php

namespace App\Controller;

use App\Form\TrickSearchType;
use App\Repository\TrickCategoryRepository;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @Route("/tricks", name="app_tricks")
     *
     * @param TrickRepository $trickRepository
     * @param TrickCategoryRepository $trickCategoryRepository
     * @return Response
     */
    public function tricks(TrickRepository $trickRepository, TrickCategoryRepository $trickCategoryRepository): Response
    {
        // NOTE: Est-ce la façon la plus propre de récupérer un ID pour faire une recherche ?
        // TODO: Récupérer d'abord les catégories puis les figures | Utiliser un foreach !

        $lastTricks = $trickRepository->findLastEntry(3);

        $lastGrabs = $trickRepository->findBy(
            ['trickCategory' => $trickCategoryRepository->findOneBy(['name' => 'Grabs'])->getId()],
            ['createdAt' => 'DESC'],
            3
        );
        $lastSlides = $trickRepository->findBy(
            ['trickCategory' => $trickCategoryRepository->findOneBy(['name' => 'Slides'])->getId()],
            ['createdAt' => 'DESC'],
            3
        );
        $lastBigAir = $trickRepository->findBy(
            ['trickCategory' => $trickCategoryRepository->findOneBy(['name' => 'Big Air'])->getId()],
            ['createdAt' => 'DESC'],
            3
        );

        $form = $this->createForm(TrickSearchType::class);

        return $this->render('trick/tricks.html.twig', [
            'lastTricks' => $lastTricks,
            'grabs' => $lastGrabs,
            'slides' => $lastSlides,
            'bigair' => $lastBigAir,
            'searchForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tricks/{trickSlug}", name="app_trick")
     *
     * @return Response
     */
    public function trick(): Response
    {
        return $this->render('trick/trick.html.twig');
    }
}
