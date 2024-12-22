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

    /** @return Track[] */
    public function findMissingPreviews(): array
    {
        /** @var Track[] $tracks */
        $tracks = $this->createQueryBuilder('t')
            ->innerJoin('t.attachments', 'a')
            ->andWhere('a.thumbnailObjectId IS NULL
                OR a.mediumThumbnailObjectId IS NULL
                OR a.bigThumbnailObjectId IS NULL')
            ->getQuery()
            ->getResult();

        return $tracks;
    }
}
