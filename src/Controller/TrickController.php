<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickSearchType;
use App\Form\TrickType;
use App\Repository\TrickCategoryRepository;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

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
        $lastTricks = $trickRepository->findLastEntry(3);

        $form = $this->createForm(TrickSearchType::class);

        return $this->render('trick/tricks.html.twig', [
            'lastTricks' => $lastTricks,
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

    /**
     * @Route("/trick/ajouter", name="app_add_trick")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function addTrick(Request $request, EntityManagerInterface $manager): Response
    {
        $trick = new Trick();


        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slugger = new AsciiSlugger();
            $trick
                ->setCreatedAt(new \DateTime())
                ->setSlug($slugger->slug($trick->getName()));

            $manager->persist($trick);
            $manager->flush();
        }

        return $this->render('trick/addTrick.html.twig', ['trickForm' => $form->createView()]);
    }
}
