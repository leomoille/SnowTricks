<?php

namespace App\Repository;

use App\Entity\TrickCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TrickCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickCategory[]    findAll()
 * @method TrickCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrickCategory::class);
    }

    public function add(TrickCategory $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(TrickCategory $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
