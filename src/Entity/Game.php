<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: GameRepository::class)]
#[Broadcast]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $periode = 1;

    #[ORM\Column]
    private ?int $nb_equipes = 0;

    #[ORM\Column]
    private ?float $coeff_charges_patronales = 0.42;

    #[ORM\Column]
    private ?float $coeff_charges_salariales = 0.78;

    #[ORM\Column]
    private ?float $taux_decouvert = 16;

    #[ORM\Column]
    private ?float $location_materiel = 250;

    #[ORM\Column]
    private ?float $montant_impot = 500;

    #[ORM\Column]
    private ?float $taux_interet = 10;

    #[ORM\Column]
    private ?float $coeff_electricite = 25;

    #[ORM\Column]
    private ?float $coeff_telephonie = 50;

    #[ORM\Column]
    private ?float $coeff_deplacement = 200;

    #[ORM\Column]
    private ?float $coeff_autre = 50;

    #[ORM\Column]
    private ?float $penalite_machine = 500;

    #[ORM\Column]
    private ?float $penalite_surface = 500;

    #[ORM\Column]
    private ?int $nb_jours_mois = 20;

    #[ORM\Column(length: 150)]
    private ?string $nom_partie = null;

    #[ORM\Column]
    private ?bool $pause = true;

    #[ORM\Column]
    private ?bool $active = false;

    #[ORM\Column(length: 2)]
    private ?string $phase = "1a";

    #[ORM\Column(length: 20)]
    private ?string $time_next = "00:00";

    #[ORM\Column]
    private ?float $init_tresorerie_decaissement = 6000;

    #[ORM\Column]
    private ?float $init_actif_materiel = 6000;

    #[ORM\Column]
    private ?float $init_actif_dispo = 9000;

    #[ORM\Column]
    private ?int $init_materiel = 3;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: Offre::class)]
    private Collection $offres;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: TypeOffre::class)]
    private Collection $typeOffres;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'game')]
    private Collection $users;

    public function __construct()
    {
        $this->offres = new ArrayCollection();
        $this->typeOffres = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->getNomPartie();
    }

    public function getPeriode(): ?int
    {
        return $this->periode;
    }

    public function setPeriode(int $periode): static
    {
        $this->periode = $periode;

        return $this;
    }

    public function getNbEquipes(): ?int
    {
        return $this->nb_equipes;
    }

    public function setNbEquipes(int $nb_equipes): static
    {
        $this->nb_equipes = $nb_equipes;

        return $this;
    }

    public function getCoeffChargesPatronales(): ?float
    {
        return $this->coeff_charges_patronales;
    }

    public function setCoeffChargesPatronales(float $coeff_charges_patronales): static
    {
        $this->coeff_charges_patronales = $coeff_charges_patronales;

        return $this;
    }

    public function getCoeffChargesSalariales(): ?float
    {
        return $this->coeff_charges_salariales;
    }

    public function setCoeffChargesSalariales(float $coeff_charges_salariales): static
    {
        $this->coeff_charges_salariales = $coeff_charges_salariales;

        return $this;
    }

    public function getTauxDecouvert(): ?float
    {
        return $this->taux_decouvert;
    }

    public function setTauxDecouvert(float $taux_decouvert): static
    {
        $this->taux_decouvert = $taux_decouvert;

        return $this;
    }

    public function getLocationMateriel(): ?float
    {
        return $this->location_materiel;
    }

    public function setLocationMateriel(float $location_materiel): static
    {
        $this->location_materiel = $location_materiel;

        return $this;
    }

    public function getMontantImpot(): ?float
    {
        return $this->montant_impot;
    }

    public function setMontantImpot(float $montant_impot): static
    {
        $this->montant_impot = $montant_impot;

        return $this;
    }

    public function getTauxInteret(): ?float
    {
        return $this->taux_interet;
    }

    public function setTauxInteret(float $taux_interet): static
    {
        $this->taux_interet = $taux_interet;

        return $this;
    }

    public function getCoeffElectricite(): ?float
    {
        return $this->coeff_electricite;
    }

    public function setCoeffElectricite(float $coeff_electricite): static
    {
        $this->coeff_electricite = $coeff_electricite;

        return $this;
    }

    public function getCoeffTelephonie(): ?float
    {
        return $this->coeff_telephonie;
    }

    public function setCoeffTelephonie(float $coeff_telephonie): static
    {
        $this->coeff_telephonie = $coeff_telephonie;

        return $this;
    }

    public function getCoeffDeplacement(): ?float
    {
        return $this->coeff_deplacement;
    }

    public function setCoeffDeplacement(float $coeff_deplacement): static
    {
        $this->coeff_deplacement = $coeff_deplacement;

        return $this;
    }

    public function getCoeffAutre(): ?float
    {
        return $this->coeff_autre;
    }

    public function setCoeffAutre(float $coeff_autre): static
    {
        $this->coeff_autre = $coeff_autre;

        return $this;
    }

    public function getPenaliteMachine(): ?float
    {
        return $this->penalite_machine;
    }

    public function setPenaliteMachine(float $penalite_machine): static
    {
        $this->penalite_machine = $penalite_machine;

        return $this;
    }

    public function getPenaliteSurface(): ?float
    {
        return $this->penalite_surface;
    }

    public function setPenaliteSurface(float $penalite_surface): static
    {
        $this->penalite_surface = $penalite_surface;

        return $this;
    }

    public function getNbJoursMois(): ?int
    {
        return $this->nb_jours_mois;
    }

    public function setNbJoursMois(int $nb_jours_mois): static
    {
        $this->nb_jours_mois = $nb_jours_mois;

        return $this;
    }

    public function getNomPartie(): ?string
    {
        return $this->nom_partie;
    }

    public function setNomPartie(string $nom_partie): static
    {
        $this->nom_partie = $nom_partie;

        return $this;
    }

    public function isPause(): ?bool
    {
        return $this->pause;
    }

    public function setPause(bool $pause): static
    {
        $this->pause = $pause;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getPhase(): ?string
    {
        return $this->phase;
    }

    public function setPhase(string $phase): static
    {
        $this->phase = $phase;

        return $this;
    }

    public function getTimeNext(): ?string
    {
        return $this->time_next;
    }

    public function setTimeNext(string $time_next): static
    {
        $this->time_next = $time_next;

        return $this;
    }

    public function getInitTresorerieDecaissement(): ?float
    {
        return $this->init_tresorerie_decaissement;
    }

    public function setInitTresorerieDecaissement(float $init_tresorerie_decaissement): static
    {
        $this->init_tresorerie_decaissement = $init_tresorerie_decaissement;

        return $this;
    }

    public function getInitActifMateriel(): ?float
    {
        return $this->init_actif_materiel;
    }

    public function setInitActifMateriel(float $init_actif_materiel): static
    {
        $this->init_actif_materiel = $init_actif_materiel;

        return $this;
    }

    public function getInitActifDispo(): ?float
    {
        return $this->init_actif_dispo;
    }

    public function setInitActifDispo(float $init_actif_dispo): static
    {
        $this->init_actif_dispo = $init_actif_dispo;

        return $this;
    }

    public function getInitMateriel(): ?int
    {
        return $this->init_materiel;
    }

    public function setInitMateriel(int $init_materiel): static
    {
        $this->init_materiel = $init_materiel;

        return $this;
    }

    /**
     * @return Collection<int, Offre>
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): static
    {
        if (!$this->offres->contains($offre)) {
            $this->offres->add($offre);
            $offre->setGame($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): static
    {
        if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getGame() === $this) {
                $offre->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TypeOffre>
     */
    public function getTypeOffres(): Collection
    {
        return $this->typeOffres;
    }

    public function addTypeOffre(TypeOffre $typeOffre): static
    {
        if (!$this->typeOffres->contains($typeOffre)) {
            $this->typeOffres->add($typeOffre);
            $typeOffre->setGame($this);
        }

        return $this;
    }

    public function removeTypeOffre(TypeOffre $typeOffre): static
    {
        if ($this->typeOffres->removeElement($typeOffre)) {
            // set the owning side to null (unless already changed)
            if ($typeOffre->getGame() === $this) {
                $typeOffre->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addGame($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeGame($this);
        }

        return $this;
    }
}
