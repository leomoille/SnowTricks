<?php

namespace App\DataFixtures;

use App\DataFixtures\TrickFixtures;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VideoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $videoLink = 'https://www.youtube.com/watch?v=ScMzIvxBSi4';

        for ($i = 0; $i < 12; $i++) {
            $video = new Video();

            $video->setUrl($videoLink)
                ->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE[$i]));

            $manager->persist($video);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TrickFixtures::class
        ];
    }
}
