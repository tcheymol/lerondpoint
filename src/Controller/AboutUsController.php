<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AboutUsController extends AbstractController
{
    #[Route('/about_us', name: 'about_us', methods: ['GET'])]
    public function aboutUs(): Response
    {
        return $this->render('about_us/index.html.twig');
    }

    #[Route('/support_us', name: 'support_us', methods: ['GET'])]
    public function supportUs(): Response
    {
        return $this->render('about_us/support_us.html.twig');
    }

    #[Route('/about_lrp', name: 'about_lrp', methods: ['GET'])]
    public function aboutLRP(): Response
    {
        return $this->render('about_us/about_lrp.html.twig');
    }

    #[Route('/they_talk_about_us', name: 'they_talk_about_us', methods: ['GET'])]
    public function weTalkAboutUs(): Response
    {
        return $this->render('about_us/they_talk_about_us.html.twig');
    }

    #[Route('/about_the_movement', name: 'about_the_movement', methods: ['GET'])]
    public function aboutTheMovement(): Response
    {
        return $this->render('about_us/about_the_movement.html.twig');
    }
}
