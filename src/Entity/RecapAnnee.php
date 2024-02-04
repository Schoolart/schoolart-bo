<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RecapAnneeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecapAnneeRepository::class)]
#[ApiResource]
class RecapAnnee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recaps')]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'recaps')]
    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\Column(nullable: true)]
    private ?float $moyenne = null;

    #[ORM\Column(nullable: true)]
    private ?int $totalCredit = null;

    #[ORM\Column(nullable: true)]
    private ?float $assiduite = null;

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

    public function getAnneeAcademic(): ?AnneeAcademic
    {
        return $this->anneeAcademic;
    }

    public function setAnneeAcademic(?AnneeAcademic $anneeAcademic): self
    {
        $this->anneeAcademic = $anneeAcademic;

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

    public function getTotalCredit(): ?int
    {
        return $this->totalCredit;
    }

    public function setTotalCredit(?int $totalCredit): self
    {
        $this->totalCredit = $totalCredit;

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
}
