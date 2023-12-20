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
    public function index(
        ?Game       $game,
        ?array $offres,
    ): Response
    {
        $this->hub->publish(new Update(
            'game/' . $game->getId(),
            $this->renderView('maitre_phase1_a/phase1a.stream.html.twig', [
                'offres' => $offres,
                'game' => $game,
            ]),
            false
        ));

        return $this->render('maitre_phase1_a/phase1a.stream.html.twig', [
            'game' => $game,
            'offres' => $offres,
        ]);
    }
}
