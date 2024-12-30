<?php

namespace App\Repository;

use App\Entity\Track;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Order;
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

    public function findPreviousValidatedTrack(Track $track): ?Track
    {
        return $this->findAdjacentValidatedTrack($track, Order::Descending);
    }

    public function findNextValidatedTrack(Track $track): ?Track
    {
        return $this->findAdjacentValidatedTrack($track, Order::Ascending);
    }

    private function findAdjacentValidatedTrack(Track $track, Order $order): ?Track
    {
        /** @var ?Track $track */
        $track = $this->createQueryBuilder('t')
            ->andWhere(sprintf('t.id %s :currentId', $order->value === Order::Ascending->value ? '>' : '<'))
            ->andWhere('t.validated = 1')
            ->setParameter('currentId', $track->getId())
            ->orderBy('t.id', $order->value)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $track;
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
