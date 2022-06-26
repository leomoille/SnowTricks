<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $encoder
    ): Response {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(): Response
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/mot-de-passe-oublie", name="security_forgot_password")
     */
    public function forgotPassword(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData()['email']);

            if ($form->getData()['email'] == $form->getData()['confirmEmail']) {
                $this->addFlash(
                    'notice',
                    'Top, tu vas bientôt pouvoir retrouver ton compte !'
                );
                $email = (new TemplatedEmail())
                    ->from('no-reply@snowtricks.dev')
                    ->to('you@example.com')
                    ->subject('Mot de passe oublié ?')
                    ->htmlTemplate('email/password-recovery.html.twig')
                    ->context([
                        'username' => 'Léo',
                    ]);

                /*
                $dsn = 'smtp://0.0.0.0:1025';
                $transport = Transport::fromDsn($dsn);
                $mailer = new Mailer($transport);
                 */
                $mailer->send($email);
            } else {
                if ($form->getData()['email'] != $form->getData()['confirmEmail']) {
                    $this->addFlash(
                        'warning',
                        'Les deux mails ne correspondent pas...'
                    );
                }
            }
        }

        return $this->render('security/forgot-password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
