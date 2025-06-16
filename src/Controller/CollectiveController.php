<?php

namespace App\Controller;

use App\Domain\Collective\CollectivePersister;
use App\Domain\Images\UploadFilesHelper;
use App\Domain\Map\MapDataBuilder;
use App\Entity\Collective;
use App\Form\CollectiveType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class CollectiveController extends AbstractController
{
    #[Route('/collective/map/{map<[\w-]+>}', name: 'collective_index', methods: ['GET'])]
    public function index(MapDataBuilder $mapDataBuilder, ?string $map = 'metropolis'): Response
    {
        return $this->render('map/index.html.twig', ['collectives' => $mapDataBuilder->build(), 'map' => $map]);
    }

    #[Route('/collective/quick_new', name: 'collective_quick_new', methods: ['GET'])]
    public function quickNew(Request $request, CollectivePersister $persister, TranslatorInterface $translator): Response
    {
        $name = $request->query->getString('name');
        if (!$name) {
            return $this->render('collective/create/_quick.html.twig');
        }

        try {
            $collective = $persister->createQuick($name);
            $this->addFlash('success', $translator->trans('QuickGroupCreated', ['%groupName%' => $name]));

            return $this->redirectToRoute('track_new', ['createdCollectiveId' => $collective->getId()]);
        } catch (\Exception) {
            $this->addFlash('danger', $translator->trans('QuickGroupFailure', ['%groupName%' => $name]));

            return $this->redirectToRoute('track_new');
        }
    }

    #[Route('/collective/new/disclaimer', name: 'collective_new_disclaimer', methods: ['GET'])]
    public function newDisclaimer(): Response
    {
        return $this->render('collective/create/new_disclaimer.html.twig');
    }

    #[Route('/collective/new/{step<\d+>}', name: 'collective_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CollectivePersister $persister, int $step = 1): Response
    {
        $collective = $persister->fetchSessionCollective();
        $form = $this->createForm(CollectiveType::class, $collective, ['step' => $step])
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $isLastStep = $collective->isLastStep($step);
            $persister->persist($collective, $isLastStep);

            return $isLastStep
                ? $this->redirectToRoute('collective_index')
                : $this->redirectToRoute('collective_new', ['step' => $step + 1]);
        }

        return $this->render('collective/create/new.html.twig', ['form' => $form, 'step' => $step, 'collective' => $collective]);
    }

    #[Route('/collective/{id<\d+>}', name: 'collective_show', methods: ['GET'])]
    public function show(Collective $collective): Response
    {
        return $this->render('collective/show.html.twig', ['collective' => $collective]);
    }

    #[Route('/collective/{id<\d+>}/complete', name: 'collective_complete', methods: ['GET'])]
    public function complete(Collective $collective, CollectivePersister $persister): Response
    {
        $persister->updateSessionCollective($collective);

        return $this->redirectToRoute('collective_new');
    }

    #[Route('/collective/upload_image', name: 'collective_upload_image', methods: ['POST'])]
    public function uploadImage(Request $request, UploadFilesHelper $helper): JsonResponse
    {
        $fileThumbnailPath = $helper->uploadThumbnailToUploadDir($request->files);
        $responseStatus = null === $fileThumbnailPath ? Response::HTTP_BAD_REQUEST : Response::HTTP_OK;

        return $this->json(['publicImagePath' => $fileThumbnailPath], $responseStatus);
    }

    #[Route('/collective/{id<\d+>}', name: 'collective_delete', methods: ['POST'])]
    public function delete(Request $request, Collective $collective, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collective->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($collective);
            $entityManager->flush();
        }

        return $this->redirectToRoute('collective_index', [], Response::HTTP_SEE_OTHER);
    }
}
