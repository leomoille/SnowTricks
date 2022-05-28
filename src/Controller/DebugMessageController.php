<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/debug/message")
 */
class DebugMessageController extends AbstractController
{
    /**
     * @Route("/", name="app_debug_message_index", methods={"GET"})
     */
    public function index(MessageRepository $messageRepository): Response
    {
        return $this->render('debug_message/index.html.twig', [
            'messages' => $messageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_debug_message_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MessageRepository $messageRepository): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messageRepository->add($message);

            return $this->redirectToRoute('app_debug_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('debug_message/new.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_debug_message_show", methods={"GET"})
     */
    public function show(Message $message): Response
    {
        return $this->render('debug_message/show.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_debug_message_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Message $message, MessageRepository $messageRepository): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messageRepository->add($message);

            return $this->redirectToRoute('app_debug_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('debug_message/edit.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_debug_message_delete", methods={"POST"})
     */
    public function delete(Request $request, Message $message, MessageRepository $messageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $messageRepository->remove($message);
        }

        return $this->redirectToRoute('app_debug_message_index', [], Response::HTTP_SEE_OTHER);
    }
}
