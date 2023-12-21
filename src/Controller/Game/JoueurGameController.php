<?php

namespace App\Controller\Game;

use App\Controller\Phase1A\JoueurPhase1AController;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/joueur')]
#[IsGranted('ROLE_JOUEUR')]
class JoueurGameController extends AbstractController
{
    public function __construct(
        private JoueurPhase1AController $joueurPhase1AController,
    )
    {
    }

    #[Route('/', name: 'app_joueur_game')]
    public function index(): Response
    {
        $game = $this->getUser()->getGame()->first();
        $equipe = $this->getUser()->getEquipe();

        if ($game === null) {
            $this->addFlash('error', 'Vous n\'avez pas de partie en cours');
            return $this->redirectToRoute('app_logout');
        }

        if ($game->getPhase() === "1a") {
            $this->joueurPhase1AController->index($game, $equipe);
        }

        return $this->render('joueur_game/index.html.twig', [
            'game' => $game,
            'equipe' => $equipe,
        ]);
    }
}
