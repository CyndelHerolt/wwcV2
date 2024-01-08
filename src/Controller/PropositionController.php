<?php

namespace App\Controller;

use App\Controller\Phase1B\MaitrePhase1BController;
use App\Entity\Proposition;
use App\Form\PropositionType;
use App\Repository\EquipeRepository;
use App\Repository\OffreRepository;
use App\Repository\PropositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Attribute\Route;

class PropositionController extends AbstractController
{

    public function __construct(
        private HubInterface            $hub,
        private PropositionRepository   $propositionRepository,
        private OffreRepository         $offreRepository,
        private EquipeRepository        $equipeRepository,
        private MaitrePhase1BController $maitrePhase1BController,
    )
    {
    }

    #[Route('/proposition/create/{equipeId}/{offreId}', name: 'app_proposition_create')]
    public function create(?int $offreId, ?int $equipeId): Response
    {
        $offre = $this->offreRepository->findOneBy(['id' => $offreId]);
        $equipe = $this->equipeRepository->findOneBy(['id' => $equipeId]);

        $proposition = new Proposition();
        $proposition->setOffre($offre);
        $proposition->setEquipe($equipe);
        $this->propositionRepository->save($proposition);

        // créer un formulaire pour la proposition
        $form = $this->createForm(PropositionType::class, $proposition);

        $this->hub->publish(new Update(
            'game-joueur/' . $equipeId . '/' . $offreId,
            $this->renderView('proposition/form.stream.html.twig', [
                'proposition' => $proposition,
                'form' => $form->createView(),
                'offre' => $offre,
            ]),
            false
        ));

        $game = $this->getUser()->getEquipe()->getGame();
        $offres = $this->offreRepository->findBy(['game' => $game, 'visible' => true]);
        $equipes = $this->equipeRepository->findBy(['game' => $game]);
        $this->maitrePhase1BController->index($game, $offres, $equipes);

        return $this->render('proposition/form.stream.html.twig', [
            'proposition' => $proposition,
            'form' => $form->createView(),
            'offre' => $offre,
        ]);
    }

#[Route('/proposition/{id}/update', name: 'app_proposition_update', methods: ['POST'])]
public function update(?int $id, Request $request): Response
{
    $proposition = $this->propositionRepository->find($id);

    $form = $this->createForm(PropositionType::class, $proposition);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // The $proposition object now contains the submitted data
        // You can now save $proposition to the database

        $this->propositionRepository->save($proposition);

        $game = $this->getUser()->getEquipe()->getGame();
        $offres = $this->offreRepository->findBy(['game' => $game, 'visible' => true]);
        $equipes = $this->equipeRepository->findBy(['game' => $game]);
        $this->maitrePhase1BController->index($game, $offres, $equipes);

        // Redirect to the game page or another appropriate page
        return $this->redirectToRoute('app_joueur_game');
    }

    // If the form is not submitted or not valid, re-display the form
    return $this->render('proposition/form.stream.html.twig', [
        'offre' => $proposition->getOffre(),
        'proposition' => $proposition,
        'form' => $form->createView(),
    ]);
}

    #[Route('/proposition/delete/{id}', name: 'app_proposition_delete')]
    public function delete(?int $id): Response
    {
        $proposition = $this->propositionRepository->find($id);

        $offre = $proposition->getOffre();
        $equipe = $proposition->getEquipe();

        $this->propositionRepository->remove($proposition);

        return $this->render('proposition/empty_form.stream.html.twig', [
            'offre' => $offre,
            'equipe' => $equipe,
        ]);
    }

    #[Route('/proposition/{id}/etat/', name: 'app_proposition_state')]
    public function changeState(?int $id): Response
    {
        $proposition = $this->propositionRepository->find($id);

        $proposition->setEtat(!$proposition->isEtat());
        $this->propositionRepository->save($proposition);

        return $this->redirectToRoute('app_maitre_game');
    }
}