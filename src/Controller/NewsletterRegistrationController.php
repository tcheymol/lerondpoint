<?php

namespace App\Controller;

use App\Entity\NewsletterRegistration;
use App\Form\NewsletterRegistrationForm;
use App\Repository\NewsletterRegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/newsletter')]
final class NewsletterRegistrationController extends AbstractController
{
    #[Route('/subscribe', name: 'subscribe_newsletter', methods: ['GET', 'POST'])]
    public function subscribe(Request $request, NewsletterRegistrationRepository $repository, TranslatorInterface $translator): Response
    {
        $registration = new NewsletterRegistration($this->getUser()?->getEmail());
        $form = $this->createForm(NewsletterRegistrationForm::class, $registration)->handleRequest($request);

        if ($form->isSubmitted()) {
            $repository->persist($registration, !$form->isValid());

            $this->addFlash('success', $translator->trans('SuccessfullySubscribedToNewsletter'));

            return $this->redirectToRoute('subscribe_newsletter', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('newsletter_registration/subscribe.html.twig', ['form' => $form]);
    }

    #[Route('/unsubscribe', name: 'unsubscribed_newsletter', methods: ['GET', 'POST'])]
    public function unsubscribe(Request $request, NewsletterRegistrationRepository $repository, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        $prefilledEmail = $request->query->has('email')
            ? $request->query->getString('email')
            : $this->getUser()?->getEmail();

        $registration = new NewsletterRegistration($prefilledEmail);
        $form = $this->createForm(NewsletterRegistrationForm::class, $registration)->handleRequest($request);

        if ($form->isSubmitted()) {
            $registration = $repository->findOneBy(['email' => $registration->getEmail()]);
            if ($registration) {
                $registration->setIsUnsubscribed(true);
                $entityManager->flush();

                $this->addFlash('success', $translator->trans('SuccessfullyUnsubscribedFromNewsletter'));
            }

            return $this->redirectToRoute('unsubscribed_newsletter', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('newsletter_registration/unsubscribe.html.twig', ['form' => $form]);
    }
}
