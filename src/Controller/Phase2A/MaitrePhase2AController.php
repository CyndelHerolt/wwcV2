<?php

namespace App\Controller\Phase2A;

use App\Entity\Game;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class MaitrePhase2AController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private HubInterface    $hub,
    )
    {
    }

    public function index(?Game $game, ?array $equipes)
    {
        $maitres = $this->userRepository->findByGameAndRole($game, 'ROLE_MAITRE');

        foreach ($maitres as $maitre) {
            $this->hub->publish(new Update(
                'game-maitre/' . $maitre->getId(),
                $this->renderView('phase2a/maitre_phase2a.stream.html.twig', [
                    'game' => $game,
                    'equipes' => $equipes,
                    'maitre' => $maitre,
                    'projetUpdated' => $projetUpdated ?? null,
                ]),
                false
            ));
        }
    }
}