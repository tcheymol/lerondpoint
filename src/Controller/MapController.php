<?php

namespace App\Controller;

use App\Domain\Map\MapDataBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MapController extends AbstractController
{
    #[Route('/map', name: 'app_map')]
    public function index(MapDataBuilder $mapDataBuilder): Response
    {
        return $this->render('map/index.html.twig', ['collectives' => $mapDataBuilder->build()]);
    }
}
