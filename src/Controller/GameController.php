<?php

namespace App\Controller;

use App\Classes\DataUserSession;
use App\Controller\Phase1A\MaitrePhase1AController;
use App\Controller\Phase1B\MaitrePhase1BController;
use App\Repository\GameRepository;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/maitre')]
#[IsGranted('ROLE_MAITRE')]
class GameController extends AbstractController
{
    public function __construct(
        private DataUserSession         $dataUserSession,
        private MaitrePhase1AController $maitrePhase1AController,
        private MaitrePhase1BController $maitrePhase1BController,
        private OffreRepository         $offreRepository,
        private GameRepository          $gameRepository,
        private HubInterface            $hub,
    )
    {
    }

    #[Route('/', name: 'app_game')]
    public function index(): Response
    {
        $gameId = $this->dataUserSession->getGame()->getId();
        $game = $this->gameRepository->find($gameId);

        if ($game === null) {
            $this->addFlash('error', 'Vous n\'avez pas de partie en cours');
            return $this->redirectToRoute('app_game_choice');
        }

        if ($game->getPhase() === "1a") {
            $offres = $this->offreRepository->findBy(['game' => $game]);
            $this->maitrePhase1AController->index($game, $offres);
        } elseif ($game->getPhase() === "1b") {
            $offres = $this->offreRepository->findBy(['game' => $game]);
            $this->maitrePhase1BController->index($game);
        }

        return $this->render('game/index.html.twig', [
            'game' => $game,
            'offres' => $offres ?? null,
        ]);
    }

    #[Route('/game/next/{id}', name: 'app_game_next_phase')]
    public function nextPhase(?int $id)
    {
        $game = $this->gameRepository->find($id);

        if ($game === null) {
            $this->addFlash('error', 'Vous n\'avez pas de partie en cours');
            return $this->redirectToRoute('admin');
        }

        if ($game->getPhase() === "1a") {
            $game->setPhase("1b");
        } elseif ($game->getPhase() === "1b") {
            $game->setPhase("1c");
        }
        $this->gameRepository->save($game, true);

        return $this->redirectToRoute('app_game');
    }

    #[Route('/game/previous/{id}', name: 'app_game_previous_phase')]
    public function previousPhase(?int $id)
    {
        $game = $this->gameRepository->find($id);

        if ($game === null) {
            $this->addFlash('error', 'Vous n\'avez pas de partie en cours');
            return $this->redirectToRoute('admin');
        }

        if ($game->getPhase() === "1b") {
            $game->setPhase("1a");
        } elseif ($game->getPhase() === "1c") {
            $game->setPhase("1b");
        }
        $this->gameRepository->save($game, true);

        return $this->redirectToRoute('app_game');
    }
}
