<?php

namespace App\Repository;

use App\Entity\Invitation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Invitation>
 */
class InvitationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invitation::class);
    }

    public function findExistingInvitation(Invitation $invitation): ?Invitation
    {
        $qb = $this->createQueryBuilder('i')
            ->andWhere('i.collective = :collective')
            ->setParameter('collective', $invitation->getCollective());

        if ($invitation->getUser()) {
            $qb->andWhere('i.user = :user')
                ->setParameter('user', $invitation->getUser());
        } elseif ($invitation->getUnregisteredEmail()) {
            $qb->andWhere('i.unregisteredEmail = :email')
                ->setParameter('email', $invitation->getUnregisteredEmail());
        }

        /** @var ?Invitation $invitation */
        $invitation = $qb->getQuery()->getOneOrNullResult();

        return $invitation;
    }
}
