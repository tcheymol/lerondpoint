<?php

namespace App\Controller;

use App\Domain\Images\ThumbSize;
use App\Domain\Track\TrackAttachmentHelper;
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
    #[Route('/track/new/{step<\d+>}', name: 'track_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TrackPersister $persister, TrackAttachmentHelper $helper, int $step = 1): Response
    {
        $track = $persister->fetchSessionTrack();

        $step = $track->getCreationStep() ?? $step;

        if (0 === $step) {
            $persister->remove($track);
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
            'track' => $helper->hydrateTrackWithUrl($track, $step === 4 ? ThumbSize::Full : ThumbSize::Medium),
        ]);
    }
}
