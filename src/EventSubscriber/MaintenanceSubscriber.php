<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;

readonly class MaintenanceSubscriber implements EventSubscriberInterface
{
    public const array WHITELISTED_ROUTES = ['/maintenance', '/login', '/_wdt'];

    public function __construct(private bool $isWebsiteOnline, private RouterInterface $router)
    {
    }

    public function onRequestEvent(RequestEvent $event): void
    {
        if ($this->isWebsiteOnline) {
            return;
        }
        $path = $event->getRequest()->getPathInfo();
        if (array_any(self::WHITELISTED_ROUTES, fn ($route) => str_contains($path, $route))) {
            return;
        }

        $event->setResponse(new RedirectResponse($this->router->generate('maintenance')));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onRequestEvent',
        ];
    }
}
