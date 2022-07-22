<?php

namespace App\DataFixtures;

use App\Entity\TrickCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;

class TrickCategoryFixtures extends Fixture
{
    public const TRICKCATEGORY_REFFERENCE = [
        'trick-category-one',
        'trick-category-two',
        'trick-category-tree'
    ];

    // ASCIISluger à instencier dans le constructeur

    public function load(ObjectManager $manager): void
    {
        $categories = ['Catégorie Une', 'Categorie Deux', 'Catégorie Trois'];
        $slugger = new AsciiSlugger();

        for ($i = 0; $i < count($categories); $i++) {
            $trickCategory = new TrickCategory();

            $trickCategory->setName($categories[$i])
                ->setSlug($slugger->slug(strtolower($categories[$i])));

            $manager->persist($trickCategory);

            $this->addReference(self::TRICKCATEGORY_REFFERENCE[$i], $trickCategory);
        }

        $manager->flush();
    }
}
