<?php

namespace App\Controller\Phase1B;

use App\Entity\Equipe;
use App\Entity\Game;
use App\Entity\Offre;
use App\Entity\Proposition;
use App\Form\PropositionType;
use App\Repository\EquipeRepository;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class JoueurPhase1BController extends AbstractController
{
    public function __construct(
        private HubInterface     $hub,
        private EquipeRepository $equipeRepository,
    )
    {
    }

    public function index(
        ?Game $game,
    ): void
    {
        $equipe = $this->getUser()->getEquipe();

        // récupérer toutes les offres de la game avec visible = true
        $offres = $game->getOffres()->filter(function ($offre) {
            return $offre->isVisible() === true;
        });

        $this->hub->publish(new Update(
            'game-joueur/' . $game->getId(),
            $this->renderView('phase1_b/joueur_phase1b.stream.html.twig', [
                'game' => $game,
                'equipe' => $equipe ?? null,
                'offres' => $offres ?? null,
            ]),
            false
        ));
    }
}