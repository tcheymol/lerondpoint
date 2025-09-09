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

    public function findExisting(NewsletterRegistration $registration): ?NewsletterRegistration
    {
        return $this->findOneBy(['email' => $registration->getEmail()]);
    }

    public function subscribeBack(NewsletterRegistration $registration): void
    {
        $registration->setIsUnsubscribed(false);
        $this->getEntityManager()->flush();
    }

    public function unsubscribe(NewsletterRegistration $registration): void
    {
        $this->findExisting($registration)?->setIsUnsubscribed(true);
        $this->getEntityManager()->flush();
    }

    public function persist(NewsletterRegistration $registration): void
    {
        $this->getEntityManager()->persist($registration);
        $this->getEntityManager()->flush();
    }
}
