<?php

namespace App\DataFixtures;

use App\Entity\TrickCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;

class TrickCategoryFixtures extends Fixture implements FixtureGroupInterface
{
    public const TRICKCATEGORY_REFFERENCE = [
        'grab',
        'flip',
        'slide',
    ];

    // TODO: ASCIISluger à instancier dans le constructeur

    public static function getGroups(): array
    {
        return ['user'];
    }

    public function load(ObjectManager $manager): void
    {
        $slugger = new AsciiSlugger();

        for ($i = 0; $i < count(self::TRICKCATEGORY_REFFERENCE); ++$i) {
            $trickCategory = new TrickCategory();

            $trickCategory->setName(ucfirst(self::TRICKCATEGORY_REFFERENCE[$i]))
                ->setSlug($slugger->slug(strtolower(self::TRICKCATEGORY_REFFERENCE[$i])));

            $manager->persist($trickCategory);

            $this->addReference(self::TRICKCATEGORY_REFFERENCE[$i], $trickCategory);
        }

        $manager->flush();
    }
}
