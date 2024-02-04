<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\UeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:ue','read:ue:ueSup','read:ue:matieres',
        'read:ue:periode','read:ue:matieres:matiereSup']],
    denormalizationContext: ['groups'=>['read:ue']]
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'classe'=>'exact',
        'periodes'=>'exact'
    ]
)]
class Ue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:ue','read:matiere:ue','read:compensation:ue','read:note:matiere:ue',"read:passage:ue"])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:ue','read:matiere:ue','read:note:matiere:ue','read:compensation:ue',"read:passage:ue"])]
    private ?string $codeUe = null;



    #[ORM\ManyToMany(targetEntity: Compensation::class, mappedBy: 'ues')]
    #[Groups(['read:ue'])]
    private Collection $compensations;

    #[ORM\ManyToOne(inversedBy: 'ues')]
    #[Groups(['read:ue'])]
    private ?Classe $classe = null;

    #[ORM\OneToMany(mappedBy: 'ue', targetEntity: Matiere::class)]
    #[Groups(['read:ue'])]
    private Collection $matieres;


    #[ORM\ManyToMany(targetEntity: Periode::class, inversedBy: 'ues')]
    #[Groups(['read:ue','read:compensation:ue','read:matiere:ue'])]
    private Collection $periodes;

    #[ORM\ManyToOne(inversedBy: 'ues')]
    #[Groups(['read:ue','read:note:matiere:ue','read:compensation:ue','read:matiere:ue',"read:passage:ue"])]
    private ?UeSup $ueSup = null;

    private ?int $coef = null;
    private ?float $noteFinal = null;
    private ?int $credit = null;
    private ?int $creditCapitalise = null;
    private ?float $moyenne = null;
    private ?string $session = null;
    private ?string $resultat=null;


    #[ORM\OneToMany(mappedBy: 'ue', targetEntity: Passage::class)]
    private Collection $passages;

    /**
     * @return string|null
     */
    public function getResultat(): ?string
    {
        return $this->resultat;
    }

    /**
     * @param string|null $resultat
     */
    public function setResultat(?string $resultat): void
    {
        $this->resultat = $resultat;
    }

    /**
     * @return string|null
     */
    public function getSession(): ?string
    {
        return $this->session;
    }

    /**
     * @param string|null $session
     */
    public function setSession(?string $session): void
    {
        $this->session = $session;
    }

    /**
     * @return float|null
     */
    public function getMoyenne(): ?float
    {
        return $this->moyenne;
    }

    /**
     * @param float|null $moyenne
     */
    public function setMoyenne(?float $moyenne): void
    {
        $this->moyenne = $moyenne;
    }

    public function __construct()
    {
        $this->compensations = new ArrayCollection();
        $this->matieres = new ArrayCollection();
        $this->periodes = new ArrayCollection();
        $this->passages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoef(): ?int
    {
        return $this->coef;
    }
    public function setCoef(?int $coef): self
    {
        $this->coef = $coef;

        return $this;
    }
    public function getNoteFinal(): ?float
    {
        return $this->noteFinal;
    }
    public function setNoteFinal(?float $noteFinal): self
    {
        $this->noteFinal = $noteFinal;

        return $this;
    }
    public function setCredit(?int $credit): self
    {
        $this->credit = $credit;

        return $this;
    }
    public function getCredit(): ?int
    {
        return $this->credit;
    }
     public function setCreditCapitalise(?int $creditCapitalise): self
        {
            $this->creditCapitalise = $creditCapitalise;

            return $this;
        }
        public function getCreditCapitalise(): ?int
        {
            return $this->creditCapitalise;
        }

    public function getCodeUe(): ?string
    {
        return $this->codeUe;
    }

    public function setCodeUe(?string $codeUe): self
    {
        $this->codeUe = $codeUe;

        return $this;
    }


    /**
     * @return Collection<int, Compensation>
     */
    public function getCompensations(): Collection
    {
        return $this->compensations;
    }

    public function addCompensation(Compensation $compensation): self
    {
        if (!$this->compensations->contains($compensation)) {
            $this->compensations->add($compensation);
            $compensation->addUe($this);
        }

        return $this;
    }

    public function removeCompensation(Compensation $compensation): self
    {
        if ($this->compensations->removeElement($compensation)) {
            $compensation->removeUe($this);
        }

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
            $matiere->setUe($this);
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): self
    {
        if ($this->matieres->removeElement($matiere)) {
            // set the owning side to null (unless already changed)
            if ($matiere->getUe() === $this) {
                $matiere->setUe(null);
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
        }

        return $this;
    }

    public function removePeriode(Periode $periode): self
    {
        $this->periodes->removeElement($periode);

        return $this;
    }

    public function getUeSup(): ?UeSup
    {
        return $this->ueSup;
    }

    public function setUeSup(?UeSup $ueSup): self
    {
        $this->ueSup = $ueSup;

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
            $passage->setUe($this);
        }

        return $this;
    }

    public function removePassage(Passage $passage): self
    {
        if ($this->passages->removeElement($passage)) {
            // set the owning side to null (unless already changed)
            if ($passage->getUe() === $this) {
                $passage->setUe(null);
            }
        }

        return $this;
    }
    public function clearId()
    {
        $this->id = null; // également essayé avec "", 0, valeur de l'auto-incrément, true, false, -1

        return $this;
    }
}
