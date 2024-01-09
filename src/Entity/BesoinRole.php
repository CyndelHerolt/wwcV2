<?php

namespace App\Entity;

use App\Repository\BesoinRoleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: BesoinRoleRepository::class)]
#[Broadcast]
class BesoinRole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nb_jours = null;

    #[ORM\ManyToOne(inversedBy: 'besoinRoles')]
    private ?Role $role = null;

    #[ORM\ManyToOne(inversedBy: 'besoin_role')]
    private ?Offre $offre = null;

    #[ORM\Column]
    private ?int $nb_jours_estime_min = null;

    #[ORM\Column]
    private ?int $nb_jours_estime_max = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbJours(): ?int
    {
        return $this->nb_jours;
    }

    public function setNbJours(int $nb_jours): static
    {
        $this->nb_jours = $nb_jours;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): static
    {
        $this->offre = $offre;

        return $this;
    }

    public function getNbJoursEstimeMin(): ?int
    {
        return $this->nb_jours_estime_min;
    }

    public function setNbJoursEstimeMin(int $nb_jours_estime_min): static
    {
        $this->nb_jours_estime_min = $nb_jours_estime_min;

        return $this;
    }

    public function getNbJoursEstimeMax(): ?int
    {
        return $this->nb_jours_estime_max;
    }

    public function setNbJoursEstimeMax(int $nb_jours_estime_max): static
    {
        $this->nb_jours_estime_max = $nb_jours_estime_max;

        return $this;
    }
}
