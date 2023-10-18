<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 6;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    public function getTricksPaginator(int $offset): Paginator
    {
        $query = $this->createQueryBuilder('t')
            ->orderBy('t.createdAt', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

    public function add(Trick $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(
        Trick $entity,
        MessageRepository $messageRepository,
        ImageRepository $imageRepository,
        VideoRepository $videoRepository,
        bool $flush = true
    ): void {
        foreach ($entity->getMessages() as $message) {
            $messageRepository->remove($message);
        }

        foreach ($entity->getImage() as $image) {
            $imageRepository->remove($image);
        }

        foreach ($entity->getVideo() as $video) {
            $videoRepository->remove($video);
        }

        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findLastEntry(int $limit)
    {
        return $this->createQueryBuilder('trick')
            ->addOrderBy('trick.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
