<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    private string $imagePath;

    public function __construct(ManagerRegistry $registry, string $path)
    {
        parent::__construct($registry, Image::class);
        $this->imagePath = $path;
    }

    public function add(Image $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(Image $entity, bool $flush = true): void
    {
        if ('trick-placeholder.jpg' !== $entity->getName() && 'trick-placeholder-2.jpg' !== $entity->getName()) {
            unlink($this->imagePath.'/'.$entity->getName());
            $this->_em->remove($entity);
            if ($flush) {
                $this->_em->flush();
            }
        }
    }
}
