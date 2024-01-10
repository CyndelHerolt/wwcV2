<?php

namespace App\Controller\Projets;

use App\Form\AssigneRoleType;
use App\Form\ProjetType;
use App\Repository\AssigneRoleRepository;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjetController extends AbstractController
{

    public function __construct(
        private ProjetRepository $projetRepository,
        private AssigneRoleRepository $assigneRoleRepository,
    )
    {
    }

    #[Route('/projet/{id}/update', name: 'app_projet_update', methods: ['POST'])]
    public function update(?int $id, Request $request): Response
    {
        $projet = $this->projetRepository->find($id);
        $game = $projet->getEquipe()->getGame();

        $form = $this->createForm(ProjetType::class, $projet, ['game' => $game]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->projetRepository->save($projet);

            $this->addFlash('success', 'Le projet a bien été modifié');

            return $this->redirectToRoute('app_joueur_game');
        }

        return $this->render('projet/form.stream.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
            'game' => $game,
            'frameId' => 'projet-frame-' . $projet->getId()
        ]);
    }
}