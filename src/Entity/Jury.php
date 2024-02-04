<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\JuryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: JuryRepository::class)]
#[ApiResource
(
    normalizationContext: ['groups'=>['read:jury','read:jury:prof']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'anneeAcademic'=>'exact',
        'institut'=>'exact',
        'professeurs'=>'exact'
    ]
)]
class Jury
{#[ApiFilter(
    searchFilter::class,
    properties: [
        'anneeAcademic'=>'exact',
        'institut'=>'exact'
    ]
)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:jury','read:soutenance:jury'])]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Professeur::class, inversedBy: 'juries')]
    #[Groups(['read:jury'])]
    private Collection $professeurs;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:jury','read:soutenance:jury'])]
    private ?string $intitule = null;


    #[ORM\ManyToOne(inversedBy: 'juries')]
    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\OneToMany(mappedBy: 'jury', targetEntity: Soutenance::class)]
    private Collection $soutenances;

    #[ORM\ManyToOne(inversedBy: 'juries')]
    private ?Institut $institut = null;

    public function __construct()
    {
        $this->professeurs = new ArrayCollection();
        $this->soutenances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Professeur>
     */
    public function getProfesseurs(): Collection
    {
        return $this->professeurs;
    }

    public function addProfesseur(Professeur $professeur): self
    {
        if (!$this->professeurs->contains($professeur)) {
            $this->professeurs->add($professeur);
        }

        return $this;
    }

    public function removeProfesseur(Professeur $professeur): self
    {
        $this->professeurs->removeElement($professeur);

        return $this;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(?string $intitule): self
    {
        $this->intitule = $intitule;

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

    /**
     * @return Collection<int, Soutenance>
     */
    public function getSoutenances(): Collection
    {
        return $this->soutenances;
    }

    public function addSoutenance(Soutenance $soutenance): self
    {
        if (!$this->soutenances->contains($soutenance)) {
            $this->soutenances->add($soutenance);
            $soutenance->setJury($this);
        }

        return $this;
    }

    public function removeSoutenance(Soutenance $soutenance): self
    {
        if ($this->soutenances->removeElement($soutenance)) {
            // set the owning side to null (unless already changed)
            if ($soutenance->getJury() === $this) {
                $soutenance->setJury(null);
            }
        }

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
