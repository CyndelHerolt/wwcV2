<?php

namespace App\Controller\Game;

use App\Controller\Phase1B\JoueurPhase1BController;
use App\Controller\Phase2A\JoueurPhase2AController;
use App\Form\AssigneRoleType;
use App\Form\ProjetType;
use App\Form\PropositionType;
use App\Repository\GameRepository;
use App\Repository\OffreRepository;
use App\Repository\ProfilRepository;
use App\Repository\ProjetRepository;
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
        private JoueurPhase2AController $joueurPhase2AController,
        private OffreRepository         $offreRepository,
        private GameRepository          $gameRepository,
        private ProjetRepository        $projetRepository,
        private ProfilRepository        $profilRepository,
        private readonly RequestStack   $session,
    )
    {
    }

    #[Route('/', name: 'app_joueur_game', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $this->session->getSession()->set('game', $this->getUser()->getEquipe()->getGame());

        $game = $this->getUser()->getEquipe()->getGame();

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
            $projets = $this->projetRepository->findBy(['equipe' => $this->getUser()->getEquipe()]);
            // créer un formulaire pour chaque assigneRole
            $projetForms = [];
            foreach ($projets as $projet) {
                $form = $this->createForm(ProjetType::class, $projet, ['game' => $game]);
                $projetForms[$projet->getId()] = $form->createView();
            }
            $this->joueurPhase2AController->index($game);
        }

        $profils = $this->profilRepository->findBy(['equipe' => null]);


        return $this->render('joueur_game/index.html.twig', [
            'game' => $game,
            'offres' => $offres ?? null,
            'forms' => $forms ?? null,
            'projetForms' => $projetForms ?? null,
            'profils' => $profils ?? null,
        ]);
    }
}
