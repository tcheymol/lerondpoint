<?php

namespace App\Domain\Security;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

trait SessionAwareTrait
{
    private readonly RequestStack $requestStack;

    public function addFlash(string $type, string $content): void
    {
        $session = $this->getSession();
        if ($session instanceof Session) {
            $session->getFlashBag()->add($type, $content);
        }
    }

    public function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}
