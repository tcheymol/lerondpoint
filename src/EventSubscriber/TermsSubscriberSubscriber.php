<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;

readonly class TermsSubscriberSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
        private RouterInterface $router)
    {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $acceptTermsRoutes = ['app_do_accept_terms', 'app_accept_terms'];
        $request = $event->getRequest();

        if (in_array($request->attributes->get('_route'), $acceptTermsRoutes)) {
            return;
        }

        $user = $this->security->getUser();
        if (!$user instanceof User) {
            return;
        }

        if (!$user->hasAcceptedTerms()) {
            $url = $this->router->generate('app_accept_terms');
            $event->setResponse(new RedirectResponse($url));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 0],
        ];
    }
}
