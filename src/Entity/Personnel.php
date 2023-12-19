<?php

namespace App\Entity;

use App\Repository\PersonnelRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: PersonnelRepository::class)]
#[Broadcast]
class Personnel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $type = null;

    #[ORM\Column]
    private ?float $salaire = null;

    #[ORM\Column]
    private ?int $duree_mission = null;

    #[ORM\Column]
    private ?bool $actif = null;

    #[ORM\ManyToOne(inversedBy: 'personnels')]
    private ?Equipe $equipe = null;

    #[ORM\ManyToOne(inversedBy: 'personnels')]
    private ?Equipe $equipe_origine = null;

    #[ORM\Column]
    private ?int $competence_niveau = null;

    #[ORM\Column]
    private ?float $penalite_paiement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getSalaire(): ?float
    {
        return $this->salaire;
    }

    public function setSalaire(float $salaire): static
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getDureeMission(): ?int
    {
        return $this->duree_mission;
    }

    public function setDureeMission(int $duree_mission): static
    {
        $this->duree_mission = $duree_mission;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): static
    {
        $this->actif = $actif;

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

    public function getEquipeOrigine(): ?Equipe
    {
        return $this->equipe_origine;
    }

    public function setEquipeOrigine(?Equipe $equipe_origine): static
    {
        $this->equipe_origine = $equipe_origine;

        return $this;
    }

    public function getCompetenceNiveau(): ?int
    {
        return $this->competence_niveau;
    }

    public function setCompetenceNiveau(int $competence_niveau): static
    {
        $this->competence_niveau = $competence_niveau;

        return $this;
    }

    public function getPenalitePaiement(): ?float
    {
        return $this->penalite_paiement;
    }

    public function setPenalitePaiement(float $penalite_paiement): static
    {
        $this->penalite_paiement = $penalite_paiement;

        return $this;
    }
}
