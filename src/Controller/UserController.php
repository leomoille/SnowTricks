<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AvatarType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserController extends AbstractController
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    /**
     * @Route("/user", name="app_user")
     */
    public function index(Request $request, EntityManagerInterface $manager, Filesystem $filesystem): Response
    {
        $form = $this->createForm(AvatarType::class, $this->getUser());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['avatarFile']->getData();

            $destination = $this->getParameter('kernel.project_dir') . '/public/images/avatar';

            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $this->slugger->slug($originalFilename) . '-' . uniqid() . '.' . $uploadedFile->guessClientExtension();

            $uploadedFile->move(
                $destination,
                $newFilename
            );

            /** @var User $user */
            $user = $this->getUser();

            // If user already as an Avatar, delete old file
            if ($user->getAvatar() !== 'user-placeholder.png') {
                $path = $this->getParameter("avatar_directory") . '/' . $user->getAvatar();

                /** @var Filesystem $filesystem */
                $filesystem->remove($path);
            }

            $user->setAvatar($newFilename);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView()
        ]);
    }
}
