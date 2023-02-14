<?php

namespace App\DataFixtures;

use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VideoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $videoLinks = [
            'https://www.youtube.com/watch?v=OMxJRz06Ujc',
            'https://www.youtube.com/watch?v=jm19nEvmZgM',
            'https://www.youtube.com/watch?v=6yA3XqjTh_w',
            'https://www.youtube.com/watch?v=xXCCGYqAWqI',
            'https://www.youtube.com/watch?v=oAK9mK7wWvw',
            'https://www.youtube.com/watch?v=gRZCF5_XRsA',
            'https://www.youtube.com/watch?v=b40a9fCYJ_8',
            'https://www.youtube.com/watch?v=Dxh8u-stXhY',
            'https://www.youtube.com/watch?v=-mMvG4nuGCM',
            'https://www.youtube.com/watch?v=SlhGVnFPTDE',
            'https://www.youtube.com/watch?v=vf9Z05XY79A',
            'https://www.youtube.com/watch?v=k-CoAquRSwY',
        ];

        for ($i = 0; $i < count(TrickFixtures::TRICK_REFERENCE); ++$i) {
            $video = new Video();

            $video->setUrl($videoLinks[$i])
                ->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE[$i]));

            $manager->persist($video);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TrickFixtures::class,
        ];
    }
}
