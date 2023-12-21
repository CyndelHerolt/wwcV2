<?php

namespace App\Controller\Phase1A;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Routing\Annotation\Route;

class JoueurPhase1AController extends AbstractController
{
    public function __construct(
        private HubInterface $hub,
    )
    {

    }

//    #[Route('/joueur/phase1/a', name: 'app_joueur_phase1_a')]
    public function index(): Response
    {
        return $this->render('joueur_phase1_a/joueur_phase1a.stream.html.twig', [
            'controller_name' => 'JoueurPhase1AController',
        ]);
    }
}
