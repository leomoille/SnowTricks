<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use App\Entity\TrickCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;

class TrickFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tricksLib = [
            'Grabs' => [
                [
                    'name' => 'Melon Grab',
                    'content' => '<p>La main avant sur le bord de votre talon entre vos fixations et voilà, on dirait un melon.</p>',
                ],
                [
                    'name' => 'Mute Grab',
                    'content' => '<p>Essayez d’attraper le bord de l’orteil entre vos pieds avec votre main avant. C’est un Mute Grab.</p>',
                ],
                [
                    'name' => 'Indy Grab',
                    'content' => '<p>Laissez votre bras arrière tomber entre vos genoux pour saisir la planche qui approche. C’est un Indy.</p>',
                ],
                [
                    'name' => 'Stalefish',
                    'content' => '<p>La main arrière sur le bord de votre talon entre vos pieds et... voici un Stalefish !</p>',
                ],
            ],
            'Slides' => [
                [
                    'name' => 'Noseslide',
                    'content' => '<p>C\'est un jib que le rider effectue sur le nose de la planche, soit la spatule qui se trouve devant lui. La spatule arrière s\'appelle le tail. Le noseslide peut être frontside ou backside.</p>',
                ],
                [
                    'name' => 'Boardslide',
                    'content' => '<p>Un slide à connaitre, surtout si tu veux impressionner ton entourage.</p>',
                ],
                [
                    'name' => 'Lipslide',
                    'content' => '<p>Le lispslide consiste à glisser sur un obstacle en mettant la planche perpendiculaire à celui-ci. Un jib à 90 degrés en d\'autres termes. Le lipslide peut se faire en avant ou en arrière. Frontside ou backside, donc.</p>',
                ],
            ],
            'Big Air' => [
                [
                    'name' => 'Air to Fakie',
                    'content' => '<p>Il s\'agit d\'une figure relativement simple, et plus précisément d\'un saut sans rotation qui se fait généralement dans un pipe (un U). Le rider s\'élance dans les airs et retombe dans le sens inverse.</p>',
                ],
                [
                    'name' => 'Underflip',
                    'content' => '<p>Le frontside underflip 540 est une figure qui mêle un frontside 180 et un backflip. Ce trick peut paraître intimidant, mais il n\'est pas si compliqué. Hormis le décollage, bien sûr. Ensuite, les mouvements peuvent s\'enchaîner assez naturellement.</p>',
                ],
                [
                    'name' => 'Wildcat/Backflip',
                    'content' => '<p>Aussi appelé backflip, le wildcat est un salto arrière que le rider effectue dans les airs après avoir pris de la vitesse. C\'est un trick qui peut être difficile à réaliser puisque le snowboardeur doit veiller à rester dans le bon axe.</p>',
                ],
                [
                    'name' => 'Rodeoback / Rodeofront',
                    'content' => '<p>C\'est une figure qui consiste à faire un salto arrière en y ajoutant une rotation d\'un demi-tour. Le rodeo est back quand le snowboarder part de dos et front quand il part de face.</p>',
                ],
                [
                    'name' => 'Mc Twist',
                    'content' => '<p>Le Mc Twist est un flip (rotation verticale) agrémenté d\'une vrille. Un saut plutôt périlleux réservé aux riders les plus confirmés. Le champion Shaun White s\'est illustré par un Double Mc Twist 1260 lors de sa session de Half-Pipe aux Jeux Olympiques de Vancouver en 2010.</p>',
                ],
            ],
        ];
        $slugger = new AsciiSlugger();

        foreach ($tricksLib as $trickCategoryName => $trickInfo) {
            $trickCategory = new TrickCategory();
            $trickCategory
                ->setName($trickCategoryName)
                ->setSlug($slugger->slug(strtolower($trickCategoryName)));

            $manager->persist($trickCategory);

            foreach ($trickInfo as $item) {
                $trick = new Trick();
                $date = date('Y-m-d H:i:s', mt_rand(1644102000, 1651788000));

                $trick
                    ->setName($item['name'])
                    ->setSlug($slugger->slug(strtolower($item['name'])))
                    ->setContent($item['content'])
                    ->setTrickCategory($trickCategory)
                    ->setCreatedAt(new \DateTime($date));

                $manager->persist($trick);
            }
        }

        $manager->flush();
    }
}
