<?php

namespace App\Controller\Phase2A;

use App\Entity\AssigneRole;
use App\Entity\Game;
use App\Entity\Projet;
use App\Form\AssigneRoleType;
use App\Form\ProjetType;
use App\Repository\AssigneRoleRepository;
use App\Repository\ProjetRepository;
use App\Repository\PropositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class JoueurPhase2AController extends AbstractController
{
    public function __construct(
        private HubInterface          $hub,
        private PropositionRepository $propositionRepository,
        private ProjetRepository      $projetRepository,
        private AssigneRoleRepository $assigneRoleRepository,
    )
    {
    }

    public function index(?Game $game): void
    {
        // récupérer toutes les équipes de la game
        $equipes = $game->getEquipes();

        // envoyer une mise à jour Mercure pour chaque équipe
        foreach ($equipes as $equipe) {
            $propositions = $this->propositionRepository->findBy(['equipe' => $equipe]);

            foreach ($propositions as $proposition) {
                // si il n'existe pas encore de projet pour cette offre et cette équipe
                if ($this->projetRepository->findOneBy(['offre' => $proposition->getOffre(), 'equipe' => $equipe]) === null && $proposition->isEtat() === true) {
                    $projet = new Projet();
                    $projet->setEquipe($equipe);
                    $projet->setOffre($proposition->getOffre());
                    $projet->setDebut($game->getPeriode());
                    $projet->setFin($game->getPeriode() + $proposition->getOffre()->getDeadline());
                    $projet->setPrix($proposition->getPrix());


                    $proposition->setProjet($projet);
                    $this->propositionRepository->save($proposition);

                    $roles = $proposition->getOffre()->getBesoinRole();

                    foreach ($roles as $role) {
                        // si il n'existe pas encore de assigneRole pour ce projet et ce role
                        if ($this->assigneRoleRepository->findOneBy(['projet' => $projet, 'role' => $role->getRole()]) === null) {
                            $assigneRole = new AssigneRole();

                            $assigneRole->setProjet($projet);
                            $assigneRole->setRole($role->getRole());
                            $assigneRole->setNbJours($role->getNbJours());
                            $assigneRole->setNbJoursPrevi(0);
                            $projet->addAssigneRole($assigneRole);

                            $this->assigneRoleRepository->save($assigneRole);
                        }
                    }
                    $this->projetRepository->save($projet);

                } // si il existe un projet pour cette offre et cette equipe mais que l'etat de la proposition est a false
                elseif ($this->projetRepository->findOneBy(['offre' => $proposition->getOffre(), 'equipe' => $equipe]) && $proposition->isEtat() === false) {
                    $proposition->setProjet(null);
                    $this->propositionRepository->save($proposition);

                    $projet = $this->projetRepository->findOneBy(['offre' => $proposition->getOffre(), 'equipe' => $equipe]);
                    // supprimer le projet
                    $this->projetRepository->remove($projet);
                }
            }

            $projets = $this->projetRepository->findBy(['equipe' => $equipe]);

            // todo: comme pour les propositions, permettre de rester sur le même tab après une update du projet
            if ($projets !== null) {
                $projetForms = [];
                foreach ($projets as $projet) {
                    $form = $this->createForm(ProjetType::class, $projet, ['game' => $game]);
                    $projetForms[$projet->getId()] = $form->createView();
                }
            }

            $this->hub->publish(new Update(
                'game-joueur/' . $game->getId() . '/equipe/' . $equipe->getId(),
                $this->renderView('phase2a/joueur_phase2a.stream.html.twig', [
                    'game' => $game,
                    'equipe' => $equipe,
                    'projetForms' => $projetForms ?? null,
                ]),
                false
            ));
        }
    }
}