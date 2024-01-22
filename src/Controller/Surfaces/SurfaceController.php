<?php

namespace App\Controller\Surfaces;

use App\Repository\SurfaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SurfaceController extends AbstractController
{
    public function __construct (
        private SurfaceRepository $surfaceRepository,
    )
    {
    }

    #[Route('/surface/{id}/change', name: 'app_surface_change')]
    public function change(?int $id): Response
    {
    $surface = $this->surfaceRepository->find($id);

    $surface->addEquipe($this->getUser()->getEquipe());
    $this->surfaceRepository->save($surface);


        return $this->redirectToRoute('app_joueur_game');
    }

}