<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LegalController extends AbstractController
{
    #[Route('/legal/privacy', name: 'app_privacy', methods: ['GET'])]
    public function privacy(bool $isWysiwyg): Response
    {
        return $isWysiwyg
            ? $this->redirectToRoute('page', ['slug' => 'confidentialite-et-moderation'])
            : $this->render('legal/privacy.html.twig');
    }

    #[Route('/legal/terms', name: 'app_terms', methods: ['GET'])]
    public function terms(bool $isWysiwyg): Response
    {
        return $isWysiwyg
            ? $this->redirectToRoute('page', ['slug' => 'conditions-generales-d-utilisation-cgu'])
            : $this->render('legal/terms.html.twig');
    }
}
