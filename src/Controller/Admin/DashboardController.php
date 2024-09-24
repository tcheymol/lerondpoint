<?php

namespace App\Controller\Admin;

use App\Entity\Action;
use App\Entity\ActionKind;
use App\Entity\ActionTag;
use App\Entity\Attachment;
use App\Entity\Collective;
use App\Entity\Track;
use App\Entity\TrackKind;
use App\Entity\TrackTag;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    /** @throws NotFoundExceptionInterface|ContainerExceptionInterface */
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

         return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Gjaune')
            ->setFaviconPath('rp.png');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Home', 'fas fa-house-user text-success', 'home')->setCssClass('text-success');
        yield MenuItem::linkToDashboard('Admin', 'fa fa-gears');

        yield MenuItem::section('Users');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::section('Collectives');
        yield MenuItem::linkToCrud('Collectives', 'fas fa-people-arrows', Collective::class);

        yield MenuItem::section('Actions');
        yield MenuItem::linkToCrud('Actions', 'fas fa-location-crosshairs', Action::class);
        yield MenuItem::linkToCrud('Kinds', 'fas fa-layer-group', ActionKind::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-tag', ActionTag::class);

        yield MenuItem::section('Tracks');
        yield MenuItem::linkToCrud('Tracks', 'fas fa-clipboard', Track::class);
        yield MenuItem::linkToCrud('Kinds', 'fas fa-layer-group', TrackKind::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-tag', TrackTag::class);

        yield MenuItem::section('Misc');
        yield MenuItem::linkToCrud('Attachments', 'fas fa-link', Attachment::class);
    }
}
