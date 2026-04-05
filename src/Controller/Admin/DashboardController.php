<?php

namespace App\Controller\Admin;

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
            ->setTitle('Interface administrateur Le Rond-point')
            ->setFaviconPath('jacket.png');
    }

    #[\Override]
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Home', 'fas fa-house-user text-success', 'home')->setCssClass('text-success');
        yield MenuItem::linkToDashboard('Admin', 'fa fa-gears');

        yield MenuItem::section('Users');
        yield MenuItem::linkTo(UserCrudController::class, 'Users', 'fas fa-user');
        yield MenuItem::linkTo(NewsletterRegistrationCrudController::class, 'Newsletter', 'fas fa-envelope-open-text');

        yield MenuItem::section('Collectives');
        yield MenuItem::linkTo(CollectiveCrudController::class, 'Collectives', 'fas fa-people-arrows');
        yield MenuItem::linkTo(ActionCrudController::class, 'Actions', 'fas fa-location-crosshairs');
        yield MenuItem::linkTo(InvitationCrudController::class, 'Invitations', 'fas fa-envelope');

        yield MenuItem::section('Tracks');
        yield MenuItem::linkTo(TrackCrudController::class, 'Tracks', 'fas fa-clipboard');
        yield MenuItem::linkTo(TrackKindCrudController::class, 'Kinds', 'fas fa-layer-group');
        yield MenuItem::linkTo(TrackTagCrudController::class, 'Tags', 'fas fa-tag');
        yield MenuItem::linkTo(RegionCrudController::class, 'Regions', 'fas fa-map');
        yield MenuItem::linkTo(YearCrudController::class, 'Years', 'fas fa-calendar-days');
        yield MenuItem::linkTo(RejectionCauseCrudController::class, 'RejectionCause', 'fas fa-trash');
        yield MenuItem::linkTo(AttachmentCrudController::class, 'Attachments', 'fas fa-link');

        yield MenuItem::section('Misc');
        yield MenuItem::linkTo(PageCrudController::class, 'Pages', 'fas fa-clipboard');
        yield MenuItem::linkTo(FeatureToggleCrudController::class, 'FeatureToggles', 'fas fa-toggle-off');
    }
}
