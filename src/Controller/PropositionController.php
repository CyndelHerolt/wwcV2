<?php

namespace App\Controller;

use App\Controller\Phase1B\JoueurPhase1BController;
use App\Entity\Proposition;
use App\Form\PropositionType;
use App\Repository\EquipeRepository;
use App\Repository\OffreRepository;
use App\Repository\PropositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Attribute\Route;

class PropositionController extends AbstractController
{

    public function __construct(
        private HubInterface          $hub,
        private PropositionRepository $propositionRepository,
        private OffreRepository       $offreRepository,
        private EquipeRepository      $equipeRepository,
        private JoueurPhase1BController $joueurPhase1BController,
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
         $form = $this->createForm(PropositionType::class);

        $this->hub->publish(new Update(
            'game-joueur/' . $equipeId . '/' . $offreId,
            $this->renderView('proposition/form.stream.html.twig', [
                'proposition' => $proposition,
                'form' => $form->createView(),
            ]),
            false
        ));

        return $this->render('proposition/form.stream.html.twig', [
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
            'proposition' => $proposition,
            'offre' => $offre,
            'equipe' => $equipe,
        ]);
    }
}