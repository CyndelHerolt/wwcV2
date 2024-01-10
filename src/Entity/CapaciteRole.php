<?php

namespace App\Entity;

use App\Repository\CapaciteRoleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: CapaciteRoleRepository::class)]
#[Broadcast]
class CapaciteRole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbJours = null;

    #[ORM\ManyToOne(inversedBy: 'capaciteRoles')]
    private ?Role $role = null;

    #[ORM\ManyToOne(inversedBy: 'capaciteRoles')]
    private ?Equipe $equipe = null;

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

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): static
    {
        $this->equipe = $equipe;

        return $this;
    }
}
