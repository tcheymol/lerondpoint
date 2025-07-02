<?php

namespace App\Controller;

use App\Domain\Security\UserPersister;
use App\Entity\User;
use App\Form\UserType;
use App\Security\Voter\Constants;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class UserController extends AbstractController
{
    #[Route('/user/account/{page<[\w-]+>}', name: 'user_account', methods: ['GET', 'POST'])]
    public function account(Request $request, UserPersister $persister, ?string $page = 'profile'): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->backHome();
        }
        $form = $this->createForm(UserType::class, $user)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $persister->update($user);
            $this->addFlash('success', 'ProfileSuccessfullyUpdated');

            return $this->redirectToRoute('user_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/account.html.twig', [
            'user' => $user,
            'form' => $form,
            'page' => $page,
        ]);
    }

    #[IsGranted(Constants::EDIT, subject: 'user')]
    #[Route('/user/{<\d+>}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('danger', 'ProfileSuccessfullyDeleted');
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
