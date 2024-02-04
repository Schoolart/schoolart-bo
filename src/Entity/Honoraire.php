<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\HonoraireRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

#[ORM\Entity(repositoryClass: HonoraireRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:honoraire','read:honoraire:prof','read:honoraire:matiere','read:matiere:matiereSup']]
)]
#[ApiFilter(
    SearchFilter::class,
    properties:[
        "institut"=>"exact",
        "anneeAcademic"=>"exact",
        "professeur"=>"exact",
        "cycle"=>"exact",
        "matiere"=>"exact"
    ]
)]
#[ApiFilter(
    DateFilter::class,
    properties: [
        'date'
    ]
)]
#[ApiFilter(
    BooleanFilter::class,
    properties: [
        'ferme'
    ]
)]
class Honoraire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:honoraire'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:honoraire'])]
    private ?float $vhr = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:honoraire'])]
    private ?float $vhp = null;

    #[ORM\ManyToOne(inversedBy: 'honoraires')]
    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\ManyToOne(inversedBy: 'honoraires')]
    private ?Institut $institut = null;

    #[ORM\ManyToOne(inversedBy: 'honoraires')]
    #[Groups(['read:honoraire'])]
    private ?Professeur $professeur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['read:honoraire'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:honoraire'])]
    private ?float $vhe = null;

    #[ORM\ManyToOne(inversedBy: 'honoraires')]
     #[Groups(['read:honoraire'])]
    private ?Matiere $matiere = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:honoraire'])]
    private ?bool $ferme = false;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:honoraire'])]
    private ?string $heureDebut = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:honoraire'])]
    private ?string $heureFin = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:honoraire'])]
    private ?float $tauxHoraireBrut = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cycle = null;

    #[ORM\ManyToOne(inversedBy: 'honoraires')]
     #[Groups(['read:honoraire'])]
    private ?Admin $userHonoraireCreate = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getVhp(): ?float
    {
        return $this->vhp;
    }

    public function setVhp(?float $vhp): self
    {
        $this->vhp = $vhp;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

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

    public function getHeureDebut(): ?string
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(?string $heureDebut): self
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?string
    {
        return $this->heureFin;
    }

    public function setHeureFin(?string $heureFin): self
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getTauxHoraireBrut(): ?float
    {
        return $this->tauxHoraireBrut;
    }

    public function setTauxHoraireBrut(?float $tauxHoraireBrut): self
    {
        $this->tauxHoraireBrut = $tauxHoraireBrut;

        return $this;
    }

    public function getCycle(): ?string
    {
        return $this->cycle;
    }

    public function setCycle(?string $cycle): self
    {
        $this->cycle = $cycle;

        return $this;
    }

    public function getUserHonoraireCreate(): ?Admin
    {
        return $this->userHonoraireCreate;
    }

    public function setUserHonoraireCreate(?Admin $userHonoraireCreate): self
    {
        $this->userHonoraireCreate = $userHonoraireCreate;

        return $this;
    }
}
