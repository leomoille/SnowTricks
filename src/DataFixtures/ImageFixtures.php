<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $images = [
            'melon-grab.jpg',
            'mute-grab.jpg',
            'indy-grab.jpg',
            'stalefish.jpg',
            'noseslide.png',
            'boardslide.jpg',
            'lipslide.jpg',
            'air-to-fakie.jpg',
            'underflip.webp',
            'backflip.jpg',
            'rodeo.webp',
            'mctwist.jpg',
        ];
        $sideImages = ['trick-placeholder.jpg', 'trick-placeholder-2.jpg'];

        for ($i = 0; $i < count(TrickFixtures::TRICK_REFERENCE); ++$i) {
            $image = new Image();

            $image
                ->setName($images[$i])
                ->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE[$i]))
                ->setIsFeatured(true);
            $manager->persist($image);

            for ($j = 0; $j < count($sideImages); ++$j) {
                $sideImage = new Image();

                $sideImage
                    ->setName($sideImages[$j])
                    ->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE[$i]));

                $manager->persist($sideImage);
            }
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
