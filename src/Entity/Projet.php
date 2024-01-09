<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
#[Broadcast]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $debut = null;

    #[ORM\Column]
    private ?int $fin = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: '0')]
    private ?string $prix = null;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    private ?Offre $offre = null;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    private ?Equipe $equipe = null;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: AssigneRole::class)]
    private Collection $assigneRoles;

    public function __construct()
    {
        $this->assigneRoles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebut(): ?int
    {
        return $this->debut;
    }

    public function setDebut(int $debut): static
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?int
    {
        return $this->fin;
    }

    public function setFin(int $fin): static
    {
        $this->fin = $fin;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

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

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): static
    {
        $this->equipe = $equipe;

        return $this;
    }

    /**
     * @return Collection<int, AssigneRole>
     */
    public function getAssigneRoles(): Collection
    {
        return $this->assigneRoles;
    }

    public function addAssigneRole(AssigneRole $assigneRole): static
    {
        if (!$this->assigneRoles->contains($assigneRole)) {
            $this->assigneRoles->add($assigneRole);
            $assigneRole->setProjet($this);
        }

        return $this;
    }

    public function removeAssigneRole(AssigneRole $assigneRole): static
    {
        if ($this->assigneRoles->removeElement($assigneRole)) {
            // set the owning side to null (unless already changed)
            if ($assigneRole->getProjet() === $this) {
                $assigneRole->setProjet(null);
            }
        }

        return $this;
    }
}
