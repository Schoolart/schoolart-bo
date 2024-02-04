<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PeriodePrecRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeriodePrecRepository::class)]
#[ApiResource]
class PeriodePrec
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'periodeprecs')]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'periodeprecs')]
    private ?Classe $classe = null;

    #[ORM\ManyToOne(inversedBy: 'periodeprecs')]
    private ?Periode $periode = null;

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

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

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
}
