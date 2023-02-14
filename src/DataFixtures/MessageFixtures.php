<?php

namespace App\DataFixtures;

use App\Entity\Message;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $sentences = [
            'Super figure !',
            'Trop dur...',
            'Réussi après une bonne heure !',
            'Plus simple qu\'il n\'y parait',
            'Trop trop trop cool à faire',
            'Sympa comme figure',
            'Comment vous faites ? Sérieusement ?',
            'ok, je n\'y arriverais jamais',
            'ez, je le rentre depuis 2 saisons',
            'Tellement classe',
            'Bien joué !',
            'Vous réussissez toujours du premier coup ?',
            'N\'oubliez pas de bien fléchir !',
            'Le planté de baton !',
            'J\'ai failli finir à l\'hosto avec ce trick',
            'Toujours cool à poser',
            'Parfait à faire en session',
            'J\'ai un pote qui galère à le poser',
            'Une dinguerie cette figure',
            'Trop facile, faut que j\'en apprenne d\'autres',
            'Ce trick est vraiment top',
        ];

        shuffle($sentences);

        for ($i = 0; $i < count($sentences); ++$i) {
            $message = new Message();
            $date = date('Y-m-d H:i:s', mt_rand(1644102000, 1651788000));

            $message
                ->setContent($sentences[$i])
                ->setAuthor($this->getReference(UserFixtures::USER_REFERENCE[array_rand(UserFixtures::USER_REFERENCE)]))
                ->setTrick(
                    $this->getReference(TrickFixtures::TRICK_REFERENCE[array_rand(TrickFixtures::TRICK_REFERENCE)])
                )
                ->setPublicationDate(new \DateTime($date));

            $manager->persist($message);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            TrickFixtures::class,
        ];
    }
}
