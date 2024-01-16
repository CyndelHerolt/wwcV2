<?php

namespace App\Controller\Profils;

use App\Repository\ProfilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class ProfilController extends AbstractController
{
    public function __construct(
        private ProfilRepository $profilRepository,
    )
    {
    }

    #[Route('/profil/{id}/recrute', name: 'app_profil_recrute')]
    public function recrute(?int $id)
    {
        $profil = $this->profilRepository->find($id);

        $profil->setEquipe($this->getUser()->getEquipe());
        $this->profilRepository->save($profil);

        return $this->redirectToRoute('app_joueur_game');
    }
}