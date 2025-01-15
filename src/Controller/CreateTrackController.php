<?php

namespace App\Controller;

use App\Domain\Images\ThumbSize;
use App\Domain\Track\TrackAttachmentHelper;
use App\Domain\Track\TrackPersister;
use App\Entity\Track;
use App\Form\TrackType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/track/new')]
class CreateTrackController extends AbstractController
{
    #[Route('/', name: 'track_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TrackPersister $persister): Response
    {
        $track = new Track();
        $form = $this->createForm(TrackType::class, $track)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $persister->persist($track);

            return $this->redirectToRoute('track_new_add_main_information', ['id' => $track->getId()]);
        }

        return $this->render('track/new/create.html.twig', ['form' => $form]);
    }

    #[Route('/{id<\d+>}/information', name: 'track_new_add_main_information', methods: ['GET', 'POST'])]
    public function newAddMainInformation(Request $request, Track $track, TrackPersister $persister, TrackAttachmentHelper $helper): Response
    {
        $form = $this->createForm(TrackType::class, $track, ['step' => 2])->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $persister->persist($track);

            return $this->isButtonClicked($form, 'back')
                ? $this->redirectToRoute('track_cancel', ['id' => $track->getId()])
                : $this->redirectToRoute('track_new_add_description', ['id' => $track->getId()]);
        }

        return $this->render('track/new/information.html.twig', [
            'form' => $form,
            'track' => $helper->hydrateTrackWithUrl($track, ThumbSize::Medium),
        ]);
    }

    #[Route('/{id<\d+>}/description', name: 'track_new_add_description', methods: ['GET', 'POST'])]
    public function newAddDescription(Request $request, TrackPersister $persister, Track $track, TrackAttachmentHelper $helper): Response
    {
        $form = $this->createForm(TrackType::class, $track, ['step' => 3])->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $persister->persist($track);

            return $this->isButtonClicked($form, 'back')
                ? $this->redirectToRoute('track_new_add_main_information', ['id' => $track->getId()])
                : $this->redirectToRoute('track_new_preview', ['id' => $track->getId()]);
        }

        return $this->render('track/new/description.html.twig', [
            'form' => $form,
            'track' => $helper->hydrateTrackWithUrl($track, ThumbSize::Medium),
        ]);
    }

    #[Route('/{id<\d+>}/preview', name: 'track_new_preview', methods: ['GET'])]
    public function newPreview(Track $track, TrackAttachmentHelper $attachmentHelper): Response
    {
        return $this->render('track/new/preview.html.twig', [
            'track' => $attachmentHelper->hydrateTrackWithUrl($track, ThumbSize::Full),
        ]);
    }

    #[Route('/{id<\d+>}/publish', name: 'track_publish', methods: ['GET'])]
    public function publish(Track $track, TrackPersister $persister): Response
    {
        $persister->publish($track);

        return $this->redirectToRoute('track_list');
    }

    #[Route('/{id<\d+>}/cancel', name: 'track_cancel', methods: ['GET'])]
    public function cancel(Track $track, TrackPersister $persister): Response
    {
        $persister->remove($track);

        return $this->redirectToRoute('track_new');
    }
}
