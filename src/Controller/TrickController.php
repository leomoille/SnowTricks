<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickSearchType;
use App\Form\TrickType;
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
     * @return Response
     */
    public function tricks(TrickRepository $trickRepository): Response
    {
        $lastTricks = $trickRepository->findAll();

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
     * @Route("/trick/{slug}/edit", name="app_edit_trick", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        Trick $trick,
        TrickRepository $trickRepository,
    ): Response {
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('image');

            foreach ($images as $image) {
                if (null !== $image->getData()->getFileContent()) {
                    $file = md5(uniqid()).'.'.$image->get('fileContent')->getData()->guessExtension();
                    $image->get('fileContent')->getData()->move(
                        $this->getParameter('trick_images_directory'),
                        $file
                    );
                    $image->getData()->setFilename($file);
//                    $trick->addImage($image->getData());
                }
            }
            $trickRepository->add($trick);

            return $this->redirectToRoute('app_trick', ['slug' => $trick->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/edit.html.twig', [
            'trick' => $trick,
            'trickForm' => $form,
        ]);
    }

    /**
     * @Route("/trick/ajouter", name="app_add_trick")
     */
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('image');

            foreach ($images as $image) {
                $file = $image->get('fileContent')->getData();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('trick_images_directory'),
                    $fileName
                );

                $img = $image->getData();
                $img->setFilename($fileName);

                $trick->addImage($img);
            }

            $slugger = new AsciiSlugger();

            $trick->setCreatedAt(new DateTime());
            $trick->setSlug($slugger->slug($trick->getName()))
                ->setAuthor($this->getUser());
            $manager->persist($trick);

            $manager->flush();

            return $this->redirectToRoute('app_trick', ['slug' => $trick->getSlug()]);
        }

        return $this->render(
            'trick/add.html.twig',
            [
                'trickForm' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/trick/{slug}", name="app_delete_trick", methods={"POST"})
     */
    public function delete(Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $trickRepository->remove($trick);
        }

        return $this->redirectToRoute('app_tricks', [], Response::HTTP_SEE_OTHER);
    }

}
