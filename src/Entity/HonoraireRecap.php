<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\HonoraireRecapRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HonoraireRecapRepository::class)]
#[ApiResource]
class HonoraireRecap
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?float $vhr = null;

    #[ORM\Column(nullable: true)]
    private ?float $vhp = null;

    #[ORM\Column(nullable: true)]
    private ?float $vhe = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ferme = null;

    #[ORM\OneToOne(inversedBy: 'honoraireRecap', cascade: ['persist', 'remove'])]
    private ?Matiere $matiere = null;

    #[ORM\ManyToOne(inversedBy: 'honoraireRecaps')]
    private ?Institut $institut = null;

    #[ORM\ManyToOne(inversedBy: 'honoraireRecaps')]
    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\ManyToOne(inversedBy: 'honoraireRecaps')]
    private ?Professeur $professeur = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function getVhp(): ?float
    {
        return $this->vhp;
    }

    public function setVhp(?float $vhp): self
    {
        $this->vhp = $vhp;

        return $this;
    }

    public function getVhe(): ?float
    {
        return $this->vhe;
    }

    public function setVhe(?float $vhe): self
    {
        $this->vhe = $vhe;

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

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

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

    public function getAnneeAcademic(): ?AnneeAcademic
    {
        return $this->anneeAcademic;
    }

    public function setAnneeAcademic(?AnneeAcademic $anneeAcademic): self
    {
        $this->anneeAcademic = $anneeAcademic;

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
}
