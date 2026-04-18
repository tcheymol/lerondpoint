<?php

namespace App\Controller;

use App\Domain\Images\AttachmentHelper;
use App\Domain\Track\TrackPersister;
use App\Domain\Track\TrackProvider;
use App\Entity\Attachment;
use App\Entity\Track;
use App\Entity\User;
use App\Form\Model\RejectTrack;
use App\Form\RejectTrackType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_MODERATOR')]
class ModerationController extends AbstractController
{
    #[Route('/moderation', name: 'moderation_index', methods: ['GET'])]
    public function index(Request $request, TrackProvider $provider, UserRepository $userRepository): Response
    {
        $filter = $request->query->get('filter', 'all');

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $assignee = null;
        $unassigned = false;

        if ('me' === $filter) {
            $assignee = $currentUser;
        } elseif ('unassigned' === $filter) {
            $unassigned = true;
        }

        return $this->render('track/moderation/index.html.twig', [
            'tracks' => $provider->provideToModerate($assignee, $unassigned),
            'moderators' => $userRepository->findModerators(),
            'filter' => $filter,
        ]);
    }

    #[Route('/moderation/{id<\d+>}/assign', name: 'moderate_track_assign', methods: ['POST'])]
    public function assign(Request $request, Track $track, TrackPersister $persister, UserRepository $userRepository): Response
    {
        $assignedToId = $request->request->get('assigned_to_id');

        if (null === $assignedToId || '' === $assignedToId) {
            $persister->assign($track, null);
        } else {
            $assignee = $userRepository->find((int) $assignedToId);

            if (!$assignee) {
                throw $this->createNotFoundException();
            }

            /** @var User $currentUser */
            $currentUser = $this->getUser();

            if (!$this->isGranted('ROLE_ADMIN') && $assignee->getId() !== $currentUser->getId()) {
                throw $this->createAccessDeniedException();
            }

            $persister->assign($track, $assignee);
        }

        $this->addFlash('success', 'TrackAssigned');

        return $this->redirectToRoute('moderation_index', ['filter' => $request->request->get('filter', 'all')]);
    }

    #[Route('/moderation/rejected', name: 'moderation_rejected', methods: ['GET'])]
    public function rejected(TrackProvider $provider): Response
    {
        return $this->render('track/moderation/rejected.html.twig', [
            'tracks' => $provider->provideRejected(),
        ]);
    }

    #[Route('/moderation/{id<\d+>}', name: 'moderate_track', methods: ['GET'])]
    public function moderate(Track $track): Response
    {
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
            $persister->reject($track, $rejectTrack);

            return $this->redirectToRoute('moderation_index');
        }

        return $this->render('track/moderation/reject.html.twig', [
            'form' => $form->createView(),
            'track' => $track,
        ]);
    }

    #[Route('/moderation/{id<\d+>}/remove_attachment', name: 'moderate_track_remove_attachment', methods: ['GET'])]
    public function removeAttachment(Request $request, Attachment $attachment, AttachmentHelper $helper): Response
    {
        $track = $attachment->getTrack();
        if (!$track) {
            return new RedirectResponse($request->headers->get('referer') ?? 'home');
        }
        if ($track->hasMultipleAttachments()) {
            $helper->delete($attachment);
        }

        return $this->redirectToRoute('moderate_track', ['id' => $track->getId()]);
    }
}
