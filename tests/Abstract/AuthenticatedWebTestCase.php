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

    /** @param list<string> $roles */
    public function login(string $email, array $roles = []): User
    {
        $user = $this->findOrCreateUser($email, $roles);
        $this->client?->loginUser($user);

        return $user;
    }

    /** @param list<string> $roles */
    public function createTestUser(string $email, array $roles = []): User
    {
        $em = $this->getEntityManager();
        $user = new User()
            ->setEmail($email)
            ->setPassword('password')
            ->setRoles($roles)
            ->acceptTerms();

        $em->persist($user);
        $em->flush();

        return $user;
    }

    /** @param list<string> $roles */
    private function findOrCreateUser(string $email, array $roles = []): User
    {
        $user = $this->getEntityManager()
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);

        if (!$user) {
            $user = $this->createTestUser($email, $roles);
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
