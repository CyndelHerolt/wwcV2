<?php

namespace App\Controller\Game;

use App\Classes\DataUserSession;
use App\Controller\Phase1A\JoueurPhase1AController;
use App\Controller\Phase1A\MaitrePhase1AController;
use App\Controller\Phase1B\JoueurPhase1BController;
use App\Controller\Phase1B\MaitrePhase1BController;
use App\Controller\Phase2A\JoueurPhase2AController;
use App\Form\ProjetType;
use App\Form\PropositionType;
use App\Repository\EquipeRepository;
use App\Repository\GameRepository;
use App\Repository\OffreRepository;
use App\Repository\ProfilRepository;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/maitre')]
#[IsGranted('ROLE_MAITRE')]
class MaitreGameController extends AbstractController
{
    public function __construct(
        private DataUserSession         $dataUserSession,
        private MaitrePhase1AController $maitrePhase1AController,
        private MaitrePhase1BController $maitrePhase1BController,
        private JoueurGameController    $joueurGameController,
        private JoueurPhase1AController $joueurPhase1AController,
        private JoueurPhase1BController $joueurPhase1BController,
        private JoueurPhase2AController $joueurPhase2AController,
        private OffreRepository         $offreRepository,
        private GameRepository          $gameRepository,
        private EquipeRepository        $equipeRepository,
        private ProjetRepository        $projetRepository,
        private ProfilRepository        $profilRepository,
        private HubInterface            $hub,
        private readonly RequestStack   $session,
    )
    {
    }

    #[Route('/', name: 'app_maitre_game')]
    public function index(): Response
    {
        $gameId = $this->dataUserSession->getGame()->getId();
        $game = $this->gameRepository->find($gameId);

        $maitre = $this->getUser();

        if ($game === null) {
            $this->addFlash('error', 'Vous n\'avez pas de partie en cours');
            return $this->redirectToRoute('app_game_choice');
        }

        if ($game->getPhase() === "1a") {
            $offres = $this->offreRepository->findBy(['game' => $game]);
            $this->maitrePhase1AController->maitre_phase($game, $offres);
        } elseif ($game->getPhase() === "1b") {
            $offres = $this->offreRepository->findBy(['game' => $game, 'visible' => true]);
            $equipes = $this->equipeRepository->findBy(['game' => $game]);
            if ($this->session->getSession()->get('offre') !== null) {
                $offreUpdated = $this->session->getSession()->get('offre');
            } else {
                $offreUpdated = null;
            }
            $this->maitrePhase1BController->index($game, $offres, $equipes, $offreUpdated);
        }

        return $this->render('maitre_game/index.html.twig', [
            'game' => $game,
            'offres' => $offres ?? null,
            'equipes' => $equipes ?? null,
            'maitre' => $maitre ?? null,
        ]);
    }

    #[Route('/next/{id}', name: 'app_maitre_game_next_phase')]
    public function nextPhase(?int $id)
    {
        $game = $this->gameRepository->find($id);

        if ($game === null) {
            $this->addFlash('error', 'Vous n\'avez pas de partie en cours');
            return $this->redirectToRoute('admin');
        }

        if ($this->session->getSession()->get('offre') !== null) {
            $offreUpdated = $this->session->getSession()->get('offre');
        } else {
            $offreUpdated = null;
        }

        if ($game->getPhase() === "1a") {
            $game->setPhase("1b");
            $this->joueurPhase1BController->index($game, $offreUpdated);
        } elseif ($game->getPhase() === "1b") {
            $game->setPhase("2a");
            $this->joueurPhase2AController->index($game);
        }
        $this->gameRepository->save($game, true);

        return $this->redirectToRoute('app_maitre_game');
    }

    #[Route('/previous/{id}', name: 'app_maitre_game_previous_phase')]
    public function previousPhase(?int $id)
    {
        $game = $this->gameRepository->find($id);

        if ($game === null) {
            $this->addFlash('error', 'Vous n\'avez pas de partie en cours');
            return $this->redirectToRoute('admin');
        }

        if ($this->session->getSession()->get('offre') !== null) {
            $offreUpdated = $this->session->getSession()->get('offre');
        } else {
            $offreUpdated = null;
        }

        if ($game->getPhase() === "1b") {
            $game->setPhase("1a");
            $this->joueurPhase1AController->index($game);
        } elseif ($game->getPhase() === "2a") {
            $game->setPhase("1b");
            $this->joueurPhase1BController->index($game, $offreUpdated);
        }
        $this->gameRepository->save($game, true);

        return $this->redirectToRoute('app_maitre_game');
    }

    #[Route('/pause/{id}', name: 'app_maitre_game_pause')]
    public function pause(?int $id)
    {
        $game = $this->gameRepository->find($id);
        $game->setPause(!$game->isPause());
        $phase = $game->getPhase();
        $equipes = $this->equipeRepository->findBy(['game' => $game]);

        // récupérer toutes les offres de la game avec visible = true
        $offres = $game->getOffres()->filter(function ($offre) {
            return $offre->isVisible() === true;
        });

        // créer un formulaire pour chaque proposition
        $forms = [];
        foreach ($offres as $offre) {
            foreach ($offre->getPropositions() as $proposition) {
                $forms[$offre->getId()][$proposition->getEquipe()->getId()] = $this->createForm(PropositionType::class, $proposition, ['game' => $game])->createView();
            }
        }

        if ($this->session->getSession()->get('offre') !== null) {
            $offre = $this->offreRepository->find($this->session->getSession()->get('offre'));
            $offreUpdated = $offre;
        } else {
            $offreUpdated = null;
        }

        $this->gameRepository->save($game);

        foreach ($equipes as $equipe) {
            $projets = $this->projetRepository->findBy(['equipe' => $equipe]);
            // créer un formulaire pour chaque assigneRole
            if ($projets !== null) {
                $projetForms = [];
                foreach ($projets as $projet) {
                    $form = $this->createForm(ProjetType::class, $projet, ['game' => $game]);
                    $projetForms[$projet->getId()] = $form->createView();
                }
            }

            $profils = $this->profilRepository->findBy(['equipe' => null]);

            $this->hub->publish(new Update(
                'game-joueur/' . $game->getId() . '/equipe/' . $equipe->getId(),
                $this->renderView('phase' . $phase . '/joueur_phase' . $phase . '.stream.html.twig', [
                    'game' => $game,
                    'equipe' => $equipe,
                    'offres' => $offres,
                    'forms' => $forms,
                    'offreUpdated' => $offreUpdated,
                    'projetForms' => $projetForms,
                    'profils' => $profils,
                ]),
                false
            ));
        }

        return $this->redirectToRoute('app_maitre_game');
    }
}
