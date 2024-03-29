<?php

namespace App\Controller\Game;

use App\Classes\DataUserSession;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_MAITRE')]
class GameChoiceController extends AbstractController
{
    public function __construct(
        protected GameRepository $gameRepository,
        private readonly RequestStack $session,
    )
    {
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
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_login');
        }

        $game = $this->gameRepository->find($id);

        // ajouter le jeu à la session
        $this->session->getSession()->set('game', $game);

        return $this->redirectToRoute('admin');
    }
}
