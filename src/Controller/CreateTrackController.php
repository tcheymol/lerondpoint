<?php

namespace App\Controller;

use App\Domain\Track\TrackPersister;
use App\Entity\Track;
use App\Form\TrackType;
use App\Repository\CollectiveRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreateTrackController extends AbstractController
{
    #[Route('/track/new/{step<\d+>}', name: 'track_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TrackPersister $persister, CollectiveRepository $repository, ?int $step = null): Response
    {
        $track = $persister->fetchSessionTrack();
        $createdCollectiveId = $request->query->getInt('createdCollectiveId');
        if ($createdCollectiveId) {
            $track->setCollective($repository->find($createdCollectiveId));
        }
        if (null === $step || $step > $track->getCreationStep()) {
            $step = $track->getCreationStep() ?? 1;
        }

        if (0 === $step) {
            $persister->remove($track);

            return $this->redirectToRoute('track_list');
        } elseif (5 === $step) {
            $persister->publish($track);

            return $this->redirectToRoute('track_list');
        }

        $form = $this->createForm(TrackType::class, $track, ['step' => $step])->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $step = $step + ($this->isButtonClicked($form, 'back') ? -1 : 1);
            $track->setCreationStep($step);
            $persister->persist($track);

            return $this->redirectToRoute('track_new', ['step' => $step]);
        }

        return $this->render('track/new/index.html.twig', [
            'form' => $form,
            'step' => $step,
            'track' => $track,
        ]);
    }

    #[Route('/track/{id<\d+>}/update_cover', name: 'track_update_cover', methods: ['GET'])]
    public function updateCover(Request $request, Track $track, TrackPersister $persister): Response
    {
        $persister->updateCover($track, $request->query->getInt('newCoverId'));

        return $this->render('track/new/update_preview.html.twig', ['track' => $track]);
    }
}
