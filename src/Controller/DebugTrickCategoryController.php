<?php

namespace App\Controller;

use App\Entity\TrickCategory;
use App\Form\TrickCategoryType;
use App\Repository\TrickCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/debug/trick/category")
 */
class DebugTrickCategoryController extends AbstractController
{
    /**
     * @Route("/", name="app_debug_trick_category_index", methods={"GET"})
     */
    public function index(TrickCategoryRepository $trickCategoryRepository): Response
    {
        return $this->render('debug_trick_category/index.html.twig', [
            'trick_categories' => $trickCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_debug_trick_category_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TrickCategoryRepository $trickCategoryRepository): Response
    {
        $trickCategory = new TrickCategory();
        $form = $this->createForm(TrickCategoryType::class, $trickCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trickCategoryRepository->add($trickCategory);

            return $this->redirectToRoute('app_debug_trick_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('debug_trick_category/new.html.twig', [
            'trick_category' => $trickCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_debug_trick_category_show", methods={"GET"})
     */
    public function show(TrickCategory $trickCategory): Response
    {
        return $this->render('debug_trick_category/show.html.twig', [
            'trick_category' => $trickCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_debug_trick_category_edit", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        TrickCategory $trickCategory,
        TrickCategoryRepository $trickCategoryRepository
    ): Response {
        $form = $this->createForm(TrickCategoryType::class, $trickCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trickCategoryRepository->add($trickCategory);

            return $this->redirectToRoute('app_debug_trick_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('debug_trick_category/edit.html.twig', [
            'trick_category' => $trickCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_debug_trick_category_delete", methods={"POST"})
     */
    public function delete(
        Request $request,
        TrickCategory $trickCategory,
        TrickCategoryRepository $trickCategoryRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete'.$trickCategory->getId(), $request->request->get('_token'))) {
            $trickCategoryRepository->remove($trickCategory);
        }

        return $this->redirectToRoute('app_debug_trick_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
