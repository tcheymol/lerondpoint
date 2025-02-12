<?php

namespace App\Controller;

use App\Domain\Security\UserPersister;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route(path: '/sign_up', name: 'app_sign_up', methods: ['GET', 'POST'])]
    public function signUP(Request $request, UserPersister $persister): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $persister->persist($user);

            return $this->redirectToRoute('app_sign_up_success', ['email' => $user->getEmail()]);
        }

        return $this->render('security/sign_up.html.twig', ['form' => $form]);
    }

    #[Route(path: '/sign_up/success', name: 'app_sign_up_success', methods: ['GET'])]
    public function signUpSuccess(Request $request): Response
    {
        return $this->render('security/sign_up_success.html.twig', [
            'email' => $request->query->get('email'),
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, EmailVerifier $emailVerifier, UserRepository $userRepository): Response
    {
        $id = $request->query->get('id');
        if (null === $id) {
            return $this->redirectToRoute('app_login');
        }
        $user = $userRepository->find($id);
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        try {
            $emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_login');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'EmailVerified');

        return $this->redirectToRoute('app_login');
    }
}
