<?php

namespace App\Controller\Propositions;

use App\Controller\Phase1B\MaitrePhase1BController;
use App\Entity\EstimationRole;
use App\Entity\Proposition;
use App\Form\PropositionType;
use App\Repository\EquipeRepository;
use App\Repository\EstimationRoleRepository;
use App\Repository\OffreRepository;
use App\Repository\PropositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
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
        private readonly RequestStack   $session,
        private EstimationRoleRepository $estimationRoleRepository,
    )
    {
    }

    #[Route('/proposition/create/{equipeId}/{offreId}', name: 'app_proposition_create')]
    public function create(?int $offreId, ?int $equipeId): Response
    {
        $offre = $this->offreRepository->findOneBy(['id' => $offreId]);
        $equipe = $this->equipeRepository->findOneBy(['id' => $equipeId]);
        $game = $offre->getGame();

        $proposition = new Proposition();
        $proposition->setOffre($offre);
        $proposition->setEquipe($equipe);
        // pour chaque role de l'offre, créer une estimationRole
        foreach ($offre->getBesoinRole() as $besoinRole) {
            $estimationRole = new EstimationRole();
            $estimationRole->setRole($besoinRole->getRole());
            $estimationRole->setNbJours(0);
            // Ajoutez l'EstimationRole à la Proposition
            $proposition->addEstimationRole($estimationRole);
        }
        $this->propositionRepository->save($proposition);
        // ajouter l'offre à la session
        $this->session->getSession()->set('offre', $proposition->getOffre()->getId());

        // créer un formulaire pour la proposition
        $form = $this->createForm(PropositionType::class, $proposition, ['game'=>$game]);

        $this->hub->publish(new Update(
            'game-joueur/' . $equipeId . '/' . $offreId,
            $this->renderView('proposition/form.stream.html.twig', [
                'proposition' => $proposition,
                'form' => $form->createView(),
                'offre' => $offre,
                'game' => $game,
            ]),
            false
        ));

        $game = $proposition->getEquipe()->getGame();
        $offres = $this->offreRepository->findBy(['game' => $game, 'visible' => true]);
        $equipes = $this->equipeRepository->findBy(['game' => $game]);
        if($this->session->getSession()->get('offre') !== null) {
            $offreUpdated = $this->session->getSession()->get('offre');
        } else {
            $offreUpdated = null;
        }
        $this->maitrePhase1BController->index($game, $offres, $equipes, $offreUpdated);

        return $this->render('proposition/form.stream.html.twig', [
            'proposition' => $proposition,
            'form' => $form->createView(),
            'offre' => $offre,
            'game' => $game,
        ]);
    }

    #[Route('/proposition/{id}/update', name: 'app_proposition_update', methods: ['POST'])]
    public function update(?int $id, Request $request): Response
    {
        $proposition = $this->propositionRepository->find($id);
        $game = $proposition->getEquipe()->getGame();

        $form = $this->createForm(PropositionType::class, $proposition, ['game'=>$game]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // The $proposition object now contains the submitted data
            // You can now save $proposition to the database

            $this->propositionRepository->save($proposition);
            // ajouter l'offre à la session
            $this->session->getSession()->set('offre', $proposition->getOffre()->getId());

            // ajouter un message flash a la session
            $this->addFlash('success', 'Proposition mise à jour');

            // actualiser le contenu côté mj
            $game = $this->getUser()->getEquipe()->getGame();
            $offres = $this->offreRepository->findBy(['game' => $game, 'visible' => true]);
            $equipes = $this->equipeRepository->findBy(['game' => $game]);
            if($this->session->getSession()->get('offre') !== null) {
                $offreUpdated = $this->session->getSession()->get('offre');
            } else {
                $offreUpdated = null;
            }
            $this->maitrePhase1BController->index($game, $offres, $equipes, $offreUpdated);

            return $this->redirectToRoute('app_joueur_game');
        }

        return $this->render('proposition/form.stream.html.twig', [
            'offre' => $proposition->getOffre(),
            'proposition' => $proposition,
            'form' => $form->createView(),
            'game' => $game,
        ]);
    }

    #[Route('/proposition/delete/{id}', name: 'app_proposition_delete')]
    public function delete(?int $id): Response
    {
        $proposition = $this->propositionRepository->find($id);
        $game = $proposition->getEquipe()->getGame();

        $offre = $proposition->getOffre();
        $equipe = $proposition->getEquipe();

        $this->propositionRepository->remove($proposition);

        // actualiser le contenu côté mj
        $game = $this->getUser()->getEquipe()->getGame();
        $offres = $this->offreRepository->findBy(['game' => $game, 'visible' => true]);
        $equipes = $this->equipeRepository->findBy(['game' => $game]);
        if($this->session->getSession()->get('offre') !== null) {
            $offreUpdated = $this->session->getSession()->get('offre');
        } else {
            $offreUpdated = null;
        }
        $this->maitrePhase1BController->index($game, $offres, $equipes, $offreUpdated);

        return $this->render('proposition/empty_form.stream.html.twig', [
            'offre' => $offre,
            'equipe' => $equipe,
            'game' => $game,
        ]);
    }

    #[Route('/proposition/{id}/etat/', name: 'app_proposition_state')]
    public function changeState(?int $id): Response
    {
        $proposition = $this->propositionRepository->find($id);

        $proposition->setEtat(!$proposition->isEtat());
        $this->propositionRepository->save($proposition);

        $this->session->getSession()->set('offre', $proposition->getOffre()->getId());

        return $this->redirectToRoute('app_maitre_game');
    }
}