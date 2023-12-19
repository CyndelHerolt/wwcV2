<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
#[Broadcast]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $description_courte = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_longue = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $prix_min = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $prix_max = null;

    #[ORM\Column]
    private ?bool $visible = null;

    #[ORM\Column]
    private ?int $deadline = null;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    private ?Game $game = null;

    #[ORM\OneToMany(mappedBy: 'offre', targetEntity: BesoinRole::class)]
    private Collection $besoin_role;

    // src/Entity/Offre.php

    #[ORM\ManyToOne(targetEntity: TypeOffre::class, inversedBy: 'offres')]
    private ?TypeOffre $type_offre = null;

    public function getTypeOffre(): ?TypeOffre
    {
        return $this->type_offre;
    }

    public function setTypeOffre(?TypeOffre $type_offre): static
    {
        $this->type_offre = $type_offre;

        return $this;
    }

    public function __construct()
    {
        $this->besoin_role = new ArrayCollection();
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

    public function getDescriptionCourte(): ?string
    {
        return $this->description_courte;
    }

    public function setDescriptionCourte(string $description_courte): static
    {
        $this->description_courte = $description_courte;

        return $this;
    }

    public function getDescriptionLongue(): ?string
    {
        return $this->description_longue;
    }

    public function setDescriptionLongue(string $description_longue): static
    {
        $this->description_longue = $description_longue;

        return $this;
    }

    public function getPrixMin(): ?string
    {
        return $this->prix_min;
    }

    public function setPrixMin(string $prix_min): static
    {
        $this->prix_min = $prix_min;

        return $this;
    }

    public function getPrixMax(): ?string
    {
        return $this->prix_max;
    }

    public function setPrixMax(string $prix_max): static
    {
        $this->prix_max = $prix_max;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): static
    {
        $this->visible = $visible;

        return $this;
    }

    public function getDeadline(): ?int
    {
        return $this->deadline;
    }

    public function setDeadline(int $deadline): static
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return Collection<int, BesoinRole>
     */
    public function getBesoinRole(): Collection
    {
        return $this->besoin_role;
    }

    public function addBesoinRole(BesoinRole $besoinRole): static
    {
        if (!$this->besoin_role->contains($besoinRole)) {
            $this->besoin_role->add($besoinRole);
            $besoinRole->setOffre($this);
        }

        return $this;
    }

    public function removeBesoinRole(BesoinRole $besoinRole): static
    {
        if ($this->besoin_role->removeElement($besoinRole)) {
            // set the owning side to null (unless already changed)
            if ($besoinRole->getOffre() === $this) {
                $besoinRole->setOffre(null);
            }
        }

        return $this;
    }
}
