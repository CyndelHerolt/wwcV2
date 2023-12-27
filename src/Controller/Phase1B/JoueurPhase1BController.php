<?php

namespace App\Controller\Phase1B;

use App\Entity\Equipe;
use App\Entity\Offre;
use App\Entity\Proposition;
use App\Form\PropositionType;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class JoueurPhase1BController extends AbstractController
{
    public function __construct(
    )
    {
    }
}