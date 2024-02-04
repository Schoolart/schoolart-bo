<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\UeSupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UeSupRepository::class)]
#[ApiResource]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'niveau'=>'exact'
    ]
)]
class UeSup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:ue:ueSup','read:note:matiere:ue:ueSup','read:compensation:ue:ueSup','read:matiere:ue:ueSup',"read:passage:ue:ueSup"])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:ue:ueSup','read:note:matiere:ue:ueSup','read:compensation:ue:ueSup','read:matiere:ue:ueSup',"read:passage:ue:ueSup"])]
    private ?string $intituleFr = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:ue:ueSup','read:note:matiere:ue:ueSup','read:compensation:ue:ueSup','read:matiere:ue:ueSup',"read:passage:ue:ueSup"])]
    private ?string $intituleEn = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $abreviationFr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $abreviationEn = null;

    #[ORM\ManyToOne(inversedBy: 'ueSups')]
    private ?Niveau $niveau = null;

    #[ORM\OneToMany(mappedBy: 'ueSup', targetEntity: Ue::class)]
    private Collection $ues;

    public function __construct()
    {
        $this->ues = new ArrayCollection();
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
     * @return Collection<int, Ue>
     */
    public function getUes(): Collection
    {
        return $this->ues;
    }

    public function addUe(Ue $ue): self
    {
        if (!$this->ues->contains($ue)) {
            $this->ues->add($ue);
            $ue->setUeSup($this);
        }

        return $this;
    }

    public function removeUe(Ue $ue): self
    {
        if ($this->ues->removeElement($ue)) {
            // set the owning side to null (unless already changed)
            if ($ue->getUeSup() === $this) {
                $ue->setUeSup(null);
            }
        }

        return $this;
    }
    public function clearId()
    {
        $this->id = null; // également essayé avec "", 0, valeur de l'auto-incrément, true, false, -1
        $this->niveau = null;
        $this->ues=new ArrayCollection();
        return $this;
    }
}
