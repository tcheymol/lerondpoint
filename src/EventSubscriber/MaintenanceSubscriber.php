<?php

namespace App\EventSubscriber;

use App\Repository\FeatureToggleRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;

readonly class MaintenanceSubscriber implements EventSubscriberInterface
{
    public const array WHITELISTED_ROUTES = ['/maintenance', '/login', '/_wdt', '/_profiler', '/_fragment'];

    public function __construct(
        private FeatureToggleRepository $repository,
        private RouterInterface $router,
        private Security $security,
    ) {
    }

    public function onRequestEvent(RequestEvent $event): void
    {
        $loggedInUser = $this->security->getUser();
        if (null !== $loggedInUser) {
            return;
        }
        $path = $event->getRequest()->getPathInfo();
        if (array_any(self::WHITELISTED_ROUTES, fn ($route) => str_contains($path, (string) $route))) {
            return;
        }

        if ($this->repository->findOneBy(['name' => 'website-online'])?->isEnabled()) {
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
