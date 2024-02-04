<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\SponsorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SponsorRepository::class)]
#[ApiResource()]
#[ApiFilter(
    searchFilter::class,
    properties: [
        "etablissement"=>"exact"
    ]
)]
class Sponsor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:typeBourse:sponsor'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:typeBourse:sponsor'])]
    private ?string $intitule = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $detail = null;

    #[ORM\OneToMany(mappedBy: 'sponsor', targetEntity: TypeBourse::class)]
    private Collection $typeBourses;

    #[ORM\ManyToOne(inversedBy: 'Sponsors')]
    private ?Etablissement $etablissement = null;

    public function __construct()
    {
        $this->typeBourses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(?string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * @return Collection<int, TypeBourse>
     */
    public function getTypeBourses(): Collection
    {
        return $this->typeBourses;
    }

    public function addTypeBourse(TypeBourse $typeBourse): self
    {
        if (!$this->typeBourses->contains($typeBourse)) {
            $this->typeBourses->add($typeBourse);
            $typeBourse->setSponsor($this);
        }

        return $this;
    }

    public function removeTypeBourse(TypeBourse $typeBourse): self
    {
        if ($this->typeBourses->removeElement($typeBourse)) {
            // set the owning side to null (unless already changed)
            if ($typeBourse->getSponsor() === $this) {
                $typeBourse->setSponsor(null);
            }
        }

        return $this;
    }

    public function getEtablissement(): ?Etablissement
    {
        return $this->etablissement;
    }

    public function setEtablissement(?Etablissement $etablissement): self
    {
        $this->etablissement = $etablissement;

        return $this;
    }
}
