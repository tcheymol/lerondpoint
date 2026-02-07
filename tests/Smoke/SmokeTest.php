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

    public static function urlProvider(): \Generator
    {
        yield ['/about_lrp'];

        yield ['/about_the_movement'];

        yield ['/about_us'];

        yield ['/accept_terms'];

        yield ['/attachments/previews'];

        yield ['/collective/map'];

        yield ['/collective/new/disclaimer'];

        yield ['/collective/quick_new'];

        yield ['/home'];

        yield ['/legal/privacy'];

        yield ['/legal/terms'];

        yield ['/login'];

        yield ['/newsletter/subscribe'];

        yield ['/newsletter/subscribe/success'];

        yield ['/newsletter/unsubscribe'];

        yield ['/participate'];

        yield ['/reset-password'];

        yield ['/reset-password/check-email'];

        yield ['/sign_up'];

        yield ['/sign_up/success'];

        yield ['/support_us'];

        yield ['/they_talk_about_us'];

        yield ['/track'];
    }

    #[DataProvider('authenticatedUrlProvider')]
    public function testAuthenticatedPageIsSuccessful(string $url): void
    {
        $this->login('t@g.c');

        $this->request(Request::METHOD_GET, $url);

        $this->assertResponseRedirects();
    }

    public static function authenticatedUrlProvider(): \Generator
    {
        yield ['/do_accept_terms'];

        yield ['/logout'];

        yield ['/verify/email'];
    }

    #[DataProvider('moderatorUrlProvider')]
    public function testModeratorPageIsSuccessful(string $url): void
    {
        $this->login('t-modo@g.c', ['ROLE_MODERATOR']);
        $this->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
    }

    public static function moderatorUrlProvider(): \Generator
    {
        yield ['/moderation'];
    }

    #[DataProvider('adminUrlProvider')]
    public function testAdminPageIsSuccessful(string $url): void
    {
        $this->login('t-admin@g.c', ['ROLE_ADMIN']);
        $this->request(Request::METHOD_GET, $url);

        $this->assertResponseRedirects('/admin/user');
    }

    public static function adminUrlProvider(): \Generator
    {
        yield ['/admin'];
    }
}
