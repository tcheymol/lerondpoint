<?php

namespace App\Controller;

use App\Domain\Collective\CollectivePersister;
use App\Domain\Map\MapDataBuilder;
use App\Entity\Collective;
use App\Form\CollectiveType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CollectiveController extends AbstractController
{
    #[Route('/collective{map<[\w-]+>}', name: 'collective_index', methods: ['GET'])]
    public function index(MapDataBuilder $mapDataBuilder, ?string $map = 'metropolis'): Response
    {
        return $this->render('map/index.html.twig', [
            'collectives' => $mapDataBuilder->build(),
            'map' => $map,
        ]);
    }

    #[Route('/collective/invite/{id<\d+>}', name: 'collective_invite', methods: ['GET', 'POST'])]
    public function invite(Request $request, Collective $collective, CollectivePersister $persister): Response
    {
        $form = $this->createFormBuilder()->add('email', EmailType::class)->getForm()->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $email */
            $email = $form->get('email')->getData();
            $persister->inviteUser($collective, $email);

            return $this->redirectToRoute('collective_invite', ['id' => $collective->getId()]);
        }

        return $this->render('collective/invite.html.twig', [
            'collective' => $collective,
            'form' => $form,
        ]);
    }

    #[Route('/collective/new/{step<\d+>}', name: 'collective_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CollectivePersister $persister, int $step = 1): Response
    {
        $collective = $persister->fetchSessionCollective();
        dump($collective);
        $form = $this->createForm(CollectiveType::class, $collective, ['step' => $step])
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $isLastStep = 3 === $step;
            $persister->persist($collective, $isLastStep);

            return $isLastStep
                ? $this->redirectToRoute('collective_index')
                : $this->redirectToRoute('collective_new', ['step' => $step + 1]);
        }

        return $this->render('collective/new.html.twig', ['form' => $form, 'step' => $step]);
    }

    #[Route('/collective/{id<\d+>}', name: 'collective_show', methods: ['GET'])]
    public function show(Collective $collective): Response
    {
        return $this->render('collective/show.html.twig', ['collective' => $collective]);
    }

    #[Route('/collective/{id<\d+>}/edit', name: 'collective_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Collective $collective, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CollectiveType::class, $collective);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('collective_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('collective/edit.html.twig', [
            'collective' => $collective,
            'form' => $form,
        ]);
    }

    #[Route('/collective/{id<\d+>}', name: 'collective_delete', methods: ['POST'])]
    public function delete(Request $request, Collective $collective, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collective->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($collective);
            $entityManager->flush();
        }

        return $this->redirectToRoute('collective_index', [], Response::HTTP_SEE_OTHER);
    }
}
