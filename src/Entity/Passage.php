<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\PassageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PassageRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:passage','read:passage:etudiant','read:passage:classe',"read:passage:ue","read:passage:ue:ueSup","read:passage:matiere","read:passage:matiere:matiereSup","read:passage:periode"]],
    denormalizationContext: ['groups'=>['write:passage']],
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'classe'=>'exact',
        'etudiant'=>'exact',
        'ue'=>'exact',
        'periode'=>'exact'
    ]
)]
class Passage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:passage'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'passages')]
    #[Groups(['read:passage','write:passage'])]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'passages')]
    #[Groups(['read:passage','write:passage'])]
    private ?Ue $ue = null;

    #[ORM\ManyToOne(inversedBy: 'passages')]
    #[Groups(['read:passage','write:passage'])]
    private ?Periode $periode = null;

    #[ORM\ManyToOne(inversedBy: 'passages')]
    #[Groups(['read:passage','write:passage'])]
    private ?Classe $classe = null;

    #[ORM\ManyToOne(inversedBy: 'passages')]
    #[Groups(['read:passage','write:passage'])]
    private ?Matiere $matiere = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUe(): ?Ue
    {
        return $this->ue;
    }

    public function setUe(?Ue $ue): self
    {
        $this->ue = $ue;

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

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

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
}
