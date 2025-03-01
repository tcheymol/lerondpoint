<?php

namespace App\Controller;

use App\Domain\Images\ThumbSize;
use App\Domain\Search\SearchFactory;
use App\Domain\Search\SearchType;
use App\Domain\Track\TrackAttachmentHelper;
use App\Domain\Track\TrackProvider;
use App\Entity\Track;
use App\Form\TrackType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/track')]
class TrackController extends AbstractController
{
    #[Route('', name: 'track_list', methods: ['GET', 'POST'])]
    public function index(Request $request, TrackProvider $provider, SearchFactory $factory): Response
    {
        $search = $factory->create($request->query->all());
        $form = $this->createForm(SearchType::class, $search, [
            'action' => $this->generateUrl('track_async_search'),
        ])->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('track_list', $search->toParamsArray());
        }

        $tracks = $provider->provide($search);
        shuffle($tracks);

        return $this->render('track/index.html.twig', [
            'tracks' => $tracks,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/search', name: 'track_async_search', methods: ['POST'])]
    public function asyncSearch(Request $request, TrackProvider $provider, SearchFactory $factory): Response
    {
        $search = $factory->create($request->query->all());
        $form = $this->createForm(SearchType::class, $search)->handleRequest($request);

        $tracks = $form->isSubmitted() && $form->isValid() ? $provider->provide($search) : [];

        return $this->json([
            'html' => $this->renderView('track/components/_tracks_list.html.twig', ['tracks' => $tracks]),
            'queryParams' => $search->toParamsArray(),
        ]);
    }

    #[Route('/{id<\d+>}', name: 'track_show', methods: ['GET'])]
    public function show(Track $track, TrackAttachmentHelper $helper, TrackProvider $provider): Response
    {
        $track = $helper->hydrateTrackWithUrl($track, ThumbSize::Full);
        $track = $provider->hydrateWithPreviousAndNextIds($track);

        return $this->render('track/show.html.twig', ['track' => $track]);
    }

    #[Route('/{id<\d+>}/carousel', name: 'track_carousel', methods: ['GET'])]
    public function carousel(Track $track, TrackAttachmentHelper $helper): Response
    {
        return $this->render('track/carousel.html.twig', [
            'track' => $helper->hydrateTrackWithUrl($track, ThumbSize::Big),
        ]);
    }

    #[Route('/{id<\d+>}/edit', name: 'track_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Track $track, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrackType::class, $track)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('track_list', [], Response::HTTP_SEE_OTHER);
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

        return $this->redirectToRoute('track_list', [], Response::HTTP_SEE_OTHER);
    }
}
