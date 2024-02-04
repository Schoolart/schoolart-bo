<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MatiereRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:matiere','read:matiere:ue','read:matiere:ue:ueSup','read:matiere:classe','read:matiere:ue:periode','read:matiere:professeur','read:matiere:matiereSup']],
    denormalizationContext: ['groups'=>['read:matiere']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'classe'=>'exact',
        'ue'=>'exact',
        'anneeAcademic'=>'exact',
        'ficheIdentifications'=>"exact",
        "professeur"=>"exact",
        "cycle"=>"exact"
    ]
)]
#[ApiFilter(
    BooleanFilter::class,
    properties: [
        'ferme'
    ]
)]
class Matiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:matiere','read:professeur:matiere','read:honoraire:matiere','read:classe:matiere',
        'read:ue:matieres','read:note:matiere',"read:passage:matiere",'read:fiche:matiere'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:matiere','read:note:matiere','read:ue:matieres',"read:passage:matiere"])]
    private ?int $credits = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:matiere','read:note:matiere','read:ue:matieres',"read:passage:matiere"])]
    private ?int $coefficients = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:matiere'])]
    private ?int $bareme = null;

    #[ORM\ManyToOne(inversedBy: 'matieres')]
    #[Groups(['read:matiere','read:note:matiere'])]
    private ?Ue $ue = null;

    #[ORM\ManyToOne(inversedBy: 'matieres')]
    #[Groups(['read:matiere','read:professeur:matiere'])]
    private ?Classe $classe = null;

    #[ORM\ManyToOne(inversedBy: 'matieres')]
    #[Groups(['read:matiere'])]
    private ?Professeur $professeur = null;
    
    #[ORM\ManyToOne(inversedBy: 'matieres')]
    #[Groups(['read:matiere','read:ue:matieres','read:honoraire:matiere','read:fiche:matiere','read:professeur:matiere','read:classe:matiere','read:note:matiere',"read:passage:matiere"])]
    private ?MatiereSup $matiereSup = null;

    #[ORM\OneToMany(mappedBy: 'matiere', targetEntity: Note::class)]
    #[Groups(['read:matiere'])]
    private Collection $notes;

    #[ORM\OneToMany(mappedBy: 'matiere', targetEntity: Passage::class)]
    private Collection $passages;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:matiere'])]
    private ?int $vhe = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:matiere'])]
    private ?int $tpe = null;

    #[ORM\ManyToMany(targetEntity: FicheIdentification::class, mappedBy: 'matieres')]
    private Collection $ficheIdentifications;

    #[ORM\ManyToOne(inversedBy: 'matieres')]
    
    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:matiere','read:honoraire:matiere'])]
    private ?bool $ferme = false;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:matiere','read:honoraire:matiere'])]
    private ?float $vhr = null;

    #[ORM\OneToMany(mappedBy: 'matiere', targetEntity: Honoraire::class)]
    private Collection $honoraires;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:matiere','read:honoraire:matiere'])]
    private ?float $tauxHoraireBrut = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:matiere','read:honoraire:matiere'])]
    private ?string $cycle = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:matiere','read:honoraire:matiere'])]
    private ?float $surplus = null;

    #[ORM\OneToOne(mappedBy: 'matiere', cascade: ['persist', 'remove'])]
    private ?HonoraireRecap $honoraireRecap = null;



    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->passages = new ArrayCollection();
        $this->ficheIdentifications = new ArrayCollection();
        $this->honoraires = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getCredits(): ?int
    {
        return $this->credits;
    }

    public function setCredits(int $credits): self
    {
        $this->credits = $credits;

        return $this;
    }

    public function getCoefficients(): ?int
    {
        return $this->coefficients;
    }

    public function setCoefficients(?int $coefficients): self
    {
        $this->coefficients = $coefficients;

        return $this;
    }

    public function getBareme(): ?int
    {
        return $this->bareme;
    }

    public function setBareme(?int $bareme): self
    {
        $this->bareme = $bareme;

        return $this;
    }

    public function getUe(): ?Ue
    {
        return $this->ue;
    }

    public function setUe(?Ue $ue): self
    {
        $this->ue = $ue;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }


    public function getProfesseur(): ?Professeur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeur $professeur): self
    {
        $this->professeur = $professeur;

        return $this;
    }

    public function getMatiereSup(): ?MatiereSup
    {
        return $this->matiereSup;
    }

    public function setMatiereSup(?MatiereSup $matiereSup): self
    {
        $this->matiereSup = $matiereSup;

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }
    public function ereaseNote(): Collection
    {
        return $this->notes = new ArrayCollection();
    }
    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setMatiere($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getMatiere() === $this) {
                $note->setMatiere(null);
            }
        }

        return $this;
    }
    public function clearId()
    {
        $this->id = null; // également essayé avec "", 0, valeur de l'auto-incrément, true, false, -1

        return $this;
    }

    /**
     * @return Collection<int, Passage>
     */
    public function getPassages(): Collection
    {
        return $this->passages;
    }

    public function addPassage(Passage $passage): self
    {
        if (!$this->passages->contains($passage)) {
            $this->passages->add($passage);
            $passage->setMatiere($this);
        }

        return $this;
    }

    public function removePassage(Passage $passage): self
    {
        if ($this->passages->removeElement($passage)) {
            // set the owning side to null (unless already changed)
            if ($passage->getMatiere() === $this) {
                $passage->setMatiere(null);
            }
        }

        return $this;
    }

    public function getVhe(): ?int
    {
        return $this->vhe;
    }

    public function setVhe(?int $vhe): self
    {
        $this->vhe = $vhe;

        return $this;
    }

    public function getTpe(): ?int
    {
        return $this->tpe;
    }

    public function setTpe(?int $tpe): self
    {
        $this->tpe = $tpe;

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
            $ficheIdentification->addMatiere($this);
        }

        return $this;
    }

    public function removeFicheIdentification(FicheIdentification $ficheIdentification): self
    {
        if ($this->ficheIdentifications->removeElement($ficheIdentification)) {
            $ficheIdentification->removeMatiere($this);
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

    public function isFerme(): ?bool
    {
        return $this->ferme;
    }

    public function setFerme(?bool $ferme): self
    {
        $this->ferme = $ferme;

        return $this;
    }

    public function getVhr(): ?float
    {
        return $this->vhr;
    }

    public function setVhr(?float $vhr): self
    {
        $this->vhr = $vhr;

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
            $honoraire->setMatiere($this);
        }

        return $this;
    }

    public function removeHonoraire(Honoraire $honoraire): self
    {
        if ($this->honoraires->removeElement($honoraire)) {
            // set the owning side to null (unless already changed)
            if ($honoraire->getMatiere() === $this) {
                $honoraire->setMatiere(null);
            }
        }

        return $this;
    }

    public function getTauxHoraireBrut(): ?float
    {
        return $this->tauxHoraireBrut;
    }

    public function setTauxHoraireBrut(?float $tauxHoraireBrut): self
    {
        $this->tauxHoraireBrut = $tauxHoraireBrut;

        return $this;
    }

    public function getCycle(): ?string
    {
        return $this->cycle;
    }

    public function setCycle(?string $cycle): self
    {
        $this->cycle = $cycle;

        return $this;
    }

    public function getSurplus(): ?float
    {
        return $this->surplus;
    }

    public function setSurplus(?float $surplus): self
    {
        $this->surplus = $surplus;

        return $this;
    }

    public function getHonoraireRecap(): ?HonoraireRecap
    {
        return $this->honoraireRecap;
    }

    public function setHonoraireRecap(?HonoraireRecap $honoraireRecap): self
    {
        // unset the owning side of the relation if necessary
        if ($honoraireRecap === null && $this->honoraireRecap !== null) {
            $this->honoraireRecap->setMatiere(null);
        }

        // set the owning side of the relation if necessary
        if ($honoraireRecap !== null && $honoraireRecap->getMatiere() !== $this) {
            $honoraireRecap->setMatiere($this);
        }

        $this->honoraireRecap = $honoraireRecap;

        return $this;
    }



}
