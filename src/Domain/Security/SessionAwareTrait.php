<?php

namespace App\Domain\Security;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

trait SessionAwareTrait
{
    private readonly RequestStack $requestStack;

    public function addFlash(string $type, string $content): void
    {
        $this->getFlashBag()?->add($type, $content);
    }

    public function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }

    public function getFlashBag(): ?FlashBagInterface
    {
        $session = $this->getSession();

        return $session instanceof Session ? $session->getFlashBag() : null;
    }

    public function getItem(string $key, mixed $default = null): mixed
    {
        return $this->getSession()->get($key, $default);
    }

    public function setItem(string $key, mixed $value): void
    {
        $this->getSession()->set($key, $value);
    }
}
