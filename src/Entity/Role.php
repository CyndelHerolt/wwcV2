<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\OneToMany(mappedBy: 'role', targetEntity: Profil::class)]
    private Collection $profils;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: '0')]
    private ?string $salaire_salarie = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: '0')]
    private ?string $salaireFreelance = null;

    #[ORM\Column]
    private ?int $tacheRecurrente = null;

    #[ORM\Column]
    private ?int $nbJoursTravailles = null;

    #[ORM\OneToMany(mappedBy: 'role', targetEntity: CapaciteRole::class)]
    private Collection $capaciteRoles;

    #[ORM\OneToMany(mappedBy: 'role', targetEntity: AssigneRole::class)]
    private Collection $assigneRoles;


    public function __construct()
    {
        $this->besoinRoles = new ArrayCollection();
        $this->estimationRoles = new ArrayCollection();
        $this->profils = new ArrayCollection();
        $this->capaciteRoles = new ArrayCollection();
        $this->assigneRoles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->libelle;
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

    /**
     * @return Collection<int, Profil>
     */
    public function getProfils(): Collection
    {
        return $this->profils;
    }

    public function addProfil(Profil $profil): static
    {
        if (!$this->profils->contains($profil)) {
            $this->profils->add($profil);
            $profil->setRole($this);
        }

        return $this;
    }

    public function removeProfil(Profil $profil): static
    {
        if ($this->profils->removeElement($profil)) {
            // set the owning side to null (unless already changed)
            if ($profil->getRole() === $this) {
                $profil->setRole(null);
            }
        }

        return $this;
    }

    public function getSalaireSalarie(): ?string
    {
        return $this->salaire_salarie;
    }

    public function setSalaireSalarie(string $salaireSalarie): static
    {
        $this->salaire_salarie = $salaireSalarie;

        return $this;
    }

    public function getSalaireFreelance(): ?string
    {
        return $this->salaireFreelance;
    }

    public function setSalaireFreelance(string $salaireFreelance): static
    {
        $this->salaireFreelance = $salaireFreelance;

        return $this;
    }

    public function getTacheRecurrente(): ?int
    {
        return $this->tacheRecurrente;
    }

    public function setTacheRecurrente(int $tacheRecurrente): static
    {
        $this->tacheRecurrente = $tacheRecurrente;

        return $this;
    }

    public function getNbJoursTravailles(): ?int
    {
        return $this->nbJoursTravailles;
    }

    public function setNbJoursTravailles(int $nbJoursTravailles): static
    {
        $this->nbJoursTravailles = $nbJoursTravailles;

        return $this;
    }

    /**
     * @return Collection<int, CapaciteRole>
     */
    public function getCapaciteRoles(): Collection
    {
        return $this->capaciteRoles;
    }

    public function addCapaciteRole(CapaciteRole $capaciteRole): static
    {
        if (!$this->capaciteRoles->contains($capaciteRole)) {
            $this->capaciteRoles->add($capaciteRole);
            $capaciteRole->setRole($this);
        }

        return $this;
    }

    public function removeCapaciteRole(CapaciteRole $capaciteRole): static
    {
        if ($this->capaciteRoles->removeElement($capaciteRole)) {
            // set the owning side to null (unless already changed)
            if ($capaciteRole->getRole() === $this) {
                $capaciteRole->setRole(null);
            }
        }

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
            $assigneRole->setRole($this);
        }

        return $this;
    }

    public function removeAssigneRole(AssigneRole $assigneRole): static
    {
        if ($this->assigneRoles->removeElement($assigneRole)) {
            // set the owning side to null (unless already changed)
            if ($assigneRole->getRole() === $this) {
                $assigneRole->setRole(null);
            }
        }

        return $this;
    }
}
