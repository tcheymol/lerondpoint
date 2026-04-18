<?php

namespace App\Controller;

use App\Domain\Track\TrackPersister;
use App\Entity\Track;
use App\Form\TrackType;
use App\Security\Voter\Constants;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CreateTrackController extends AbstractController
{
    #[Route('/track/new/disclaimer', name: 'track_new_disclaimer', methods: ['GET'])]
    public function disclaimer(): Response
    {
        return $this->render('track/new/disclaimer.html.twig');
    }

    #[Route('/track/new/{step<\d+>}', name: 'track_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TrackPersister $persister, ?int $step = null): Response
    {
        $track = $persister->fetchSessionTrack();
        if (null === $step || $step > $track->getCreationStep()) {
            $step = $track->getCreationStep() ?? 1;
        }

        if (0 === $step) {
            $persister->remove($track);

            return $this->redirectToRoute('track_list');
        } elseif (5 === $step) {
            $persister->publish($track);

            return $track->isAccepted()
                ? $this->redirectToRoute('track_show', ['id' => $track->getId()])
                : $this->redirectToRoute('track_list');
        }

        $form = $this->createForm(TrackType::class, $track, ['step' => $step])->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $step = $step + ($this->isButtonClicked($form, 'back') ? -1 : 1);
            $persister->persist($track, $step);

            return $this->redirectToRoute('track_new', ['step' => $step]);
        }

        return $this->render('track/new/index.html.twig', [
            'form' => $form,
            'step' => $step,
            'track' => $track,
        ]);
    }

    #[IsGranted(attribute: Constants::EDIT, subject: 'track')]
    #[Route('/track/{id<\d+>}/update_cover', name: 'track_update_cover', methods: ['GET'])]
    public function updateCover(Request $request, Track $track, TrackPersister $persister): Response
    {
        $persister->updateCover($track, $request->query->getInt('newCoverId'));

        return $this->render('track/new/update_preview.html.twig', [
            'track' => $track,
            'step' => $request->query->getInt('step', 2),
        ]);
    }

    #[IsGranted(attribute: Constants::EDIT, subject: 'track')]
    #[Route('/track/{id<\d+>}/reorder_attachments', name: 'track_reorder_attachments', methods: ['GET'])]
    public function reorderAttachments(Request $request, Track $track): Response
    {
        return $this->render('track/new/reorder_attachments.html.twig', [
            'track' => $track,
            'step' => $request->query->getInt('step', 2),
        ]);
    }

    #[IsGranted(attribute: Constants::EDIT, subject: 'track')]
    #[Route('/track/{id<\d+>}/reorder_attachments', name: 'track_save_attachment_order', methods: ['POST'])]
    public function saveAttachmentOrder(Request $request, Track $track, TrackPersister $persister): Response
    {
        $positions = $request->request->getString('positions');
        $persister->reorderAttachments($track, array_filter(explode(',', $positions), is_numeric(...)));

        return $this->redirectToRoute('track_new', ['step' => $request->request->getInt('step', 2)]);
    }
}
