<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ChronologieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChronologieRepository::class)]
#[ApiResource]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'anneeAcademic'=>'exact',
        'institut'=>'exact'
    ]
)]
class Chronologie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datePrevalidation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateRetrait = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDefinitif = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateSoutenance = null;

    #[ORM\ManyToOne(inversedBy: 'chronologies')]
    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\ManyToOne(inversedBy: 'chronologies')]
    private ?Institut $institut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePrevalidation(): ?\DateTimeInterface
    {
        return $this->datePrevalidation;
    }

    public function setDatePrevalidation(?\DateTimeInterface $datePrevalidation): self
    {
        $this->datePrevalidation = $datePrevalidation;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(?\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getDateDefinitif(): ?\DateTimeInterface
    {
        return $this->dateDefinitif;
    }

    public function setDateDefinitif(?\DateTimeInterface $dateDefinitif): self
    {
        $this->dateDefinitif = $dateDefinitif;

        return $this;
    }

    public function getDateSoutenance(): ?\DateTimeInterface
    {
        return $this->dateSoutenance;
    }

    public function setDateSoutenance(?\DateTimeInterface $dateSoutenance): self
    {
        $this->dateSoutenance = $dateSoutenance;

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

    public function getInstitut(): ?Institut
    {
        return $this->institut;
    }

    public function setInstitut(?Institut $institut): self
    {
        $this->institut = $institut;

        return $this;
    }
}
