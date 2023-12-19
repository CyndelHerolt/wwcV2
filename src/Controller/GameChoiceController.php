<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameChoiceController extends AbstractController
{
    public function __construct(
        private GameRepository $gameRepository,
    )
    {
        $this->gameRepository = $gameRepository;
    }

    #[Route('/game/choice', name: 'app_game_choice')]
    public function index(): Response
    {
        // n'autoriser que si connecté
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->isGranted('ROLE_MAITRE')) {
            $user = $this->getUser();
            // récupérer les parties liées créées par le user
            $games = $user->getGame();

        return $this->render('game_choice/index.html.twig', [
            'controller_name' => 'GameChoiceController',
            'games' => $games ?? null,
        ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

    #[Route('/game/choice/{id}', name: 'app_init_game')]
    public function initGame(int $id)
    {
        // n'autoriser que si connecté
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_login');
        }

        $game = $this->gameRepository->find($id);
        dd($game);

        return $this->redirectToRoute('app_game_choice');
    }
}
