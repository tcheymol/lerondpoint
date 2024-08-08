<?php

namespace App\Controller;

use App\Entity\Collective;
use App\Form\CollectiveType;
use App\Repository\CollectiveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/collective')]
class CollectiveController extends AbstractController
{
    #[Route('', name: 'collective_index', methods: ['GET'])]
    public function index(CollectiveRepository $collectiveRepository): Response
    {
        return $this->render('collective/index.html.twig', [
            'collectives' => $collectiveRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'collective_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $collective = new Collective();
        $form = $this->createForm(CollectiveType::class, $collective);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($collective);
            $entityManager->flush();

            return $this->redirectToRoute('collective_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('collective/new.html.twig', [
            'collective' => $collective,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'collective_show', methods: ['GET'])]
    public function show(Collective $collective): Response
    {
        return $this->render('collective/show.html.twig', [
            'collective' => $collective,
        ]);
    }

    #[Route('/{id}/edit', name: 'collective_edit', methods: ['GET', 'POST'])]
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

    #[Route('/{id}', name: 'collective_delete', methods: ['POST'])]
    public function delete(Request $request, Collective $collective, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collective->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($collective);
            $entityManager->flush();
        }

        return $this->redirectToRoute('collective_index', [], Response::HTTP_SEE_OTHER);
    }
}
