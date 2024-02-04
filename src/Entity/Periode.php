<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\PeriodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PeriodeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:periode','read:periode:session','read:periode:semestre']],
    denormalizationContext: ['groups'=>['read:periode']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'niveau'=>'exact',
        'anneeAcademic'=>'exact',
        'libelle'=>"partial"
    ]
)]
class Periode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:periode','read:matiere:ue:periode','read:parcours:periode','read:niveau:periode','read:compensation:ue:periode','read:classe:niveau:periode','read:ue:periode','read:professeur:classe:niveau:periode',"read:passage:periode"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['read:periode','read:niveau:periode'])]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['read:periode','read:niveau:periode'])]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['read:periode','read:niveau:periode'])]
    private ?\DateTimeInterface $dateConseil = null;

    #[ORM\ManyToOne(inversedBy: 'periodes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:periode','read:niveau:periode'])]
    private ?Semestre $semestre = null;

    #[ORM\ManyToOne(inversedBy: 'periodes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:periode','read:niveau:periode'])]
    private ?Session $session = null;


    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:periode','read:matiere:ue:periode','read:parcours:periode','read:niveau:periode','read:compensation:ue:periode','read:classe:niveau:periode','read:ue:periode','read:professeur:classe:niveau:periode',"read:passage:periode"])]
    private ?string $libelle = null;

    #[ORM\ManyToOne(inversedBy: 'periodes')]
    #[Groups(['read:periode'])]
    private ?Niveau $niveau = null;

    #[ORM\OneToMany(mappedBy: 'periode', targetEntity: Bulletin::class)]
    private Collection $bulletins;

    #[ORM\OneToMany(mappedBy: 'periode', targetEntity: Note::class)]
    #[Groups(['read:periode'])]
    private Collection $notes;

    #[ORM\ManyToMany(targetEntity: Ue::class, mappedBy: 'periodes')]
    private Collection $ues;

    #[ORM\ManyToOne(inversedBy: 'periodes')]
    #[Groups(['read:periode'])]
    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:periode'])]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'periode', targetEntity: Passage::class)]
    private Collection $passages;

    #[ORM\OneToMany(mappedBy: 'periode', targetEntity: Parcours::class)]
    private Collection $parcours;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:periode','read:niveau:periode','read:classe:niveau:periode','read:professeur:classe:niveau:periode'])]
    private ?bool $final = false;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:periode','read:niveau:periode','read:classe:niveau:periode','read:professeur:classe:niveau:periode'])]
    private ?bool $ferme = false;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:periode','read:niveau:periode','read:classe:niveau:periode','read:professeur:classe:niveau:periode'])]
    private ?bool $cycle = false;

    #[ORM\OneToMany(mappedBy: 'periode', targetEntity: PeriodePrec::class)]
    private Collection $periodeprecs;



    public function __construct()
    {
        $this->bulletins = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->ues = new ArrayCollection();
        $this->passages = new ArrayCollection();
        $this->parcours = new ArrayCollection();
        $this->periodeprecs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDateConseil(): ?\DateTimeInterface
    {
        return $this->dateConseil;
    }

    public function setDateConseil(?\DateTimeInterface $dateConseil): self
    {
        $this->dateConseil = $dateConseil;

        return $this;
    }

    public function getSemestre(): ?Semestre
    {
        return $this->semestre;
    }

    public function setSemestre(?Semestre $semestre): self
    {
        $this->semestre = $semestre;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
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

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection<int, Bulletin>
     */
    public function getBulletins(): Collection
    {
        return $this->bulletins;
    }

    public function addBulletin(Bulletin $bulletin): self
    {
        if (!$this->bulletins->contains($bulletin)) {
            $this->bulletins->add($bulletin);
            $bulletin->setPeriode($this);
        }

        return $this;
    }

    public function removeBulletin(Bulletin $bulletin): self
    {
        if ($this->bulletins->removeElement($bulletin)) {
            // set the owning side to null (unless already changed)
            if ($bulletin->getPeriode() === $this) {
                $bulletin->setPeriode(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setPeriode($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getPeriode() === $this) {
                $note->setPeriode(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ue>
     */
    public function getUes(): Collection
    {
        return $this->ues;
    }

    public function addUe(Ue $ue): self
    {
        if (!$this->ues->contains($ue)) {
            $this->ues->add($ue);
            $ue->addPeriode($this);
        }

        return $this;
    }

    public function removeUe(Ue $ue): self
    {
        if ($this->ues->removeElement($ue)) {
            $ue->removePeriode($this);
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
            $passage->setPeriode($this);
        }

        return $this;
    }

    public function removePassage(Passage $passage): self
    {
        if ($this->passages->removeElement($passage)) {
            // set the owning side to null (unless already changed)
            if ($passage->getPeriode() === $this) {
                $passage->setPeriode(null);
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
            $parcour->setPeriode($this);
        }

        return $this;
    }

    public function removeParcour(Parcours $parcour): self
    {
        if ($this->parcours->removeElement($parcour)) {
            // set the owning side to null (unless already changed)
            if ($parcour->getPeriode() === $this) {
                $parcour->setPeriode(null);
            }
        }

        return $this;
    }
    public function clearId()
    {
        $this->id = null; // également essayé avec "", 0, valeur de l'auto-incrément, true, false, -1
        $this->anneeAcademic=null;
        $this->ues=new ArrayCollection();
        $this->bulletins=new ArrayCollection();
        $this->notes=new ArrayCollection();
        $this->passages=new ArrayCollection();
        $this->parcours=new ArrayCollection();
        $this->periodeprecs=new ArrayCollection();
        $this->niveau=null;
        return $this;
    }

    public function isFinal(): ?bool
    {
        return $this->final;
    }

    public function setFinal(?bool $final): self
    {
        $this->final = $final;

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

    public function isCycle(): ?bool
    {
        return $this->cycle;
    }

    public function setCycle(?bool $cycle): self
    {
        $this->cycle = $cycle;

        return $this;
    }

    /**
     * @return Collection<int, PeriodePrec>
     */
    public function getPeriodeprecs(): Collection
    {
        return $this->periodeprecs;
    }

    public function addPeriodeprec(PeriodePrec $periodeprec): self
    {
        if (!$this->periodeprecs->contains($periodeprec)) {
            $this->periodeprecs->add($periodeprec);
            $periodeprec->setPeriode($this);
        }

        return $this;
    }

    public function removePeriodeprec(PeriodePrec $periodeprec): self
    {
        if ($this->periodeprecs->removeElement($periodeprec)) {
            // set the owning side to null (unless already changed)
            if ($periodeprec->getPeriode() === $this) {
                $periodeprec->setPeriode(null);
            }
        }

        return $this;
    }
}
