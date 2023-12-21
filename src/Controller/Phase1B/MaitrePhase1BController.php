<?php

namespace App\Controller\Phase1B;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

class MaitrePhase1BController extends AbstractController
{
    public function __construct(
        private HubInterface $hub,
    )
    {
    }

//    #[Route('/maitre/phase1/b', name: 'app_maitre_phase1_b')]
    public function index(?Game $game): void
    {
        $this->hub->publish(new Update(
            'game-maitre/' . $this->getUser()->getId(),
            $this->renderView('maitre_phase1_b/phase1b.stream.html.twig', [
                'hello' => 'world',
                'game' => $game,
            ]),
            false
        ));

    }
}
