<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        if ($this->isGranted('ROLE_MAITRE')) {
            return $this->redirectToRoute('admin');
        } elseif($this->isGranted('ROLE_JOUEUR')) {
            return $this->redirectToRoute('app_joueur_game');
        }

        return $this->redirectToRoute('app_login');
    }
}
