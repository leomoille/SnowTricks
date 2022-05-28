<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Form\TrickSearchType;
use App\Form\TrickType;
use App\Repository\TrickCategoryRepository;
use App\Repository\TrickRepository;
use DateTime;
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
     * @Route("/tricks/{slug}", name="app_trick")
     *
     * @param Trick $trick
     * @return Response
     */
    public function trick(Trick $trick): Response
    {
        return $this->render('trick/trick.html.twig', [
            'trick' => $trick,
        ]);
    }

    /**
     * @Route("/trick/ajouter", name="app_add_trick")
     * @Route("/trick/{slug}/edit", name="app_edit_trick")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function addTrick(Trick $trick = null, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$trick) {
            $trick = new Trick();
        }

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slugger = new AsciiSlugger();

            if (!$trick->getId()) {
                $trick->setCreatedAt(new DateTime());
            }

            $trick->setSlug($slugger->slug($trick->getName()));

            $manager->persist($trick);

            foreach ($form['image'] as $image) {
                $file = $image['content']->getData();

                $extension = $file->guessExtension();
                if (!$extension) {
                    // extension cannot be guessed
                    $extension = 'bin';
                }
                $fileName = md5(uniqid()).'.'.$extension;
                $file->move($this->getParameter('trick_images_directory'), $fileName);

                $trickImage = new Image();
                $trickImage->setName($fileName);
                $trick->addImage($trickImage);
            }

            foreach ($trick->getVideo() as $video) {
                $manager->persist($video);
            }

            foreach ($trick->getImage() as $image) {
                $manager->persist($image);
            }

            $manager->flush();

            return $this->redirectToRoute('app_trick', ['slug' => $trick->getSlug()]);
        }

        return $this->render('trick/addTrick.html.twig', ['trickForm' => $form->createView()]);
    }
}
