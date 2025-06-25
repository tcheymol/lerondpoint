<?php

namespace App\Controller;

use App\Domain\Collective\CollectivePersister;
use App\Entity\Collective;
use App\Entity\Invitation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CollectiveInvitationController extends AbstractController
{
    #[Route('/collective/invite/{id<\d+>}', name: 'collective_invite', methods: ['GET', 'POST'])]
    public function invite(Request $request, Collective $collective, CollectivePersister $persister): Response
    {
        $form = $this->createFormBuilder()->add('email', EmailType::class)->getForm()->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $email */
            $email = $form->get('email')->getData();
            $persister->inviteUser($collective, $email);

            return $this->redirectToRoute('user_account', ['page' => 'collectives']);
        }

        return $this->render('collective/invite.html.twig', [
            'collective' => $collective,
            'form' => $form,
        ]);
    }

    #[Route('/invitation/{id<\d+>}/accept', name: 'collective_invitation_accept', methods: ['GET'])]
    public function accept(Invitation $invitation, CollectivePersister $persister): Response
    {
        $persister->acceptInvitation($invitation);

        return $this->redirectToRoute('user_account', ['page' => 'collectives']);
    }

    #[Route('/invitation/{id<\d+>}/reject', name: 'collective_invitation_reject', methods: ['GET'])]
    public function reject(Invitation $invitation, CollectivePersister $persister): Response
    {
        $persister->rejectInvitation($invitation);

        return $this->redirectToRoute('user_account', ['page' => 'collectives']);
    }
}
