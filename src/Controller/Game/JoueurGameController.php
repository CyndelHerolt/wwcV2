<?php

namespace App\Controller\Game;

use App\Controller\Phase1B\JoueurPhase1BController;
use App\Form\PropositionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/joueur')]
#[IsGranted('ROLE_JOUEUR')]
class JoueurGameController extends AbstractController
{
    public function __construct(
        private JoueurPhase1BController $joueurPhase1BController,
    )
    {
    }

    #[Route('/', name: 'app_joueur_game', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $game = $this->getUser()->getGame()->first();
//        $equipe = $this->getUser()->getEquipe();

        // récupérer toutes les offres de la game avec visible = true
        $offres = $game->getOffres()->filter(function ($offre) {
            return $offre->isVisible() === true;
        });

        // créer un formulaire pour chaque proposition
        $forms = [];
        foreach ($offres as $offre) {
            $forms[$offre->getId()] = $this->createForm(PropositionType::class)->createView();
        }

        if ($game === null) {
            $this->addFlash('error', 'Vous n\'avez pas de partie en cours');
            return $this->redirectToRoute('app_logout');
        }

        if ($game->getPhase() === '1b') {
            $this->joueurPhase1BController->index($game);
        }

        return $this->render('joueur_game/index.html.twig', [
            'game' => $game,
            'offres' => $offres ?? null,
            'forms' => $forms ?? null,
        ]);
    }
}
