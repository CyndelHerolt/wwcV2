<?php

namespace App\Controller\Phase1B;

use App\Entity\Game;
use App\Form\PropositionType;
use App\Repository\PropositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class JoueurPhase1BController extends AbstractController
{
    public function __construct(
        private HubInterface $hub,
        protected PropositionRepository $propositionRepository,
    )
    {
    }

    public function index(
        ?Game $game,
    ): void
    {
        // récupérer toutes les offres de la game avec visible = true
        $offres = $game->getOffres()->filter(function ($offre) {
            return $offre->isVisible() === true;
        });

        // créer un formulaire pour chaque proposition
        $forms = [];
        foreach ($offres as $offre) {
            // récupérer la proposition de cette equipe liée à cette offre
            $proposition = $this->propositionRepository->findOneBy([
                'equipe' => $this->getUser()->getEquipe(),
                'offre' => $offre,
            ]);
            $forms[$offre->getId()] = $this->createForm(PropositionType::class, $proposition)->createView();
        }

        // récupérer toutes les équipes de la game
        $equipes = $game->getEquipes();

        // envoyer une mise à jour Mercure pour chaque équipe
        foreach ($equipes as $equipe) {
            $this->hub->publish(new Update(
                'game-joueur/' . $game->getId() . '/equipe/' . $equipe->getId(),
                $this->renderView('phase1_b/joueur_phase1b.stream.html.twig', [
                    'game' => $game,
                    'equipe' => $equipe,
                    'offres' => $offres,
                    'forms' => $forms,
                ]),
                false
            ));
        }
    }
}