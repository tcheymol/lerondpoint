<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/maintenance', name: 'home_maintenance', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('maintenance/index.html.twig');
    }

    #[Route('/home', name: 'home', methods: ['GET'])]
    public function home(): Response
    {
        if ($this->getUser()) {
            return $this->render('home/index.html.twig');
        }

        return $this->render('maintenance/index.html.twig');
    }

    #[Route('/', name: 'root', methods: ['GET'])]
    public function root(): Response
    {
        return $this->redirectToRoute('home');
    }
}
