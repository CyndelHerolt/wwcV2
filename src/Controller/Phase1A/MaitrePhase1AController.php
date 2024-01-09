<?php

namespace App\Controller\Phase1A;

use App\Entity\Game;
use App\Entity\Offre;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

class MaitrePhase1AController extends AbstractController
{
    public function __construct(
        private HubInterface $hub,
    )
    {
    }

//    #[Route('/maitre/phase1/a', name: 'app_maitre_phase1_a')]
    public function maitre_phase(
        ?Game       $game,
        ?array $offres,
    ): void
    {
        $this->hub->publish(new Update(
            'game-maitre/' . $this->getUser()->getId(),
            $this->renderView('phase1a/maitre_phase1a.stream.html.twig', [
                'offres' => $offres,
                'game' => $game,
            ]),
            false
        ));

    }
}
