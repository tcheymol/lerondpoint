<?php

namespace App\Controller;

use App\Repository\FeatureToggleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AboutUsController extends AbstractController
{
    public function __construct(private readonly FeatureToggleRepository $featureToggleRepository)
    {
    }

    private function isWysiwygEnabled(): bool
    {
        return $this->featureToggleRepository->findOneBy(['name' => 'wysiwyg'])?->isEnabled() ?? false;
    }

    #[Route('/about_us', name: 'about_us', methods: ['GET'])]
    public function aboutUs(): Response
    {
        return $this->isWysiwygEnabled()
            ? $this->redirectToRoute('page', ['slug' => 'qui-sommes-nous'])
            : $this->render('about_us/index.html.twig');
    }

    #[Route('/support_us', name: 'support_us', methods: ['GET'])]
    public function supportUs(): Response
    {
        return $this->isWysiwygEnabled()
            ? $this->redirectToRoute('page', ['slug' => 'nous-soutenir-nous-contacter'])
            : $this->render('about_us/support_us.html.twig');
    }

    #[Route('/about_lrp', name: 'about_lrp', methods: ['GET'])]
    public function aboutLRP(): Response
    {
        return $this->isWysiwygEnabled()
            ? $this->redirectToRoute('page', ['slug' => 'autour-du-rond-point'])
            : $this->render('about_us/about_lrp.html.twig');
    }

    #[Route('/they_talk_about_us', name: 'they_talk_about_us', methods: ['GET'])]
    public function weTalkAboutUs(): Response
    {
        return $this->isWysiwygEnabled()
            ? $this->redirectToRoute('page', ['slug' => 'on-parle-de-nous'])
            : $this->render('about_us/they_talk_about_us.html.twig');
    }

    #[Route('/about_the_movement', name: 'about_the_movement', methods: ['GET'])]
    public function aboutTheMovement(): Response
    {
        return $this->isWysiwygEnabled()
            ? $this->redirectToRoute('page', ['slug' => 'A-propos-du-mouvement-des-gilets-jaunes'])
            : $this->render('about_us/about_the_movement.html.twig');
    }
}
