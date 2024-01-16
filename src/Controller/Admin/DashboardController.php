<?php

namespace App\Controller\Admin;

use App\Entity\Equipe;
use App\Entity\Game;
use App\Entity\Offre;
use App\Entity\Profil;
use App\Entity\Role;
use App\Entity\Surface;
use App\Entity\TypeOffre;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
//        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('Admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('World Wide Company')
            ->setTranslationDomain('admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToUrl('Retour au jeu', 'fas fa-user', '/maitre');

        yield MenuItem::section('Paramétrage de la partie');
        yield MenuItem::linkToCrud('Game', 'fas fa-gamepad', Game::class);
        yield MenuItem::linkToCrud('Offres', 'fas fa-list', Offre::class);
        yield MenuItem::linkToCrud('Type d\'offres', 'fas fa-list', TypeOffre::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Equipes', 'fas fa-users', Equipe::class);
        yield MenuItem::linkToCrud('Role', 'fas fa-users', Role::class);
        yield MenuItem::linkToCrud('Profil', 'fas fa-users', Profil::class);
        yield MenuItem::linkToCrud('Surface', 'fas fa-building', Surface::class);
    }
}
