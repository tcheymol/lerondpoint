<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/maintenance', name: 'home_maintenance')]
    public function index(): Response
    {
        return $this->redirectToRoute('maintenance');
    }

    #[Route('/home', name: 'home')]
    public function home(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/', name: 'root')]
    public function root(): Response
    {
        return $this->render('maintenance/index.html.twig');
//        return $this->render('home/index.html.twig');
    }
}
