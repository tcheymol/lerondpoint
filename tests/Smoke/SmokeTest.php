<?php

namespace App\Tests\Smoke;

use App\Tests\Abstract\AuthenticatedWebTestCase;
use Symfony\Component\HttpFoundation\Request;

class SmokeTest extends AuthenticatedWebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful(string $url): void
    {
        $this->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider authenticatedUrlProvider
     */
    public function testAuthenticatedPageIsSuccessful(string $url): void
    {
        $this->login('t@g.c');
        $this->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
    }

    public function urlProvider(): \Generator
    {
        yield ['/maintenance'];
        yield ['/home'];
        yield ['/login'];
    }

    public function authenticatedUrlProvider(): \Generator
    {
        yield ['/sign_up'];
        yield ['/track'];
    }
}