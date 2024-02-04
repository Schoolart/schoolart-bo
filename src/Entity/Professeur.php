<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ProfesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProfesseurRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:user','read:professeur','read:professeur:matiere','read:professeur:matiere:matiereSup','read:professeur:classe:niveau',
        'read:professeur:matiere:classe','read:professeur:institut','read:professeur:classe','read:professeur:classe:niveau:anneeAcademic',
        'read:professeur:institut:anneeAcademic','read:professeur:classe:niveau:periode']],
    denormalizationContext: ['groups'=>['read:professeur','write:user']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'classes'=>'exact',
        'etablissement'=>"exact",
        'instituts'=>"exact",
        "statut"=>"exact"
    ]
)]
class Professeur extends User
{

    #[ORM\ManyToMany(targetEntity: Classe::class, mappedBy: 'professeurs')]
    #[Groups(['read:professeur'])]
    private Collection $classes;

    #[ORM\OneToMany(mappedBy: 'professeur', targetEntity: Matiere::class)]
    #[Groups(['read:professeur'])]
    private Collection $matieres;

    #[ORM\ManyToMany(targetEntity: Jury::class, mappedBy: 'professeurs')]
    private Collection $juries;

    #[ORM\OneToMany(mappedBy: 'professeur', targetEntity: Groupe::class)]
    private Collection $groupes;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:professeur'])]
    private ?string $piece = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:professeur'])]
    private ?string $numeroPiece = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:professeur'])]
    private ?string $numeroCompletCompteBancaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:professeur'])]
    private ?string $nomBanque = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:professeur'])]
    private ?string $codeBanque = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:professeur'])]
    private ?string $CodeGuichet = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:professeur'])]
    private ?string $numeroCompte = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:professeur'])]
    private ?string $rib = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('read:professeur','read:matiere:professeur')]
    private ?string $statut = null;

    #[ORM\OneToMany(mappedBy: 'professeur', targetEntity: FicheIdentification::class)]
    private Collection $ficheIdentifications;

    #[ORM\OneToMany(mappedBy: 'professeur', targetEntity: Honoraire::class)]
    private Collection $honoraires;

    #[ORM\OneToMany(mappedBy: 'professeur', targetEntity: Contrat::class)]
    private Collection $contrats;

    #[ORM\OneToMany(mappedBy: 'professeur', targetEntity: HonoraireRecap::class)]
    private Collection $honoraireRecaps;

    public function __construct()
    {
        parent::__construct();
        $this->classes = new ArrayCollection();
        $this->matieres = new ArrayCollection();
        $this->juries = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->ficheIdentifications = new ArrayCollection();
        $this->honoraires = new ArrayCollection();
        $this->contrats = new ArrayCollection();
        $this->honoraireRecaps = new ArrayCollection();

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
            $class->addProfesseur($this);
        }

        return $this;
    }

    public function removeClass(Classe $class): self
    {
        if ($this->classes->removeElement($class)) {
            $class->removeProfesseur($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Matiere>
     */
    public function getMatieres(): Collection
    {
        return $this->matieres;
    }

    public function addMatiere(Matiere $matiere): self
    {
        if (!$this->matieres->contains($matiere)) {
            $this->matieres->add($matiere);
            $matiere->setProfesseur($this);
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): self
    {
        if ($this->matieres->removeElement($matiere)) {
            // set the owning side to null (unless already changed)
            if ($matiere->getProfesseur() === $this) {
                $matiere->setProfesseur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Jury>
     */
    public function getJuries(): Collection
    {
        return $this->juries;
    }

    public function addJury(Jury $jury): self
    {
        if (!$this->juries->contains($jury)) {
            $this->juries->add($jury);
            $jury->addProfesseur($this);
        }

        return $this;
    }

    public function removeJury(Jury $jury): self
    {
        if ($this->juries->removeElement($jury)) {
            $jury->removeProfesseur($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Groupe>
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes->add($groupe);
            $groupe->setProfesseur($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getProfesseur() === $this) {
                $groupe->setProfesseur(null);
            }
        }

        return $this;
    }

    public function getPiece(): ?string
    {
        return $this->piece;
    }

    public function setPiece(?string $piece): self
    {
        $this->piece = $piece;

        return $this;
    }

    public function getNumeroPiece(): ?string
    {
        return $this->numeroPiece;
    }

    public function setNumeroPiece(?string $numeroPiece): self
    {
        $this->numeroPiece = $numeroPiece;

        return $this;
    }

    public function getNumeroCompletCompteBancaire(): ?string
    {
        return $this->numeroCompletCompteBancaire;
    }

    public function setNumeroCompletCompteBancaire(?string $numeroCompletCompteBancaire): self
    {
        $this->numeroCompletCompteBancaire = $numeroCompletCompteBancaire;

        return $this;
    }

    public function getNomBanque(): ?string
    {
        return $this->nomBanque;
    }

    public function setNomBanque(?string $nomBanque): self
    {
        $this->nomBanque = $nomBanque;

        return $this;
    }

    public function getCodeBanque(): ?string
    {
        return $this->codeBanque;
    }

    public function setCodeBanque(?string $codeBanque): self
    {
        $this->codeBanque = $codeBanque;

        return $this;
    }

    public function getCodeGuichet(): ?string
    {
        return $this->CodeGuichet;
    }

    public function setCodeGuichet(?string $CodeGuichet): self
    {
        $this->CodeGuichet = $CodeGuichet;

        return $this;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(?string $numeroCompte): self
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getRib(): ?string
    {
        return $this->rib;
    }

    public function setRib(?string $rib): self
    {
        $this->rib = $rib;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, FicheIdentification>
     */
    public function getFicheIdentifications(): Collection
    {
        return $this->ficheIdentifications;
    }

    public function addFicheIdentification(FicheIdentification $ficheIdentification): self
    {
        if (!$this->ficheIdentifications->contains($ficheIdentification)) {
            $this->ficheIdentifications->add($ficheIdentification);
            $ficheIdentification->setProfesseur($this);
        }

        return $this;
    }

    public function removeFicheIdentification(FicheIdentification $ficheIdentification): self
    {
        if ($this->ficheIdentifications->removeElement($ficheIdentification)) {
            // set the owning side to null (unless already changed)
            if ($ficheIdentification->getProfesseur() === $this) {
                $ficheIdentification->setProfesseur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Honoraire>
     */
    public function getHonoraires(): Collection
    {
        return $this->honoraires;
    }

    public function addHonoraire(Honoraire $honoraire): self
    {
        if (!$this->honoraires->contains($honoraire)) {
            $this->honoraires->add($honoraire);
            $honoraire->setProfesseur($this);
        }

        return $this;
    }

    public function removeHonoraire(Honoraire $honoraire): self
    {
        if ($this->honoraires->removeElement($honoraire)) {
            // set the owning side to null (unless already changed)
            if ($honoraire->getProfesseur() === $this) {
                $honoraire->setProfesseur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contrat>
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }

    public function addContrat(Contrat $contrat): self
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats->add($contrat);
            $contrat->setProfesseur($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): self
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getProfesseur() === $this) {
                $contrat->setProfesseur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HonoraireRecap>
     */
    public function getHonoraireRecaps(): Collection
    {
        return $this->honoraireRecaps;
    }

    public function addHonoraireRecap(HonoraireRecap $honoraireRecap): self
    {
        if (!$this->honoraireRecaps->contains($honoraireRecap)) {
            $this->honoraireRecaps->add($honoraireRecap);
            $honoraireRecap->setProfesseur($this);
        }

        return $this;
    }

    public function removeHonoraireRecap(HonoraireRecap $honoraireRecap): self
    {
        if ($this->honoraireRecaps->removeElement($honoraireRecap)) {
            // set the owning side to null (unless already changed)
            if ($honoraireRecap->getProfesseur() === $this) {
                $honoraireRecap->setProfesseur(null);
            }
        }

        return $this;
    }



}