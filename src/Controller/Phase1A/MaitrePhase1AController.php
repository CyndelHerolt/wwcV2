<?php

namespace App\Controller\Phase1A;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaitrePhase1AController extends AbstractController
{
    #[Route('/maitre/phase1/a', name: 'app_maitre_phase1_a')]
    public function index(): Response
    {


        return $this->render('maitre_phase1_a/index.html.twig', [
            'controller_name' => 'MaitrePhase1AController',
        ]);
    }
}
