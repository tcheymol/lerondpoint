<?php

namespace App\Controller;

use App\Domain\Track\TrackPersister;
use App\Entity\Track;
use App\Form\TrackType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreateTrackAnonymousController extends AbstractController
{
    #[Route('/anonymous/track/new/index', name: 'track_new_index', methods: ['GET', 'POST'])]
    public function newIndex(): Response
    {
        return $this->getUser()
            ? $this->redirectToRoute('track_new')
            : $this->redirectToRoute('track_new_anonymous');
    }

    #[Route('/anonymous/track/new/', name: 'track_new_anonymous', methods: ['GET', 'POST'])]
    public function newAnonymous(Request $request, TrackPersister $persister): Response
    {
        $track = new Track();
        $form = $this->createForm(TrackType::class, $track)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $persister->persist($track);

            return $this->redirectToRoute('track_new_add_main_information', ['id' => $track->getId()]);
        }

        return $this->render('track/new/create.html.twig', ['form' => $form]);
    }
}
