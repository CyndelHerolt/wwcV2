<?php

namespace App\Controller\Offres;

use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffreController extends AbstractController
{
    public function __construct(
        private OffreRepository $offreRepository,
    )
    {

    }

    #[Route('/offre/{id}/visibilite/', name: 'app_offre_visibilite')]
    public function visibilite(?int $id): Response
    {
        $offre = $this->offreRepository->find($id);

        $offre->setVisible(!$offre->isVisible());
        $this->offreRepository->save($offre);

        return $this->redirectToRoute('app_maitre_game');
    }
}
