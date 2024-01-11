<?php

namespace App\Entity;

use App\Repository\AssigneRoleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: AssigneRoleRepository::class)]
#[Broadcast]
class AssigneRole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbJours = null;

    #[ORM\ManyToOne(inversedBy: 'assigneRoles')]
    private ?Role $role = null;

    #[ORM\ManyToOne(inversedBy: 'assigneRoles', cascade: ['persist', 'remove'])]
    private ?Projet $projet = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbJoursPrevi = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbJours(): ?int
    {
        return $this->nbJours;
    }

    public function setNbJours(int $nbJours): static
    {
        $this->nbJours = $nbJours;

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

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): static
    {
        $this->projet = $projet;

        return $this;
    }

    public function getNbJoursPrevi(): ?int
    {
        return $this->nbJoursPrevi;
    }

    public function setNbJoursPrevi(?int $nbJoursPrevi): static
    {
        $this->nbJoursPrevi = $nbJoursPrevi;

        return $this;
    }
}
