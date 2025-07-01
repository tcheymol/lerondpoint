<?php

namespace App\Controller;

use App\Entity\Page;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/page')]
final class PageController extends AbstractController
{
    #[Route('/{slug}', name: 'page', methods: ['GET'])]
    public function page(
        #[MapEntity(mapping: ['slug' => 'slug'])] Page $page,
    ): Response {
        return $this->render('page/index.html.twig', ['page' => $page]);
    }
}
