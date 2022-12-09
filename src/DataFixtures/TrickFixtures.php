<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    public const TRICK_REFERENCE = [
        'trick1',
        'trick2',
        'trick3',
        'trick4',
        'trick5',
        'trick6',
        'trick7',
        'trick8',
        'trick9',
        'trick10',
        'trick11',
        'trick12',
    ];

    public function load(ObjectManager $manager): void
    {
        $tricksList = [
            [
                'name' => 'Melon Grab',
                'content' => 'La main avant sur le bord de votre talon entre vos fixations et voilà, on dirait un melon.',
            ],
            [
                'name' => 'Mute Grab',
                'content' => 'Essayez d’attraper le bord de l’orteil entre vos pieds avec votre main avant. C’est un Mute Grab.',
            ],
            [
                'name' => 'Indy Grab',
                'content' => 'Laissez votre bras arrière tomber entre vos genoux pour saisir la planche qui approche. C’est un Indy.',
            ],
            [
                'name' => 'Stalefish',
                'content' => 'La main arrière sur le bord de votre talon entre vos pieds et... voici un Stalefish !',
            ],
            [
                'name' => 'Noseslide',
                'content' => 'C\'est un jib que le rider effectue sur le nose de la planche, soit la spatule qui se trouve devant lui. La spatule arrière s\'appelle le tail. Le noseslide peut être frontside ou backside.',
            ],
            [
                'name' => 'Boardslide',
                'content' => 'Un slide à connaitre, surtout si tu veux impressionner ton entourage.',
            ],
            [
                'name' => 'Lipslide',
                'content' => 'Le lispslide consiste à glisser sur un obstacle en mettant la planche perpendiculaire à celui-ci. Un jib à 90 degrés en d\'autres termes. Le lipslide peut se faire en avant ou en arrière. Frontside ou backside, donc.',
            ],
            [
                'name' => 'Air to Fakie',
                'content' => 'Il s\'agit d\'une figure relativement simple, et plus précisément d\'un saut sans rotation qui se fait généralement dans un pipe (un U). Le rider s\'élance dans les airs et retombe dans le sens inverse.',
            ],
            [
                'name' => 'Underflip',
                'content' => 'Le frontside underflip 540 est une figure qui mêle un frontside 180 et un backflip. Ce trick peut paraître intimidant, mais il n\'est pas si compliqué. Hormis le décollage, bien sûr. Ensuite, les mouvements peuvent s\'enchaîner assez naturellement.',
            ],
            [
                'name' => 'Wildcat/Backflip',
                'content' => 'Aussi appelé backflip, le wildcat est un salto arrière que le rider effectue dans les airs après avoir pris de la vitesse. C\'est un trick qui peut être difficile à réaliser puisque le snowboardeur doit veiller à rester dans le bon axe.',
            ],
            [
                'name' => 'Rodeoback / Rodeofront',
                'content' => 'C\'est une figure qui consiste à faire un salto arrière en y ajoutant une rotation d\'un demi-tour. Le rodeo est back quand le snowboarder part de dos et front quand il part de face.',
            ],
            [
                'name' => 'Mc Twist',
                'content' => 'Le Mc Twist est un flip (rotation verticale) agrémenté d\'une vrille. Un saut plutôt périlleux réservé aux riders les plus confirmés. Le champion Shaun White s\'est illustré par un Double Mc Twist 1260 lors de sa session de Half-Pipe aux Jeux Olympiques de Vancouver en 2010.',
            ],
        ];
        $slugger = new AsciiSlugger();

        for ($i = 0; $i < count($tricksList); ++$i) {
            $date = date('Y-m-d H:i:s', mt_rand(1644102000, 1651788000));
            $trick = new Trick();

            $trick
                ->setName($tricksList[$i]['name'])
                ->setSlug($slugger->slug(strtolower($tricksList[$i]['name'])))
                ->setTrickCategory($this->getReference(TrickCategoryFixtures::TRICKCATEGORY_REFFERENCE[mt_rand(0, 2)]))
                ->setAuthor($this->getReference(UserFixtures::USER_REFERENCE))
                ->setContent($tricksList[$i]['content'])
                ->setCreatedAt(new \DateTime($date));

            $manager->persist($trick);
            $this->addReference(self::TRICK_REFERENCE[$i], $trick);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            TrickCategoryFixtures::class,
        ];
    }
}
