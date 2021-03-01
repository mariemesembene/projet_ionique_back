<?php

namespace App\Controller\Admin;




use App\Entity\User;
use App\Entity\Roles;
use App\Entity\Agences;
use App\Entity\Clients;
use App\Entity\Comptes;
use App\Entity\Transaction;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Projet Ionique');
    }
    public function __construct(UserPasswordEncoderInterface $pwdEncoder)
    {
        $this->pwdEncoder= $pwdEncoder;
      
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Agences', 'fas fa-list', Agences::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Transaction', 'fas fa-list', Transaction::class);
        yield MenuItem::linkToCrud('Roles', 'fas fa-list', Roles::class);
        yield MenuItem::linkToCrud('Clients', 'fas fa-list', Clients::class);
        yield MenuItem::linkToCrud('Comptes', 'fas fa-list', Comptes::class);
        
        
        
    }
}
