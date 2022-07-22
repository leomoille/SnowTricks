<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user';

    private $userPasswordHasherInterface;
    private $tokenGenerator;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface, TokenGeneratorInterface $tokenGenerator)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user
            ->setEmail('user1@email.dev')
            ->setUsername('User1')
            ->setPassword($this->userPasswordHasherInterface->hashPassword($user, 'user1'))
            ->setIsActivated(true);

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::USER_REFERENCE, $user);
    }
}
