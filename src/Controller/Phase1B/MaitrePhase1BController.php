<?php

namespace App\Controller\Phase1B;

use App\Entity\Game;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

class MaitrePhase1BController extends AbstractController
{
    public function __construct(
        private HubInterface   $hub,
        private UserRepository $userRepository,
    )
    {
    }

//    #[Route('/maitre/phase1/b', name: 'app_maitre_phase1_b')]
    public function index(?Game $game, array $offres, array $equipes): void
    {
        $maitres = $this->userRepository->findByGameAndRole($game, 'ROLE_MAITRE');

        foreach ($maitres as $maitre) {
            $this->hub->publish(new Update(
                'game-maitre/' . $maitre->getId(),
                $this->renderView('phase1_b/maitre_phase1b.stream.html.twig', [
                    'game' => $game,
                    'equipes' => $equipes,
                    'offres' => $offres,
                    'maitre' => $maitre,
                ]),
                false
            ));
        }
    }
}
