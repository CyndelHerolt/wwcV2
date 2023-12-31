<?php

namespace App\Controller\Game;

use App\Controller\Phase1B\JoueurPhase1BController;
use App\Controller\Phase2A\JoueurPhase2AController;
use App\Form\PropositionType;
use App\Repository\GameRepository;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/joueur')]
#[IsGranted('ROLE_JOUEUR')]
class JoueurGameController extends AbstractController
{
    public function __construct(
        private JoueurPhase1BController $joueurPhase1BController,
        private JoueurPhase2AController $joueurPhase1CController,
        private OffreRepository         $offreRepository,
        private GameRepository          $gameRepository,
        private readonly RequestStack   $session,
    )
    {
    }

    #[Route('/', name: 'app_joueur_game', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $this->session->getSession()->set('game', $this->getUser()->getEquipe()->getGame());

        $game = $this->getUser()->getEquipe()->getGame();
//        $equipe = $this->getUser()->getEquipe();

        $offres = $this->offreRepository->findBy(['game' => $game, 'visible' => true]);

        // créer un formulaire pour chaque proposition
        $forms = [];
        foreach ($offres as $offre) {
            foreach ($offre->getPropositions() as $proposition) {
                $forms[$offre->getId()][$proposition->getEquipe()->getId()] = $this->createForm(PropositionType::class, $proposition, ['game'=>$game])->createView();
            }
        }

        if ($game === null) {
            $this->addFlash('error', 'Vous n\'avez pas de partie en cours');
            return $this->redirectToRoute('app_logout');
        }

        if ($game->getPhase() === '1b') {
            if($this->session->getSession()->get('offre') !== null) {
                $offreUpdated = $this->session->getSession()->get('offre');
            } else {
                $offreUpdated = null;
            }
            $this->joueurPhase1BController->index($game, $offreUpdated);
        }
        elseif ($game->getPhase() === '2a') {

        }

        return $this->render('joueur_game/index.html.twig', [
            'game' => $game,
            'offres' => $offres ?? null,
            'forms' => $forms ?? null,
        ]);
    }
}
