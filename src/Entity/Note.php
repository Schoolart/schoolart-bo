<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:note','read:note:etudiant','read:note:matiere',
        'read:note:matiere:matiereSup','read:note:matiere:ue','read:note:matiere:ue:ueSup']],
    denormalizationContext: ['groups'=>['write:note']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'matiere'=>'exact',
        'periode'=>'exact',
        'etudiant'=>'exact',
        'classe'=>'exact'
    ]
)]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:note','write:note'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:note','write:note'])]
    private ?float $cc1 = 0;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:note','write:note'])]
    private ?float $cc2 = 0;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:note','write:note'])]
    private ?float $examen = 0;


    #[ORM\ManyToOne(inversedBy: 'notes')]
    #[Groups(['read:note','write:note'])]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'notes')]
    #[Groups(['read:note','write:note'])]
    private ?Periode $periode = null;

    #[ORM\ManyToOne(inversedBy: 'notes')]
    #[Groups(['read:note','write:note'])]
    private ?Matiere $matiere = null;

    #[ORM\ManyToOne(inversedBy: 'notes')]
    #[Groups(['write:note'])]
    private ?Classe $classe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCc1(): ?float
    {
        return $this->cc1;
    }

    public function setCc1(?float $cc1): self
    {
        $this->cc1 = $cc1;

        return $this;
    }

    public function getCc2(): ?float
    {
        return $this->cc2;
    }

    public function setCc2(?float $cc2): self
    {
        $this->cc2 = $cc2;

        return $this;
    }

    public function getExamen(): ?float
    {
        return $this->examen;
    }

    public function setExamen(?float $examen): self
    {
        $this->examen = $examen;

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
    public function getPeriode(): ?Periode
    {
        return $this->periode;
    }

    public function setPeriode(?Periode $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

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
}
