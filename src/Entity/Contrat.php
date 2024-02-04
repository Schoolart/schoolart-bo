<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ContratRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: ContratRepository::class)]
#[ApiResource(
        normalizationContext: ['groups'=>["read:contrat","read:fiche:prof"]]

)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'professeur'=>'exact',
        'cycleIntervention'=>"exact",
        'institut'=>"exact",
        'anneeAcademic'=>"exact"
    ]
)]
#[ApiFilter(
    DateFilter::class,
    properties: [
        'date'
    ]
)]
class Contrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read:contrat"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(["read:contrat"])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["read:contrat"])]
    private ?string $numeroContrat = null;

    #[ORM\ManyToOne(inversedBy: 'contrats')]
    private ?Institut $institut = null;

    #[ORM\ManyToOne(inversedBy: 'contrats')]
    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\ManyToOne(inversedBy: 'contrats')]
    #[Groups(["read:contrat"])]
    private ?Professeur $professeur = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["read:contrat"])]
    private ?string $file = null;

    #[ORM\ManyToOne(inversedBy: 'contrats')]
    #[Groups(["read:contrat"])]
    private ?Admin $userContratCreate = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["read:contrat"])]
    private ?string $cycleIntervention = null;

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

    public function getNumeroContrat(): ?string
    {
        return $this->numeroContrat;
    }

    public function setNumeroContrat(?string $numeroContrat): self
    {
        $this->numeroContrat = $numeroContrat;

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

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getUserContratCreate(): ?Admin
    {
        return $this->userContratCreate;
    }

    public function setUserContratCreate(?Admin $userCreate): self
    {
        $this->userContratCreate = $userCreate;

        return $this;
    }

    public function getCycleIntervention(): ?string
    {
        return $this->cycleIntervention;
    }

    public function setCycleIntervention(?string $cycleIntervention): self
    {
        $this->cycleIntervention = $cycleIntervention;

        return $this;
    }
}
