<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Trick;
use App\Entity\User;
use App\Form\MessageType;
use App\Form\TrickSearchType;
use App\Form\TrickType;
use App\Repository\MessageRepository;
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
     */
    public function tricks(Request $request, TrickRepository $trickRepository): Response
    {
        // $lastTricks = $trickRepository->findAll();

        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $trickRepository->getTricksPaginator($offset);



        $form = $this->createForm(TrickSearchType::class);

        return $this->render('trick/tricks.html.twig', [
            'lastTricks' => $paginator,
            'searchForm' => $form->createView(),
            'previous' => $offset - TrickRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + TrickRepository::PAGINATOR_PER_PAGE),
        ]);
    }

    /**
     * @Route("/tricks/{slug}", name="app_trick")
     */
    public function trick(Request $request, Trick $trick, MessageRepository $messageRepository, EntityManagerInterface $manager): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $messageRepository->getMessagePaginator($trick, $offset);

        $message = new Message;

        $form = $this->createForm(MessageType::class, $message, ['action' => '#comment-form']);

        $form->handleRequest($request);

        /** @var User $user */
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid() && !is_null($user) && $user->getIsActivated()) {
            $message
                ->setAuthor($this->getUser())
                ->setTrick($trick)
                ->setPublicationDate(new \DateTime());

            $manager->persist($message);

            $manager->flush();

            return $this->redirectToRoute('app_trick', ['slug' => $trick->getSlug(), '_fragment' => 'comment'], Response::HTTP_SEE_OTHER);
        }


        return $this->render('trick/trick.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
            'messages' => $paginator,
            'previous' => $offset - MessageRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + MessageRepository::PAGINATOR_PER_PAGE),
        ]);
    }

    /**
     * @Route("/trick/{slug}/editer", name="app_edit_trick", methods={"GET", "POST"})
     */
    public function edit(Request $request, Trick $trick, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($trick);

            $manager->flush();

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
}
