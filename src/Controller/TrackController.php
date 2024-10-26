<?php

namespace App\Controller;

use App\Domain\Track\TrackAttachmentHelper;
use App\Domain\Track\TrackFactory;
use App\Domain\Track\TrackKindProvider;
use App\Domain\Track\TrackPersister;
use App\Domain\Track\TrackProvider;
use App\Entity\Track;
use App\Form\TrackType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/track')]
class TrackController extends AbstractController
{
    #[Route('', name: 'track_index', methods: ['GET'])]
    public function index(TrackProvider $provider): Response
    {
        return $this->render('track/index.html.twig', ['tracks' => $provider->provide()]);
    }

    #[Route('/new', name: 'track_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TrackFactory $trackFactory, TrackPersister $trackPersister, TrackKindProvider $trackKindProvider): Response
    {
        $track = $trackFactory->create();
        $form = $this->createForm(TrackType::class, $track)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trackPersister->persist($track);

            return $this->redirectToRoute('track_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('track/new.html.twig', [
            'track' => $track,
            'form' => $form,
            'kinds' => $trackKindProvider->provide(),
        ]);
    }

    #[Route('/{id<\d+>}', name: 'track_show', methods: ['GET'])]
    public function show(Track $track, TrackAttachmentHelper $helper): Response
    {
        return $this->render('track/show.html.twig', [
            'track' => $helper->hydrateTrackWithUrl($track),
        ]);
    }

    #[Route('/{id<\d+>}/edit', name: 'track_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Track $track, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrackType::class, $track)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('track_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('track/edit.html.twig', [
            'track' => $track,
            'form' => $form,
        ]);
    }

    #[Route('/{id<\d+>}', name: 'track_delete', methods: ['POST'])]
    public function delete(Request $request, Track $track, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$track->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($track);
            $entityManager->flush();
        }

        return $this->redirectToRoute('track_index', [], Response::HTTP_SEE_OTHER);
    }
}
