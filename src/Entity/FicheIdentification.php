<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\FicheIdentificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FicheIdentificationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>["read:fiche","read:fiche:prof",'read:fiche:matiere','read:matiere:matiereSup','read:fiche:classe']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'professeur'=>'exact',
        'cycleIntervention'=>"exact",
        'institut'=>"exact"
    ]
)]
class FicheIdentification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read:fiche"])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["read:fiche"])]
    private ?string $cycleIntervention = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(["read:fiche"])]
    private ?\DateTimeInterface $dateDemarrageCours = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["read:fiche"])]
    private ?int $vhhebdo = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["read:fiche"])]
    private ?float $tauxHoraireBrut = null;

    #[ORM\ManyToOne(inversedBy: 'ficheIdentifications')]

    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\ManyToOne(inversedBy: 'ficheIdentifications')]
    private ?Institut $institut = null;

    #[ORM\ManyToOne(inversedBy: 'ficheIdentifications')]
    #[Groups(["read:fiche"])]
    private ?Professeur $professeur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(["read:fiche"])]
    private ?\DateTimeInterface $dateFinCours = null;

    #[ORM\ManyToMany(targetEntity: Matiere::class, inversedBy: 'ficheIdentifications')]
    #[Groups(["read:fiche"])]
    private Collection $matieres;

    #[ORM\ManyToMany(targetEntity: Classe::class, inversedBy: 'ficheIdentifications')]
    #[Groups(["read:fiche"])]
    private Collection $classes;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["read:fiche"])]
    private ?string $numeroContrat = null;

    #[ORM\ManyToOne(inversedBy: 'ficheIdentifications')]
     #[Groups(["read:fiche"])]
    private ?Admin $userFicheCreate = null;

    public function __construct()
    {
        $this->matieres = new ArrayCollection();
        $this->classes = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateDemarrageCours(): ?\DateTimeInterface
    {
        return $this->dateDemarrageCours;
    }

    public function setDateDemarrageCours(?\DateTimeInterface $dateDemarrageCours): self
    {
        $this->dateDemarrageCours = $dateDemarrageCours;

        return $this;
    }

    public function getVhhebdo(): ?int
    {
        return $this->vhhebdo;
    }

    public function setVhhebdo(?int $vhhebdo): self
    {
        $this->vhhebdo = $vhhebdo;

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

    public function getProfesseur(): ?Professeur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeur $professeur): self
    {
        $this->professeur = $professeur;

        return $this;
    }

    public function getDateFinCours(): ?\DateTimeInterface
    {
        return $this->dateFinCours;
    }

    public function setDateFinCours(?\DateTimeInterface $dateFinCours): self
    {
        $this->dateFinCours = $dateFinCours;

        return $this;
    }

    /**
     * @return Collection<int, Matiere>
     */
    public function getMatieres(): Collection
    {
        return $this->matieres;
    }

    public function addMatiere(Matiere $matiere): self
    {
        if (!$this->matieres->contains($matiere)) {
            $this->matieres->add($matiere);
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): self
    {
        $this->matieres->removeElement($matiere);

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classe $class): self
    {
        if (!$this->classes->contains($class)) {
            $this->classes->add($class);
        }

        return $this;
    }

    public function removeClass(Classe $class): self
    {
        $this->classes->removeElement($class);

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

    public function getUserFicheCreate(): ?Admin
    {
        return $this->userFicheCreate;
    }

    public function setUserFicheCreate(?Admin $userFicheCreate): self
    {
        $this->userFicheCreate = $userFicheCreate;

        return $this;
    }


}
