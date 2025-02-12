<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class CheckVerifiedUserSubscriber implements EventSubscriberInterface
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    /**
     * @throws \Exception
     */
    public function onCheckPassportEvent(CheckPassportEvent $event): void
    {
        $passport = $event->getPassport();
        $user = $passport->getUser();
        if (!$user instanceof User) {
            throw new \Exception('Unexpected user type');
        }

        if (!$user->isValidatedEmail()) {
            throw new CustomUserMessageAuthenticationException($this->translator->trans('EmailNotVerified'));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CheckPassportEvent::class => 'onCheckPassportEvent',
        ];
    }
}
