<?php

namespace App\Controller\Materiel;

use App\Repository\EquipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MaterielController extends AbstractController
{
    public function __construct (
        private EquipeRepository $equipeRepository,
    )
    {
    }

    #[Route('/materiel', name: 'app_materiel_add', methods: ['POST'])]
    public function index(
        Request $request,
    ): Response
    {
        $equipe = $this->getUser()->getEquipe();
        $equipe->setMateriel($equipe->getMateriel() + $_POST['materiel']);
        $equipe->setMaterielLoue($equipe->getMaterielLoue() + $_POST['materiel']);

        $this->equipeRepository->save($equipe);

        return $this->redirectToRoute('app_joueur_game');
    }

}