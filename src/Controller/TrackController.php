<?php

namespace App\Controller;

use App\Domain\Search\SearchFactory;
use App\Domain\Search\SearchType;
use App\Domain\Track\TrackProvider;
use App\Entity\Track;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TrackController extends AbstractController
{
    #[Route('/track', name: 'track_list', methods: ['GET', 'POST'])]
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

        return $this->render('track/index.html.twig', ['tracks' => $tracks,  'form' => $form]);
    }

    #[Route('/track/search', name: 'track_async_search', methods: ['POST'])]
    public function asyncSearch(Request $request, TrackProvider $provider, SearchFactory $factory): Response
    {
        $search = $factory->create($request->query->all());
        $form = $this->createForm(SearchType::class, $search)->handleRequest($request);

        $tracks = $form->isSubmitted() && $form->isValid() ? $provider->provide($search) : [];

        return $this->json([
            'html' => $this->renderView('track/components/_list.html.twig', ['tracks' => $tracks]),
            'queryParams' => $search->toParamsArray(),
        ]);
    }

    #[Route('/track/{id<\d+>}', name: 'track_show', methods: ['GET'])]
    public function show(Track $track): Response
    {
        return $this->render('track/show.html.twig', ['track' => $track]);
    }
}
