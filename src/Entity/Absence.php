<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\AbsenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AbsenceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:absence','read:absence:etudiant']],
    denormalizationContext: ['groups'=>['read:absence']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'etudiant'=>'exact',
        'classe'=>'exact',
        'anneeAcademic'=>'exact',
    ]
)]
#[ApiFilter(
    DateFilter::class,
    properties: [
        'date'
    ]
)]
class Absence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:absence'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:absence'])]
    private ?int $NbreAbsence = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:absence'])]
    private ?int $absenceJustifie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['read:absence'])]
    private ?\DateTimeInterface $date = null;



    #[ORM\ManyToOne(inversedBy: 'absences')]
    #[Groups(['read:absence'])]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'absences')]
    #[Groups(['read:absence'])]
    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\ManyToOne(inversedBy: 'absences')]
    #[Groups(['read:absence'])]
    private ?Classe $classe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbreAbsence(): ?int
    {
        return $this->NbreAbsence;
    }

    public function setNbreAbsence(?int $NbreAbsence): self
    {
        $this->NbreAbsence = $NbreAbsence;

        return $this;
    }

    public function getAbsenceJustifie(): ?int
    {
        return $this->absenceJustifie;
    }

    public function setAbsenceJustifie(?int $absenceJustifie): self
    {
        $this->absenceJustifie = $absenceJustifie;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getAnneeAcademic(): ?AnneeAcademic
    {
        return $this->anneeAcademic;
    }

    public function setAnneeAcademic(?AnneeAcademic $anneeAcademic): self
    {
        $this->anneeAcademic = $anneeAcademic;

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
