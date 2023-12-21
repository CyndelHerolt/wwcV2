<?php

namespace App\Controller\Phase1A;

use App\Entity\Equipe;
use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

class JoueurPhase1AController extends AbstractController
{
    public function __construct(
        private HubInterface $hub,
    )
    {
    }

//    #[Route('/joueur/phase1/a', name: 'app_joueur_phase1_a')]
    public function index(
        ?Game       $game,
        ?Equipe     $equipe,
    ): void
    {
        $this->hub->publish(new Update(
            'game-joueur/' . $equipe->getId(),
            $this->renderView('phase1_a/joueur_phase1a.stream.html.twig', [
                'equipe' => $equipe,
                'game' => $game,
            ]),
            false
        ));
    }
}
