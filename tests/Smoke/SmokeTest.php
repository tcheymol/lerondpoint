<?php

namespace App\Tests\Smoke;

use App\Tests\Abstract\AuthenticatedWebTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Request;

class SmokeTest extends AuthenticatedWebTestCase
{
    #[DataProvider('urlProvider')]
    public function testPageIsSuccessful(string $url): void
    {
        $this->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
    }

    #[DataProvider('authenticatedUrlProvider')]
    public function testAuthenticatedPageIsSuccessful(string $url): void
    {
        $this->login('t@g.c');
        $this->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
    }

    public static function urlProvider(): \Generator
    {
        yield ['/maintenance'];
        yield ['/home'];
        yield ['/login'];
    }

    public static function authenticatedUrlProvider(): \Generator
    {
        yield ['/sign_up'];
        yield ['/track'];
    }
}
