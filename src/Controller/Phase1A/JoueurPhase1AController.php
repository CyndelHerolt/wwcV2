<?php

namespace App\Controller\Phase1A;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class JoueurPhase1AController extends AbstractController
{
    public function __construct(
        private HubInterface $hub,
    )
    {
    }

    public function index(
        ?Game $game,
    ): void
    {
        // récupérer toutes les équipes de la game
        $equipes = $game->getEquipes();

        // envoyer une mise à jour Mercure pour chaque équipe
        foreach ($equipes as $equipe) {
            $this->hub->publish(new Update(
                'game-joueur/' . $game->getId() . '/equipe/' . $equipe->getId(),
                $this->renderView('phase1_a/joueur_phase1a.stream.html.twig', [
                    'game' => $game,
                    'equipe' => $equipe,
                ]),
                false
            ));
        }
    }
}
