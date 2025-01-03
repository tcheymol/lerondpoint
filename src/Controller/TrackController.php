<?php

namespace App\Controller;

use App\Domain\Images\ThumbSize;
use App\Domain\Search\SearchFactory;
use App\Domain\Search\SearchType;
use App\Domain\Track\TrackAttachmentHelper;
use App\Domain\Track\TrackKindProvider;
use App\Domain\Track\TrackPersister;
use App\Domain\Track\TrackProvider;
use App\Entity\Track;
use App\Form\Model\UrlModel;
use App\Form\TrackType;
use App\Form\UrlType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/track')]
class TrackController extends AbstractController
{
    #[Route('', name: 'track_index', methods: ['GET', 'POST'])]
    public function index(Request $request, TrackProvider $provider, SearchFactory $factory): Response
    {
        $search = $factory->create($request->query->all());
        $form = $this->createForm(SearchType::class, $search)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('track_index', $search->toParamsArray());
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

        return $form->isSubmitted() && $form->isValid()
            ? $this->render('track/components/_tracks_list.html.twig', [
                'tracks' => $provider->provide($search),
            ])
            : $this->render('components/_empty.html.twig');
    }

    #[Route('/new', name: 'track_new', methods: ['GET'])]
    public function new(): Response
    {
        return $this->render('track/new.html.twig');
    }

    #[Route('/{id<\d+>}/main_infos', name: 'track_new_main_infos', methods: ['GET', 'POST'])]
    public function newMainInfos(Request $request, Track $track, TrackKindProvider $trackKindProvider, TrackPersister $trackPersister): Response
    {
        $form = $this->createForm(TrackType::class, $track)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $trackPersister->persist($track);

            return $this->redirectToRoute('track_index');
        }

        return $this->render('track/new_main_infos.html.twig', [
            'track' => $track,
            'form' => $form,
            'kinds' => $trackKindProvider->provide(),
        ]);
    }

    #[Route('/new/link', name: 'track_new_link', methods: ['GET', 'POST'])]
    public function newWithLink(Request $request, TrackPersister $trackPersister, TrackKindProvider $trackKindProvider): Response
    {
        $urlModel = new UrlModel();
        $form = $this->createForm(UrlType::class, $urlModel)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $track = (new Track())->setUrl($urlModel->url)->setName('Trace Anonyme');
            $trackPersister->persist($track);

            return $this->redirectToRoute('track_new_main_infos', ['id' => $track->getId()]);
        }

        return $this->render('track/new_link.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/new/upload', name: 'track_new_upload', methods: ['GET', 'POST'])]
    public function newUpload(Request $request, TrackPersister $trackPersister, TrackKindProvider $trackKindProvider): Response
    {
        $track = new Track();
        $form = $this->createForm(TrackType::class, $track)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trackPersister->persist($track);

            return $this->redirectToRoute('track_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('track/new_upload.html.twig', [
            'track' => $track,
            'form' => $form,
            'kinds' => $trackKindProvider->provide(),
        ]);
    }

    #[Route('/{id<\d+>}', name: 'track_show', methods: ['GET'])]
    public function show(Track $track, TrackAttachmentHelper $helper, TrackProvider $provider): Response
    {
        $track = $helper->hydrateTrackWithUrl($track, ThumbSize::Medium);
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
