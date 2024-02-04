<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\MatiereSupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MatiereSupRepository::class)]
#[ApiResource]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'niveau'=>'exact'
    ]
)]
class MatiereSup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:ue:matieres:matiereSup','read:matiere:matiereSup',
        'read:professeur:matiere:matiereSup','read:classe:matiere:matiereSup', 'read:note:matiere:matiereSup',"read:passage:matiere:matiereSup"])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:ue:matieres:matiereSup','read:matiere:matiereSup',
        'read:professeur:matiere:matiereSup','read:classe:matiere:matiereSup', 'read:note:matiere:matiereSup',"read:passage:matiere:matiereSup"])]
    private ?string $intituleFr = null;

    #[Groups(['read:ue:matieres:matiereSup','read:matiere:matiereSup',
        'read:professeur:matiere:matiereSup','read:classe:matiere:matiereSup', 'read:note:matiere:matiereSup',"read:passage:matiere:matiereSup"])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $intituleEn = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:matiere:matiereSup'])]
    private ?string $abreviationFr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $abreviationEn = null;

    #[ORM\ManyToOne(inversedBy: 'matiereSups')]
    private ?Niveau $niveau = null;

    #[ORM\OneToMany(mappedBy: 'matiereSup', targetEntity: Matiere::class)]
    private Collection $matieres;

    public function __construct()
    {
        $this->matieres = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntituleFr(): ?string
    {
        return $this->intituleFr;
    }

    public function setIntituleFr(?string $intituleFr): self
    {
        $this->intituleFr = $intituleFr;

        return $this;
    }

    public function getIntituleEn(): ?string
    {
        return $this->intituleEn;
    }

    public function setIntituleEn(?string $intituleEn): self
    {
        $this->intituleEn = $intituleEn;

        return $this;
    }

    public function getAbreviationFr(): ?string
    {
        return $this->abreviationFr;
    }

    public function setAbreviationFr(?string $abreviationFr): self
    {
        $this->abreviationFr = $abreviationFr;

        return $this;
    }

    public function getAbreviationEn(): ?string
    {
        return $this->abreviationEn;
    }

    public function setAbreviationEn(?string $abreviationEn): self
    {
        $this->abreviationEn = $abreviationEn;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

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
            $matiere->setMatiereSup($this);
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): self
    {
        if ($this->matieres->removeElement($matiere)) {
            // set the owning side to null (unless already changed)
            if ($matiere->getMatiereSup() === $this) {
                $matiere->setMatiereSup(null);
            }
        }

        return $this;
    }
    public function clearId()
    {
        $this->id = null; // également essayé avec "", 0, valeur de l'auto-incrément, true, false, -1
        $this->niveau=null;
        $this->matieres=new ArrayCollection();
        return $this;
    }
}
