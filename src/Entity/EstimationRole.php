<?php

namespace App\Entity;

use App\Repository\EstimationRoleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: EstimationRoleRepository::class)]
#[Broadcast]
class EstimationRole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nb_jours = null;

    #[ORM\ManyToOne(inversedBy: 'estimationRoles', cascade: ['persist'])]
    private ?Proposition $proposition = null;

    #[ORM\ManyToOne(inversedBy: 'estimationRoles')]
    private ?Role $role = null;

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

    public function getProposition(): ?Proposition
    {
        return $this->proposition;
    }

    public function setProposition(?Proposition $proposition): static
    {
        $this->proposition = $proposition;

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
}
