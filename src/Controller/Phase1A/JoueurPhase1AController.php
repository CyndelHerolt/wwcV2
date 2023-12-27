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

    public function index(
        ?Game       $game,
    ): void
    {
        $equipe = $this->getUser()->getEquipe();

        $this->hub->publish(new Update(
            'game-joueur/' . $game->getId(),
            $this->renderView('phase1_a/joueur_phase1a.stream.html.twig', [
                'equipe' => $equipe,
                'game' => $game,
            ]),
            false
        ));
    }
}
