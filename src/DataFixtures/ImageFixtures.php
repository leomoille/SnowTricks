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
        $images = ['snow.jpg', 'snow-2.jpg'];

        for ($i = 0; $i < count(TrickFixtures::TRICK_REFERENCE); ++$i) {
            for ($j = 0; $j < count($images); ++$j) {
                $image = new Image();

                if (0 == $j) {
                    $image->setIsFeatured(true);
                }

                $image
                    ->setFilename($images[$j])
                    ->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE[$i]));
                $manager->persist($image);
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
