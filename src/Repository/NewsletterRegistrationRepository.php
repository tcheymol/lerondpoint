<?php

namespace App\Repository;

use App\Entity\NewsletterRegistration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NewsletterRegistration>
 */
class NewsletterRegistrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterRegistration::class);
    }

    public function persist(NewsletterRegistration $registration, bool $checkExisting = false): void
    {
        if (!$checkExisting) {
            $this->getEntityManager()->persist($registration);
        } else {
            $this->findOneBy(['email' => $registration->getEmail()])?->setIsUnsubscribed(false);
        }
        $this->getEntityManager()->flush();
    }

    public function unsubscribe(NewsletterRegistration $registration): void
    {
        $registration->setIsUnsubscribed(true);
        $this->getEntityManager()->flush();
    }
}
