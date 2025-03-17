<?php

namespace App\Controller\Admin;

use App\Entity\Action;
use App\Entity\Attachment;
use App\Entity\Collective;
use App\Entity\Invitation;
use App\Entity\Track;
use App\Entity\TrackKind;
use App\Entity\TrackTag;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    /** @throws NotFoundExceptionInterface|ContainerExceptionInterface */
    #[\Override]
    public function index(): Response
    {
        /** @var AdminUrlGenerator $adminUrlGenerator */
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    #[\Override]
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Gjaune')
            ->setFaviconPath('jacket.png');
    }

    #[\Override]
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Home', 'fas fa-house-user text-success', 'home')->setCssClass('text-success');
        yield MenuItem::linkToDashboard('Admin', 'fa fa-gears');

        yield MenuItem::section('Users');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);

        yield MenuItem::section('Collectives');
        yield MenuItem::linkToCrud('Collectives', 'fas fa-people-arrows', Collective::class);
        yield MenuItem::linkToCrud('Actions', 'fas fa-location-crosshairs', Action::class);
        yield MenuItem::linkToCrud('Invitations', 'fas fa-envelope', Invitation::class);

        yield MenuItem::section('Tracks');
        yield MenuItem::linkToCrud('Tracks', 'fas fa-clipboard', Track::class);
        yield MenuItem::linkToCrud('Kinds', 'fas fa-layer-group', TrackKind::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-tag', TrackTag::class);

        yield MenuItem::section('Misc');
        yield MenuItem::linkToCrud('Attachments', 'fas fa-link', Attachment::class);
    }
}
