<?php

namespace App\Controller\Game;

use App\Controller\Phase1A\JoueurPhase1AController;
use App\Entity\Game;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/joueur')]
#[IsGranted('ROLE_JOUEUR')]
class JoueurGameController extends AbstractController
{
    public function __construct(
        private JoueurPhase1AController $joueurPhase1AController,
        private HubInterface $hub,
    )
    {
    }

    #[Route('/', name: 'app_joueur_game')]
    public function index(): Response
    {
        $game = $this->getUser()->getGame()->first();
        $equipe = $this->getUser()->getEquipe();
        // récupérer toutes les offres de la game avec visible = true
        $offres = $game->getOffres()->filter(function ($offre) {
            return $offre->isVisible() === true;
        });

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
            'offres' => $offres ?? null,
        ]);
    }

    public function joueur_phase1A(
        ?Game       $game,
    ): void
    {
        $equipe = $this->getUser()->getEquipe();

        $this->hub->publish(new Update(
            'game-joueur/' . $game->getId(),
            $this->renderView('phase1_a/joueur_phase1a.stream.html.twig', [
                'game' => $game,
                'equipe' => $equipe,
            ]),
            false
        ));
    }

    public function joueur_phase1B(
        ?Game       $game,
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
