<?php

namespace App\Controller;

use App\Repository\FeatureToggleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LegalController extends AbstractController
{
    public function __construct(private readonly FeatureToggleRepository $featureToggleRepository)
    {
    }

    private function isWysiwygEnabled(): bool
    {
        return $this->featureToggleRepository->findOneBy(['name' => 'wysiwyg'])?->isEnabled() ?? false;
    }

    #[Route('/legal/privacy', name: 'app_privacy', methods: ['GET'])]
    public function privacy(): Response
    {
        return $this->isWysiwygEnabled()
            ? $this->redirectToRoute('page', ['slug' => 'confidentialite-et-moderation'])
            : $this->render('legal/privacy.html.twig');
    }

    #[Route('/legal/terms', name: 'app_terms', methods: ['GET'])]
    public function terms(): Response
    {
        return $this->isWysiwygEnabled()
            ? $this->redirectToRoute('page', ['slug' => 'conditions-generales-d-utilisation-cgu'])
            : $this->render('legal/terms.html.twig');
    }
}
