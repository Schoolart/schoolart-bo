<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ParcoursRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ParcoursRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:parcours','read:parcours:etudiant','read:parcours:niv','read:parcours:classe','read:parcours:periode']],
    denormalizationContext: ['groups'=>['read:parcours']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        "classe"=>"exact",
        "etudiant"=>"exact",
        "periode"=>"exact",
        'niveau'=>"exact"
    ]
)]
class Parcours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:parcours'])]
    private ?int $id = null;



    #[ORM\ManyToOne(inversedBy: 'parcours')]
    #[Groups(['read:parcours'])]
    private ?Classe $classe = null;

    #[ORM\ManyToOne(inversedBy: 'parcours')]
    #[Groups(['read:parcours'])]
    private ?Niveau $niveau = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:parcours'])]
    private ?float $moyenne = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:parcours'])]
    private ?int $creditCapitalise = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:parcours'])]
    private ?float $assiduite = null;

    #[ORM\ManyToOne(inversedBy: 'parcours')]
    #[Groups(['read:parcours'])]
    private ?Periode $periode = null;

    #[ORM\ManyToOne(inversedBy: 'parcours')]
    #[Groups(['read:parcours'])]
    private ?Etudiant $etudiant = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:parcours'])]
    private ?int $rang = null;

    #[ORM\ManyToOne(inversedBy: 'parcours')]
    private ?AnneeAcademic $anneeAcademic = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getMoyenne(): ?float
    {
        return $this->moyenne;
    }

    public function setMoyenne(?float $moyenne): self
    {
        $this->moyenne = $moyenne;

        return $this;
    }

    public function getCreditCapitalise(): ?int
    {
        return $this->creditCapitalise;
    }

    public function setCreditCapitalise(?int $creditCapitalise): self
    {
        $this->creditCapitalise = $creditCapitalise;

        return $this;
    }

    public function getAssiduite(): ?float
    {
        return $this->assiduite;
    }

    public function setAssiduite(?float $assiduite): self
    {
        $this->assiduite = $assiduite;

        return $this;
    }

    public function getPeriode(): ?Periode
    {
        return $this->periode;
    }

    public function setPeriode(?Periode $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getRang(): ?int
    {
        return $this->rang;
    }

    public function setRang(?int $rang): self
    {
        $this->rang = $rang;

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
}
