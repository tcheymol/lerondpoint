<?php

namespace App\Repository;

use App\Entity\Track;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Track>
 */
class TrackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Track::class);
    }

    //    /**
    //     * @return Track[] Returns an array of Track objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Track
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /** @return Track[] */
    public function search(string $searchText): array
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.kind', 'k')
            ->innerJoin('t.collective', 'c')
            ->innerJoin('t.createdBy', 'u')
            ->innerJoin('t.tags', 'tg')
            ->where('
                t.name LIKE :searchText
                OR t.description LIKE :searchText
                OR t.location LIKE :searchText
                OR t.region LIKE :searchText
                OR t.year LIKE :searchText
                OR k.name LIKE :searchText
                OR c.name LIKE :searchText
                OR u.email LIKE :searchText
                OR tg.name LIKE :searchText
            ')
            ->setParameter('searchText', '%'.$searchText.'%')
            ->getQuery()
            ->getResult();
    }
}
