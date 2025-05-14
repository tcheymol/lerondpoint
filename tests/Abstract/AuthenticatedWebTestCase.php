<?php

namespace App\Tests\Abstract;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class AuthenticatedWebTestCase extends WebTestCase
{
    protected ?KernelBrowser $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * @param string[] $parameters
     * @param string[] $files
     * @param string[] $server
     */
    public function request(string $method, string $uri, array $parameters = [], array $files = [], array $server = [], ?string $content = null, bool $changeHistory = true): ?Crawler
    {
        return $this->client?->request($method, $uri, $parameters, $files, $server, $content, $changeHistory);
    }

    public function login(string $email): User
    {
        $user = $this->findOrCreateUser($email);
        $this->client?->loginUser($user);

        return $user;
    }

    public function createTestUser(string $email): User
    {
        $em = $this->getEntityManager();
        $user = new User()
            ->setEmail($email)
            ->setPassword('password')
            ->acceptTerms();

        $em->persist($user);
        $em->flush();

        return $user;
    }

    private function findOrCreateUser(string $email): User
    {
        $user = $this->getEntityManager()
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);

        if (!$user) {
            $user = $this->createTestUser($email);
        }

        return $user;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        /** @var EntityManagerInterface $em */
        $em = self::getContainer()->get(EntityManagerInterface::class);

        return $em;
    }
}