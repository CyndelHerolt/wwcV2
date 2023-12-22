<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
#[Broadcast]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $materiel = 3;

    #[ORM\Column]
    private ?int $materielLoue = 0;

    #[ORM\Column]
    private ?int $materielAchat = 0;

    #[ORM\Column]
    private ?float $produit_ca = 0;

    #[ORM\Column]
    private ?float $benefice = 0;

    #[ORM\Column]
    private ?float $materiel_amortir = 0;

    #[ORM\Column]
    private ?float $materiel_actif = 6000;

    #[ORM\Column]
    private ?float $actif_creance = 0;

    #[ORM\Column]
    private ?float $actif_dispo = 9000;

    #[ORM\Column]
    private ?float $actif_total = 0;

    #[ORM\Column]
    private ?float $passif_capital = 15000;

    #[ORM\Column]
    private ?float $passif_resultat = 0;

    #[ORM\Column]
    private ?float $passif_dette_financiere = 0;

    #[ORM\Column]
    private ?float $passif_dette_fournisseurs = 0;

    #[ORM\Column]
    private ?float $passif_dette_fiscales = 0;

    #[ORM\Column]
    private ?float $passif_decouvert = 0;

    #[ORM\Column]
    private ?float $passif_total = 0;

    #[ORM\Column]
    private ?float $charges_courantes = 0;

    #[ORM\Column]
    private ?float $charges_location = 0;

    #[ORM\Column]
    private ?float $charges_personnel = 0;

    #[ORM\Column]
    private ?float $charges_freelances = 0;

    #[ORM\Column]
    private ?float $charges_impot = 0;

    #[ORM\Column]
    private ?float $charges_amortissements = 0;

    #[ORM\Column]
    private ?float $charges_interet = 0;

    #[ORM\Column]
    private ?float $tresorerie_solde_initial = 0;

    #[ORM\Column]
    private ?float $tresorerie_encaissement = 6000;

    #[ORM\Column]
    private ?float $tresorerie_decaissement = 15000;

    #[ORM\Column]
    private ?float $tresorerie_solde_final = 9000;

    #[ORM\Column]
    private ?float $cumul_charge = 0;

    #[ORM\Column]
    private ?float $cumul_location = 0;

    #[ORM\Column]
    private ?float $cumul_personnel = 0;

    #[ORM\Column]
    private ?float $cumul_freelance = 0;

    #[ORM\Column]
    private ?float $cumul_interets = 0;

    #[ORM\Column]
    private ?float $cumul_impots = 0;

    #[ORM\Column]
    private ?float $cumul_amortissement = 0;

    #[ORM\Column]
    private ?float $cumul_ca = 0;

    #[ORM\Column]
    private ?float $total_charge = 0;

    #[ORM\Column]
    private ?float $total_produit = 0;

    #[ORM\OneToMany(mappedBy: 'equipe', targetEntity: Personnel::class)]
    private Collection $personnels;

    #[ORM\Column]
    private ?int $reputation = 6;

    #[ORM\Column(length: 20)]
    private string $couleur= "75,192,192";

    #[ORM\OneToMany(mappedBy: 'equipe', targetEntity: User::class)]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: Offre::class, inversedBy: 'equipes')]
    private Collection $offres;

    public function __construct()
    {
        $this->personnels = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->offres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMateriel(): ?int
    {
        return $this->materiel;
    }

    public function setMateriel(int $materiel): static
    {
        $this->materiel = $materiel;

        return $this;
    }

    public function getMaterielLoue(): ?int
    {
        return $this->materielLoue;
    }

    public function setMaterielLoue(int $materielLoue): static
    {
        $this->materielLoue = $materielLoue;

        return $this;
    }

    public function getMaterielAchat(): ?int
    {
        return $this->materielAchat;
    }

    public function setMaterielAchat(int $materielAchat): static
    {
        $this->materielAchat = $materielAchat;

        return $this;
    }

    public function getProduitCa(): ?float
    {
        return $this->produit_ca;
    }

    public function setProduitCa(float $produit_ca): static
    {
        $this->produit_ca = $produit_ca;

        return $this;
    }

    public function getBenefice(): ?float
    {
        return $this->benefice;
    }

    public function setBenefice(float $benefice): static
    {
        $this->benefice = $benefice;

        return $this;
    }

    public function getMaterielAmortir(): ?float
    {
        return $this->materiel_amortir;
    }

    public function setMaterielAmortir(float $materiel_amortir): static
    {
        $this->materiel_amortir = $materiel_amortir;

        return $this;
    }

    public function getMaterielActif(): ?float
    {
        return $this->materiel_actif;
    }

    public function setMaterielActif(float $materiel_actif): static
    {
        $this->materiel_actif = $materiel_actif;

        return $this;
    }

    public function getActifCreance(): ?float
    {
        return $this->actif_creance;
    }

    public function setActifCreance(float $actif_creance): static
    {
        $this->actif_creance = $actif_creance;

        return $this;
    }

    public function getActifDispo(): ?float
    {
        return $this->actif_dispo;
    }

    public function setActifDispo(float $actif_dispo): static
    {
        $this->actif_dispo = $actif_dispo;

        return $this;
    }

    public function getActifTotal(): ?float
    {
        return $this->actif_total;
    }

    public function setActifTotal(float $actif_total): static
    {
        $this->actif_total = $actif_total;

        return $this;
    }

    public function getPassifCapital(): ?float
    {
        return $this->passif_capital;
    }

    public function setPassifCapital(float $passif_capital): static
    {
        $this->passif_capital = $passif_capital;

        return $this;
    }

    public function getPassifResultat(): ?float
    {
        return $this->passif_resultat;
    }

    public function setPassifResultat(float $passif_resultat): static
    {
        $this->passif_resultat = $passif_resultat;

        return $this;
    }

    public function getPassifDetteFinanciere(): ?float
    {
        return $this->passif_dette_financiere;
    }

    public function setPassifDetteFinanciere(float $passif_dette_financiere): static
    {
        $this->passif_dette_financiere = $passif_dette_financiere;

        return $this;
    }

    public function getPassifDetteFournisseurs(): ?float
    {
        return $this->passif_dette_fournisseurs;
    }

    public function setPassifDetteFournisseurs(float $passif_dette_fournisseurs): static
    {
        $this->passif_dette_fournisseurs = $passif_dette_fournisseurs;

        return $this;
    }

    public function getPassifDetteFiscales(): ?float
    {
        return $this->passif_dette_fiscales;
    }

    public function setPassifDetteFiscales(float $passif_dette_fiscales): static
    {
        $this->passif_dette_fiscales = $passif_dette_fiscales;

        return $this;
    }

    public function getPassifDecouvert(): ?float
    {
        return $this->passif_decouvert;
    }

    public function setPassifDecouvert(float $passif_decouvert): static
    {
        $this->passif_decouvert = $passif_decouvert;

        return $this;
    }

    public function getPassifTotal(): ?float
    {
        return $this->passif_total;
    }

    public function setPassifTotal(float $passif_total): static
    {
        $this->passif_total = $passif_total;

        return $this;
    }

    public function getChargesCourantes(): ?float
    {
        return $this->charges_courantes;
    }

    public function setChargesCourantes(float $charges_courantes): static
    {
        $this->charges_courantes = $charges_courantes;

        return $this;
    }

    public function getChargesLocation(): ?float
    {
        return $this->charges_location;
    }

    public function setChargesLocation(float $charges_location): static
    {
        $this->charges_location = $charges_location;

        return $this;
    }

    public function getChargesPersonnel(): ?float
    {
        return $this->charges_personnel;
    }

    public function setChargesPersonnel(float $charges_personnel): static
    {
        $this->charges_personnel = $charges_personnel;

        return $this;
    }

    public function getChargesFreelances(): ?float
    {
        return $this->charges_freelances;
    }

    public function setChargesFreelances(float $charges_freelances): static
    {
        $this->charges_freelances = $charges_freelances;

        return $this;
    }

    public function getChargesImpot(): ?float
    {
        return $this->charges_impot;
    }

    public function setChargesImpot(float $charges_impot): static
    {
        $this->charges_impot = $charges_impot;

        return $this;
    }

    public function getChargesAmortissements(): ?float
    {
        return $this->charges_amortissements;
    }

    public function setChargesAmortissements(float $charges_amortissements): static
    {
        $this->charges_amortissements = $charges_amortissements;

        return $this;
    }

    public function getChargesInteret(): ?float
    {
        return $this->charges_interet;
    }

    public function setChargesInteret(float $charges_interet): static
    {
        $this->charges_interet = $charges_interet;

        return $this;
    }

    public function getTresorerieSoldeInitial(): ?float
    {
        return $this->tresorerie_solde_initial;
    }

    public function setTresorerieSoldeInitial(float $tresorerie_solde_initial): static
    {
        $this->tresorerie_solde_initial = $tresorerie_solde_initial;

        return $this;
    }

    public function getTresorerieEncaissement(): ?float
    {
        return $this->tresorerie_encaissement;
    }

    public function setTresorerieEncaissement(float $tresorerie_encaissement): static
    {
        $this->tresorerie_encaissement = $tresorerie_encaissement;

        return $this;
    }

    public function getTresorerieDecaissement(): ?float
    {
        return $this->tresorerie_decaissement;
    }

    public function setTresorerieDecaissement(float $tresorerie_decaissement): static
    {
        $this->tresorerie_decaissement = $tresorerie_decaissement;

        return $this;
    }

    public function getTresorerieSoldeFinal(): ?float
    {
        return $this->tresorerie_solde_final;
    }

    public function setTresorerieSoldeFinal(float $tresorerie_solde_final): static
    {
        $this->tresorerie_solde_final = $tresorerie_solde_final;

        return $this;
    }

    public function getCumulCharge(): ?float
    {
        return $this->cumul_charge;
    }

    public function setCumulCharge(float $cumul_charge): static
    {
        $this->cumul_charge = $cumul_charge;

        return $this;
    }

    public function getCumulLocation(): ?float
    {
        return $this->cumul_location;
    }

    public function setCumulLocation(float $cumul_location): static
    {
        $this->cumul_location = $cumul_location;

        return $this;
    }

    public function getCumulPersonnel(): ?float
    {
        return $this->cumul_personnel;
    }

    public function setCumulPersonnel(float $cumul_personnel): static
    {
        $this->cumul_personnel = $cumul_personnel;

        return $this;
    }

    public function getCumulFreelance(): ?float
    {
        return $this->cumul_freelance;
    }

    public function setCumulFreelance(float $cumul_freelance): static
    {
        $this->cumul_freelance = $cumul_freelance;

        return $this;
    }

    public function getCumulInterets(): ?float
    {
        return $this->cumul_interets;
    }

    public function setCumulInterets(float $cumul_interets): static
    {
        $this->cumul_interets = $cumul_interets;

        return $this;
    }

    public function getCumulImpots(): ?float
    {
        return $this->cumul_impots;
    }

    public function setCumulImpots(float $cumul_impots): static
    {
        $this->cumul_impots = $cumul_impots;

        return $this;
    }

    public function getCumulAmortissement(): ?float
    {
        return $this->cumul_amortissement;
    }

    public function setCumulAmortissement(float $cumul_amortissement): static
    {
        $this->cumul_amortissement = $cumul_amortissement;

        return $this;
    }

    public function getCumulCa(): ?float
    {
        return $this->cumul_ca;
    }

    public function setCumulCa(float $cumul_ca): static
    {
        $this->cumul_ca = $cumul_ca;

        return $this;
    }

    public function getTotalCharge(): ?float
    {
        return $this->total_charge;
    }

    public function setTotalCharge(float $total_charge): static
    {
        $this->total_charge = $total_charge;

        return $this;
    }

    public function getTotalProduit(): ?float
    {
        return $this->total_produit;
    }

    public function setTotalProduit(float $total_produit): static
    {
        $this->total_produit = $total_produit;

        return $this;
    }

    /**
     * @return Collection<int, Personnel>
     */
    public function getPersonnels(): Collection
    {
        return $this->personnels;
    }

    public function addPersonnel(Personnel $personnel): static
    {
        if (!$this->personnels->contains($personnel)) {
            $this->personnels->add($personnel);
            $personnel->setEquipe($this);
        }

        return $this;
    }

    public function removePersonnel(Personnel $personnel): static
    {
        if ($this->personnels->removeElement($personnel)) {
            // set the owning side to null (unless already changed)
            if ($personnel->getEquipe() === $this) {
                $personnel->setEquipe(null);
            }
        }

        return $this;
    }

    public function getReputation(): ?int
    {
        return $this->reputation;
    }

    public function setReputation(int $reputation): static
    {
        $this->reputation = $reputation;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): static
    {
        $this->couleur = $couleur;

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
            $user->setEquipe($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getEquipe() === $this) {
                $user->setEquipe(null);
            }
        }

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
        }

        return $this;
    }

    public function removeOffre(Offre $offre): static
    {
        $this->offres->removeElement($offre);

        return $this;
    }
}
