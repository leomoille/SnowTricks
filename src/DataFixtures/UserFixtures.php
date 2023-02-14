<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public const USER_REFERENCE = [
        'user1',
        'user2',
        'user3',
        'user4',
        'user5',
    ];

    private const USERS_DATA = [
        [
            'email' => 'shaunewhite@snow.trick',
            'name' => 'shaunewhite1',
            'password' => 'shaunewhite1',
            'avatar' => 'shaun-white.jfif',
        ],
        [
            'email' => 'markmcmorris@snow.trick',
            'name' => 'markmcmorris42',
            'password' => 'markmcmorris42',
            'avatar' => 'mark-mcmorris.jfif',
        ],
        [
            'email' => 'scottyjames@snow.trick',
            'name' => 'scottyjamesnow',
            'password' => 'scottyjamesnow',
            'avatar' => 'scott-james.jfif',
        ],
        [
            'email' => 'bradmartin@snow.trick',
            'name' => 'bradmartin',
            'password' => 'bradmartin',
            'avatar' => 'brad-martin.jfif',
        ],
        [
            'email' => 'gregbretz@snow.trick',
            'name' => 'gregbretz',
            'password' => 'gregbretz',
            'avatar' => 'greg-bretz.jfif',
        ],
    ];

    private UserPasswordHasherInterface $userPasswordHasherInterface;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public static function getGroups(): array
    {
        return ['user'];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(UserFixtures::USER_REFERENCE); ++$i) {
            $user = new User();

            $user
                ->setEmail(self::USERS_DATA[$i]['email'])
                ->setUsername(self::USERS_DATA[$i]['name'])
                ->setPassword($this->userPasswordHasherInterface->hashPassword($user, self::USERS_DATA[$i]['password']))
                ->setAvatar(self::USERS_DATA[$i]['avatar'])
                ->setIsActivated(true);

            $manager->persist($user);
            $this->addReference(self::USER_REFERENCE[$i], $user);
        }

        $manager->flush();
    }
}
