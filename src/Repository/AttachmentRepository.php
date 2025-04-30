<?php

namespace App\Repository;

use App\Entity\Attachment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Attachment>
 */
class AttachmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attachment::class);
    }

    /** @return Attachment[] */
    public function findOrphan(): array
    {
        /** @var Attachment[] $attachments */
        $attachments = $this->createQueryBuilder('a')
            ->andWhere('a.track IS NULL')
            ->getQuery()
            ->getResult();

        return $attachments;
    }

    /**
     * @param List<string> $ids
     *
     * @return Attachment[]
     */
    public function findByIdIn(array $ids): array
    {
        /** @var Attachment[] $attachments */
        $attachments = $this->createQueryBuilder('a')
            ->andWhere('a.id IN(:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();

        return $attachments;
    }
}
