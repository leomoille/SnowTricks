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
//            'Curabitur eu felis quis lacus laoreet condimentum. Pellentesque sit amet.',
//            'Quisque mi ante, dapibus at congue ultrices, eleifend a ante.',
//            'Etiam luctus maximus augue eu venenatis. In dictum pharetra lorem.',
//            'Phasellus vitae suscipit neque. Maecenas et nisi arcu. Nam a.',
//            'Praesent nec enim nec elit sollicitudin venenatis. Donec porttitor est.',
//            'Cras magna dui, semper quis aliquet vel, tempus non velit.',
//            'Etiam bibendum ornare turpis. Sed et imperdiet ex, non bibendum.',
//            'Quia aut aliquam ducimus dignissimos suscipit sit est sit sit.',
//            'Sed efficitur viverra ex quis dictum. Vestibulum rutrum dui urna, vitae.',
//            'Phasellus quis dignissim felis. Lorem ipsum dolor sit amet',
//            'Nulla vestibulum massa massa, nec elementum ',
//            'Mauris vel lacus laoreet, ultrices dolor sit amet, interdum massa.',
//            'Curabitur eu felis quis lacus laoreet condimentum. Pellentesque sit amet.',
//            'Quisque mi ante, dapibus at congue ultrices, eleifend a ante.',
//            'Etiam luctus maximus augue eu venenatis. In dictum pharetra lorem.',
//            'Phasellus vitae suscipit neque. Maecenas et nisi arcu. Nam a.',
//            'Praesent nec enim nec elit sollicitudin venenatis. Donec porttitor est.',
//            'Cras magna dui, semper quis aliquet vel, tempus non velit.',
//            'Etiam bibendum ornare turpis. Sed et imperdiet ex, non bibendum.',
//            'Quia aut aliquam ducimus dignissimos suscipit sit est sit sit.',
//            'Sed efficitur viverra ex quis dictum. Vestibulum rutrum dui urna, vitae.',
//            'Phasellus quis dignissim felis. Lorem ipsum dolor sit amet',
//            'Nulla vestibulum massa massa, nec elementum ',
//            'Mauris vel lacus laoreet, ultrices dolor sit amet, interdum massa.',
//            'Curabitur eu felis quis lacus laoreet condimentum. Pellentesque sit amet.',
//            'Quisque mi ante, dapibus at congue ultrices, eleifend a ante.',
//            'Etiam luctus maximus augue eu venenatis. In dictum pharetra lorem.',
//            'Phasellus vitae suscipit neque. Maecenas et nisi arcu. Nam a.',
//            'Praesent nec enim nec elit sollicitudin venenatis. Donec porttitor est.',
//            'Cras magna dui, semper quis aliquet vel, tempus non velit.',
//            'Etiam bibendum ornare turpis. Sed et imperdiet ex, non bibendum.',
//            'Quia aut aliquam ducimus dignissimos suscipit sit est sit sit.',
//            'Sed efficitur viverra ex quis dictum. Vestibulum rutrum dui urna, vitae.',
//            'Phasellus quis dignissim felis. Lorem ipsum dolor sit amet',
//            'Nulla vestibulum massa massa, nec elementum ',
//            'Mauris vel lacus laoreet, ultrices dolor sit amet, interdum massa.',
//            'Curabitur eu felis quis lacus laoreet condimentum. Pellentesque sit amet.',
//            'Quisque mi ante, dapibus at congue ultrices, eleifend a ante.',
//            'Etiam luctus maximus augue eu venenatis. In dictum pharetra lorem.',
//            'Phasellus vitae suscipit neque. Maecenas et nisi arcu. Nam a.',
//            'Praesent nec enim nec elit sollicitudin venenatis. Donec porttitor est.',
//            'Cras magna dui, semper quis aliquet vel, tempus non velit.',
//            'Etiam bibendum ornare turpis. Sed et imperdiet ex, non bibendum.',
//            'Quia aut aliquam ducimus dignissimos suscipit sit est sit sit.',
//            'Sed efficitur viverra ex quis dictum. Vestibulum rutrum dui urna, vitae.',
//            'Phasellus quis dignissim felis. Lorem ipsum dolor sit amet',
//            'Nulla vestibulum massa massa, nec elementum ',
//            'Mauris vel lacus laoreet, ultrices dolor sit amet, interdum massa.',
//            'Curabitur eu felis quis lacus laoreet condimentum. Pellentesque sit amet.',
//            'Quisque mi ante, dapibus at congue ultrices, eleifend a ante.',
//            'Etiam luctus maximus augue eu venenatis. In dictum pharetra lorem.',
//            'Phasellus vitae suscipit neque. Maecenas et nisi arcu. Nam a.',
//            'Praesent nec enim nec elit sollicitudin venenatis. Donec porttitor est.',
//            'Cras magna dui, semper quis aliquet vel, tempus non velit.',
//            'Etiam bibendum ornare turpis. Sed et imperdiet ex, non bibendum.',
//            'Quia aut aliquam ducimus dignissimos suscipit sit est sit sit.',
//            'Sed efficitur viverra ex quis dictum. Vestibulum rutrum dui urna, vitae.',
//            'Phasellus quis dignissim felis. Lorem ipsum dolor sit amet',
//            'Nulla vestibulum massa massa, nec elementum ',
//            'Mauris vel lacus laoreet, ultrices dolor sit amet, interdum massa.',
//            'Curabitur eu felis quis lacus laoreet condimentum. Pellentesque sit amet.',
//            'Quisque mi ante, dapibus at congue ultrices, eleifend a ante.',
//            'Etiam luctus maximus augue eu venenatis. In dictum pharetra lorem.',
//            'Phasellus vitae suscipit neque. Maecenas et nisi arcu. Nam a.',
//            'Praesent nec enim nec elit sollicitudin venenatis. Donec porttitor est.',
//            'Cras magna dui, semper quis aliquet vel, tempus non velit.',
//            'Etiam bibendum ornare turpis. Sed et imperdiet ex, non bibendum.',
//            'Quia aut aliquam ducimus dignissimos suscipit sit est sit sit.',
//            'Sed efficitur viverra ex quis dictum. Vestibulum rutrum dui urna, vitae.',
//            'Phasellus quis dignissim felis. Lorem ipsum dolor sit amet',
//            'Nulla vestibulum massa massa, nec elementum ',
//            'Mauris vel lacus laoreet, ultrices dolor sit amet, interdum massa.',
//            'Curabitur eu felis quis lacus laoreet condimentum. Pellentesque sit amet.',
//            'Quisque mi ante, dapibus at congue ultrices, eleifend a ante.',
//            'Etiam luctus maximus augue eu venenatis. In dictum pharetra lorem.',
//            'Phasellus vitae suscipit neque. Maecenas et nisi arcu. Nam a.',
//            'Praesent nec enim nec elit sollicitudin venenatis. Donec porttitor est.',
//            'Cras magna dui, semper quis aliquet vel, tempus non velit.',
//            'Etiam bibendum ornare turpis. Sed et imperdiet ex, non bibendum.',
//            'Quia aut aliquam ducimus dignissimos suscipit sit est sit sit.',
//            'Sed efficitur viverra ex quis dictum. Vestibulum rutrum dui urna, vitae.',
//            'Phasellus quis dignissim felis. Lorem ipsum dolor sit amet',
//            'Nulla vestibulum massa massa, nec elementum ',
//            'Mauris vel lacus laoreet, ultrices dolor sit amet, interdum massa.',
//            'Curabitur eu felis quis lacus laoreet condimentum. Pellentesque sit amet.',
//            'Quisque mi ante, dapibus at congue ultrices, eleifend a ante.',
//            'Etiam luctus maximus augue eu venenatis. In dictum pharetra lorem.',
//            'Phasellus vitae suscipit neque. Maecenas et nisi arcu. Nam a.',
//            'Praesent nec enim nec elit sollicitudin venenatis. Donec porttitor est.',
//            'Cras magna dui, semper quis aliquet vel, tempus non velit.',
//            'Etiam bibendum ornare turpis. Sed et imperdiet ex, non bibendum.',
        ];

        for ($i = 0; $i < count($sentences); ++$i) {
            $message = new Message();
            $date = date('Y-m-d H:i:s', mt_rand(1644102000, 1651788000));

            $message
                ->setContent($sentences[$i])
                ->setAuthor($this->getReference(UserFixtures::USER_REFERENCE))
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
