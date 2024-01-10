<?php

namespace App\Controller\Phase1B;

use App\Entity\Game;
use App\Form\PropositionType;
use App\Repository\OffreRepository;
use App\Repository\PropositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class JoueurPhase1BController extends AbstractController
{
    public function __construct(
        private HubInterface $hub,
        protected PropositionRepository $propositionRepository,
        protected OffreRepository $offreRepository,
        private readonly RequestStack $session,
    )
    {
    }

    public function index(
        ?Game $game,
        ?int $offreId
    ): void
    {
        // récupérer toutes les offres de la game avec visible = true
        $offres = $game->getOffres()->filter(function ($offre) {
            return $offre->isVisible() === true;
        });

        // créer un formulaire pour chaque proposition
        $forms = [];
        foreach ($offres as $offre) {
            foreach ($offre->getPropositions() as $proposition) {
                $forms[$offre->getId()][$proposition->getEquipe()->getId()] = $this->createForm(PropositionType::class, $proposition, ['game'=>$game])->createView();
            }
        }

        // récupérer toutes les équipes de la game
        $equipes = $game->getEquipes();

        if ($offreId !== null) {
            $offreUpdated = $this->offreRepository->find($offreId);
        } else {
            $offreUpdated = $offres[0] ?? null;
        }

        // envoyer une mise à jour Mercure pour chaque équipe
        foreach ($equipes as $equipe) {
            $this->hub->publish(new Update(
                'game-joueur/' . $game->getId() . '/equipe/' . $equipe->getId(),
                $this->renderView('phase1b/joueur_phase1b.stream.html.twig', [
                    'game' => $game,
                    'equipe' => $equipe,
                    'offres' => $offres,
                    'forms' => $forms,
                    'offreUpdated' => $offreUpdated ?? null,
                ]),
                false
            ));
        }
    }
}