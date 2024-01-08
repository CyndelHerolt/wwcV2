<?php

namespace App\Classes;

use App\Entity\Game;
use App\Entity\Offre;
use App\Repository\GameRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DataUserSession
{
    protected ?Game $game = null;

    /**
     * DataUserSession constructor.
     *
     * @throws NonUniqueResultException
     */
    public function __construct(
        RequestStack $session,
    )
    {
        $this->requestStack = $session;
        $session = $this->requestStack->getSession();

        if ($session->has('game')) {
            $this->game = $session->get('game');
        }
        if ($session->has('offre')) {
            $this->offre = $session->get('offre');
        }
    }

    public function setGame(Game $game): void
    {
        $this->game = $game;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setOffre(Offre $offre): void
    {
        $this->offre = $offre;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }
}