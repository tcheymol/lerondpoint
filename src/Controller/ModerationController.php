<?php

namespace App\Controller;

use App\Domain\Images\ThumbSize;
use App\Domain\Track\TrackAttachmentHelper;
use App\Domain\Track\TrackPersister;
use App\Domain\Track\TrackProvider;
use App\Entity\Track;
use App\Form\Model\RejectTrack;
use App\Form\RejectTrackType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_MODERATOR')]
class ModerationController extends AbstractController
{
    #[Route('/moderation', name: 'moderation_index', methods: ['GET'])]
    public function index(TrackProvider $provider): Response
    {
        return $this->render('track/moderation/index.html.twig', [
            'tracks' => $provider->provideToModerate(),
        ]);
    }

    #[Route('/moderation/{id<\d+>}', name: 'moderate_track', methods: ['GET'])]
    public function moderate(Track $track, TrackAttachmentHelper $helper, TrackProvider $provider): Response
    {
        $track = $helper->hydrateTrackWithUrl($track, ThumbSize::Full);

        return $this->render('track/moderation/moderate.html.twig', ['track' => $track]);
    }

    #[Route('/moderation/{id<\d+>}/accept', name: 'moderate_track_accept', methods: ['GET'])]
    public function accept(Track $track, TrackPersister $persister): Response
    {
        $persister->accept($track);

        return $this->redirectToRoute('moderation_index');
    }

    #[Route('/moderation/{id<\d+>}/reject', name: 'moderate_track_reject', methods: ['GET', 'POST'])]
    public function reject(Request $request, Track $track, TrackPersister $persister): Response
    {
        $rejectTrack = new RejectTrack();
        $form = $this->createForm(RejectTrackType::class, $rejectTrack)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $persister->reject($track, $rejectTrack->rejectionCause);

            return $this->redirectToRoute('moderation_index');
        }

        return $this->render('track/moderation/reject.html.twig', [
            'form' => $form->createView(),
            'track' => $track,
        ]);
    }
}
