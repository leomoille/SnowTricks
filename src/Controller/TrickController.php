<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Message;
use App\Entity\Trick;
use App\Entity\User;
use App\Form\MessageType;
use App\Form\TrickSearchType;
use App\Form\TrickType;
use App\Repository\MessageRepository;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;

class TrickController extends AbstractController
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

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
    public function trick(
        Request $request,
        Trick $trick,
        MessageRepository $messageRepository,
        EntityManagerInterface $manager
    ): Response {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $messageRepository->getMessagePaginator($trick, $offset);

        $message = new Message();

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

            return $this->redirectToRoute(
                'app_trick',
                ['slug' => $trick->getSlug(), '_fragment' => 'comment'],
                Response::HTTP_SEE_OTHER
            );
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
            $destination = $this->getParameter('kernel.project_dir').'/public/images/tricks';

            foreach ($form['image'] as $item) {
                /** @var UploadedFile $uploadedFile */
                $uploadedFile = $item['file']->getData();
                dump($item['file']->getData());

                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $this->slugger->slug($originalFilename)
                    .'-'.uniqid()
                    .'.'.$uploadedFile->guessClientExtension();

                $item->getViewData()->setName($newFilename);

                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
            }

            $trick
                ->setCreatedAt(new \DateTime())
                ->setSlug($this->slugger->slug($trick->getName()))
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
