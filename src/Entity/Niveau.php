<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NiveauRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:niveau','read:niveau:periode']],
    denormalizationContext: ['groups'=>['write:niveau']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'anneeAcademic'=>'exact'
    ]
)]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:niveau','read:classe:niveau','read:professeur:classe:niveau','read:etudiant:classe:niveau',
        'read:user:institut:anneeAcademic:niveau','read:parametrageScolarite:niv','read:parametrageScolarite:classe','read:parcours:niv'])]

    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:niveau','write:niveau','read:classe:niveau','read:professeur:classe:niveau','read:parcours:niv',
        'read:etudiant:classe:niveau','read:user:institut:anneeAcademic:niveau','read:parametrageScolarite:classe','read:parametrageScolarite:niv'])]
    private ?string $intitule = null;

    #[ORM\OneToMany(mappedBy: 'niveau', targetEntity: Classe::class,cascade: ['persist', 'remove'])]
    #[Groups(['read:niveau'])]
    private Collection $classes;

    #[ORM\ManyToOne(inversedBy: 'niveaux')]
    #[Groups(['read:niveau','write:niveau','read:etudiant:classe:niveau','read:professeur:classe:niveau'])]
    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\OneToMany(mappedBy: 'niveau', targetEntity: UeSup::class,cascade: ['persist', 'remove'])]
    #[Groups(['read:niveau'])]
    private Collection $ueSups;

    #[ORM\OneToMany(mappedBy: 'niveau', targetEntity: MatiereSup::class,cascade: ['persist', 'remove'])]
    #[Groups(['read:niveau'])]
    private Collection $matiereSups;

    #[ORM\OneToMany(mappedBy: 'niveau', targetEntity: Periode::class,cascade: ['persist', 'remove'])]
    #[Groups(['read:niveau','write:niveau','read:classe:niveau','read:professeur:classe:niveau'])]
    private Collection $periodes;

    #[ORM\OneToMany(mappedBy: 'niveau', targetEntity: Attestation::class,cascade: ['persist', 'remove'])]
    private Collection $attestations;

    #[ORM\OneToMany(mappedBy: 'niveau', targetEntity: Parcours::class,cascade: ['persist', 'remove'])]
    private Collection $parcours;

    #[ORM\Column(nullable: true)]
    private ?int $suivant = null;

    #[ORM\OneToMany(mappedBy: 'niveau', targetEntity: ParametrageFraisScolariteNiv::class)]
    private Collection $parametrageFraisScolariteNivs;




    public function __construct()
    {
        $this->classes = new ArrayCollection();
        $this->ueSups = new ArrayCollection();
        $this->matiereSups = new ArrayCollection();
        $this->periodes = new ArrayCollection();
        $this->attestations = new ArrayCollection();
        $this->parcours = new ArrayCollection();
        $this->parametrageFraisScolariteNivs = new ArrayCollection();

    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classe $class): self
    {
        if (!$this->classes->contains($class)) {
            $this->classes->add($class);
            $class->setNiveau($this);
        }

        return $this;
    }

    public function removeClass(Classe $class): self
    {
        if ($this->classes->removeElement($class)) {
            // set the owning side to null (unless already changed)
            if ($class->getNiveau() === $this) {
                $class->setNiveau(null);
            }
        }

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

    /**
     * @return Collection<int, UeSup>
     */
    public function getUeSups(): Collection
    {
        return $this->ueSups;
    }

    public function addUeSup(UeSup $ueSup): self
    {
        if (!$this->ueSups->contains($ueSup)) {
            $this->ueSups->add($ueSup);
            $ueSup->setNiveau($this);
        }

        return $this;
    }

    public function removeUeSup(UeSup $ueSup): self
    {
        if ($this->ueSups->removeElement($ueSup)) {
            // set the owning side to null (unless already changed)
            if ($ueSup->getNiveau() === $this) {
                $ueSup->setNiveau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MatiereSup>
     */
    public function getMatiereSups(): Collection
    {
        return $this->matiereSups;
    }

    public function addMatiereSup(MatiereSup $matiereSup): self
    {
        if (!$this->matiereSups->contains($matiereSup)) {
            $this->matiereSups->add($matiereSup);
            $matiereSup->setNiveau($this);
        }

        return $this;
    }

    public function removeMatiereSup(MatiereSup $matiereSup): self
    {
        if ($this->matiereSups->removeElement($matiereSup)) {
            // set the owning side to null (unless already changed)
            if ($matiereSup->getNiveau() === $this) {
                $matiereSup->setNiveau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Periode>
     */
    public function getPeriodes(): Collection
    {
        return $this->periodes;
    }

    public function addPeriode(Periode $periode): self
    {
        if (!$this->periodes->contains($periode)) {
            $this->periodes->add($periode);
            $periode->setNiveau($this);
        }

        return $this;
    }

    public function removePeriode(Periode $periode): self
    {
        if ($this->periodes->removeElement($periode)) {
            // set the owning side to null (unless already changed)
            if ($periode->getNiveau() === $this) {
                $periode->setNiveau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Attestation>
     */
    public function getAttestations(): Collection
    {
        return $this->attestations;
    }

    public function addAttestation(Attestation $attestation): self
    {
        if (!$this->attestations->contains($attestation)) {
            $this->attestations->add($attestation);
            $attestation->setNiveau($this);
        }

        return $this;
    }

    public function removeAttestation(Attestation $attestation): self
    {
        if ($this->attestations->removeElement($attestation)) {
            // set the owning side to null (unless already changed)
            if ($attestation->getNiveau() === $this) {
                $attestation->setNiveau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Parcours>
     */
    public function getParcours(): Collection
    {
        return $this->parcours;
    }

    public function addParcour(Parcours $parcour): self
    {
        if (!$this->parcours->contains($parcour)) {
            $this->parcours->add($parcour);
            $parcour->setNiveau($this);
        }

        return $this;
    }

    public function removeParcour(Parcours $parcour): self
    {
        if ($this->parcours->removeElement($parcour)) {
            // set the owning side to null (unless already changed)
            if ($parcour->getNiveau() === $this) {
                $parcour->setNiveau(null);
            }
        }

        return $this;
    }
    public function clearId()
    {
        $niv  = new Niveau();
        $niv->setIntitule($this->getIntitule());
        return $niv;
    }

    public function getSuivant(): ?int
    {
        return $this->suivant;
    }

    public function setSuivant(?int $suivant): self
    {
        $this->suivant = $suivant;

        return $this;
    }

    /**
     * @return Collection<int, ParametrageFraisScolariteNiv>
     */
    public function getParametrageFraisScolariteNivs(): Collection
    {
        return $this->parametrageFraisScolariteNivs;
    }

    public function addParametrageFraisScolariteNiv(ParametrageFraisScolariteNiv $parametrageFraisScolariteNiv): self
    {
        if (!$this->parametrageFraisScolariteNivs->contains($parametrageFraisScolariteNiv)) {
            $this->parametrageFraisScolariteNivs->add($parametrageFraisScolariteNiv);
            $parametrageFraisScolariteNiv->setNiveau($this);
        }

        return $this;
    }

    public function removeParametrageFraisScolariteNiv(ParametrageFraisScolariteNiv $parametrageFraisScolariteNiv): self
    {
        if ($this->parametrageFraisScolariteNivs->removeElement($parametrageFraisScolariteNiv)) {
            // set the owning side to null (unless already changed)
            if ($parametrageFraisScolariteNiv->getNiveau() === $this) {
                $parametrageFraisScolariteNiv->setNiveau(null);
            }
        }

        return $this;
    }



}
