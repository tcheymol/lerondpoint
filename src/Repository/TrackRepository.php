<?php

namespace App\Repository;

use App\Entity\Track;
use App\Entity\User;
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

    public function findAdjacentValidatedTrackId(Track $track, Order $order): ?int
    {
        /** @var Track|null $sibling */
        $sibling = $this->createQueryBuilder('t')
            ->andWhere(sprintf('t.id %s :currentId', $order->value === Order::Ascending->value ? '>' : '<'))
            ->andWhere('t.validated = 1 AND t.rejected = 0 AND t.isDraft = 0')
            ->setParameter('currentId', $track->getId())
            ->orderBy('t.id', $order->value)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $sibling?->getId();
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

    /** @return Track[] */
    public function findRejected(): array
    {
        /** @var Track[] $tracks */
        $tracks = $this->createQueryBuilder('t')
            ->addSelect('c')
            ->leftJoin('t.collective', 'c')
            ->andWhere('t.rejected = 1')
            ->orderBy('t.id', 'DESC')
            ->getQuery()
            ->getResult();

        return $tracks;
    }

    /** @return Track[] */
    public function findToModerate(?User $assignee = null, bool $unassigned = false): array
    {
        $qb = $this->createQueryBuilder('t')
            ->addSelect('c')
            ->leftJoin('t.collective', 'c')
            ->andWhere('t.validated = 0 AND t.rejected = 0 AND t.isDraft = 0');

        if ($unassigned) {
            $qb->andWhere('t.assignedTo IS NULL');
        } elseif (null !== $assignee) {
            $qb->andWhere('t.assignedTo = :assignee')
                ->setParameter('assignee', $assignee);
        }

        /** @var Track[] $tracks */
        $tracks = $qb->getQuery()->getResult();

        return $tracks;
    }

    public function getNumber(Track $track): ?int
    {
        return (int) $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->andWhere('t.id <= :trackId')
            ->andWhere('t.validated = 1 AND t.rejected = 0 AND t.isDraft = 0')
            ->setParameter('trackId', $track->getId())
            ->getQuery()
            ->getSingleScalarResult();
    }
}
