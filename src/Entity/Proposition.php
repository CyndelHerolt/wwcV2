<?php

namespace App\Entity;

use App\Repository\PropositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: PropositionRepository::class)]
#[Broadcast]
class Proposition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix = null;

    #[ORM\Column]
    private ?bool $etat = false;

    #[ORM\ManyToOne(inversedBy: 'propositions')]
    private ?TypeOffre $type = null;

    #[ORM\ManyToOne(inversedBy: 'propositions')]
    private ?Offre $offre = null;

    #[ORM\ManyToOne(inversedBy: 'propositions')]
    private ?Equipe $equipe = null;

    #[ORM\OneToMany(mappedBy: 'proposition', targetEntity: EstimationRole::class, cascade: ['persist', 'remove'])]
    private Collection $estimationRoles;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Projet $projet = null;

    public function __construct()
    {
        $this->estimationRoles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getType(): ?TypeOffre
    {
        return $this->type;
    }

    public function setType(?TypeOffre $type): static
    {
        $this->type = $type;

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
     * @return Collection<int, EstimationRole>
     */
    public function getEstimationRoles(): Collection
    {
        return $this->estimationRoles;
    }

    public function addEstimationRole(EstimationRole $estimationRole): static
    {
        if (!$this->estimationRoles->contains($estimationRole)) {
            $this->estimationRoles->add($estimationRole);
            $estimationRole->setProposition($this);
        }

        return $this;
    }

    public function removeEstimationRole(EstimationRole $estimationRole): static
    {
        if ($this->estimationRoles->removeElement($estimationRole)) {
            // set the owning side to null (unless already changed)
            if ($estimationRole->getProposition() === $this) {
                $estimationRole->setProposition(null);
            }
        }

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
}
