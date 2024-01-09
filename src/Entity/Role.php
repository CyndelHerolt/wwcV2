<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[Broadcast]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'role', targetEntity: BesoinRole::class)]
    private Collection $besoinRoles;

    #[ORM\OneToMany(mappedBy: 'role', targetEntity: EstimationRole::class)]
    private Collection $estimationRoles;

    public function __construct()
    {
        $this->besoinRoles = new ArrayCollection();
        $this->estimationRoles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, BesoinRole>
     */
    public function getBesoinRoles(): Collection
    {
        return $this->besoinRoles;
    }

    public function addBesoinRole(BesoinRole $besoinRole): static
    {
        if (!$this->besoinRoles->contains($besoinRole)) {
            $this->besoinRoles->add($besoinRole);
            $besoinRole->setRole($this);
        }

        return $this;
    }

    public function removeBesoinRole(BesoinRole $besoinRole): static
    {
        if ($this->besoinRoles->removeElement($besoinRole)) {
            // set the owning side to null (unless already changed)
            if ($besoinRole->getRole() === $this) {
                $besoinRole->setRole(null);
            }
        }

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
            $estimationRole->setRole($this);
        }

        return $this;
    }

    public function removeEstimationRole(EstimationRole $estimationRole): static
    {
        if ($this->estimationRoles->removeElement($estimationRole)) {
            // set the owning side to null (unless already changed)
            if ($estimationRole->getRole() === $this) {
                $estimationRole->setRole(null);
            }
        }

        return $this;
    }
}
