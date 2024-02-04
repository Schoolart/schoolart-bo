<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ParametrageFraisScolariteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ParametrageFraisScolariteRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(["scolarite" => "ParametrageFraisScolarite", "institut" => "ParametrageFraisScolariteEtab", "niveau" => "ParametrageFraisScolariteNiv","etudiant" => "ParametrageFraisScolariteEtud"])]
#[ApiResource(
    normalizationContext: ['groups'=>['read:parametrageScolarite','read:parametrageScolarite:Categorie']],
    //denormalizationContext: ['groups'=>['write:bibliotheque']],
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'institut'=>'exact',
        'anneeAcademic'=>'exact'
    ]
)]
class ParametrageFraisScolarite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:parametrageScolarite','write:parametrageScolarite'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:parametrageScolarite','write:parametrageScolarite'])]
    private ?string $libelle = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:parametrageScolarite'])]
    private ?int $montant = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['read:parametrageScolarite','write:parametrageScolarite'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'parametrages')]
    #[Groups(['read:parametrageScolarite','write:parametrageScolarite'])]
    private ?CategorieFraisScolarite $categorieFraisScolarite = null;

    #[ORM\ManyToOne(inversedBy: 'parametrageFraisScolarites')]
    #[Groups(['write:parametrageScolarite'])]
    private ?Institut $institut = null;

    #[ORM\ManyToOne(inversedBy: 'parametrageFraisScolarites')]
    #[Groups(['write:parametrageScolarite'])]
    private ?AnneeAcademic $anneeAcademic = null;

    #[Groups(['write:parametrageScolarite'])]
    private ?int $montantTemp = null;

    #[ORM\OneToMany(mappedBy: 'parametrageFraisScolarite', targetEntity: Facture::class)]
    private Collection $factures;

    #[ORM\OneToMany(mappedBy: 'parametrageFraisScolarite', targetEntity: Paiement::class)]
    private Collection $paiements;

    #[ORM\OneToMany(mappedBy: 'parametrageFraisScolarite', targetEntity: FactureEtudiant::class, cascade: ["persist",'remove'])]
    private Collection $factureEtudiants;


    public function __construct()
    {
        $this->factures = new ArrayCollection();
        $this->paiements = new ArrayCollection();
        $this->factureEtudiants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(?int $montant): self
    {
        $this->montant = $montant;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCategorieFraisScolarite(): ?CategorieFraisScolarite
    {
        return $this->categorieFraisScolarite;
    }

    public function setCategorieFraisScolarite(?CategorieFraisScolarite $categorieFraisScolarite): self
    {
        $this->categorieFraisScolarite = $categorieFraisScolarite;

        return $this;
    }

    public function getInstitut(): ?Institut
    {
        return $this->institut;
    }

    public function setInstitut(?Institut $institut): self
    {
        $this->institut = $institut;

        return $this;
    }

    public function getAnneeAcademic(): ?AnneeAcademic
    {
        return $this->anneeAcademic;
    }

    public function setAnneeAcademic(?AnneeAcademic $anneeAcademic): self
    {
        $this->anneeAcademic = $anneeAcademic;

        return $this;
    }

    public function getMontantTemp(): ?int
    {
        return $this->montantTemp;
    }

    public function setMontantTemp(?int $montantTemp): self
    {
        $this->montantTemp = $montantTemp;

        return $this;
    }

    /**
     * @return Collection<int, Facture>
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures->add($facture);
            $facture->setParametrageFraisScolarite($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getParametrageFraisScolarite() === $this) {
                $facture->setParametrageFraisScolarite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Paiement>
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): self
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements->add($paiement);
            $paiement->setParametrageFraisScolarite($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): self
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getParametrageFraisScolarite() === $this) {
                $paiement->setParametrageFraisScolarite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FactureEtudiant>
     */
    public function getFactureEtudiants(): Collection
    {
        return $this->factureEtudiants;
    }

    public function addFactureEtudiant(FactureEtudiant $factureEtudiant): self
    {
        if (!$this->factureEtudiants->contains($factureEtudiant)) {
            $this->factureEtudiants->add($factureEtudiant);
            $factureEtudiant->setParametrageFraisScolarite($this);
        }

        return $this;
    }

    public function removeFactureEtudiant(FactureEtudiant $factureEtudiant): self
    {
        if ($this->factureEtudiants->removeElement($factureEtudiant)) {
            // set the owning side to null (unless already changed)
            if ($factureEtudiant->getParametrageFraisScolarite() === $this) {
                $factureEtudiant->setParametrageFraisScolarite(null);
            }
        }

        return $this;
    }

}
