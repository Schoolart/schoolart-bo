<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\CategorieFraisScolariteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategorieFraisScolariteRepository::class)]
#[ApiResource]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'institut'=>'exact',
    ]
)]
class CategorieFraisScolarite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:parametrageScolarite:Categorie'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:parametrageScolarite:Categorie'])]
    private ?string $intitule = null;

    #[ORM\OneToMany(mappedBy: 'categorieFraisScolarite', targetEntity: ParametrageFraisScolarite::class)]
    private Collection $parametrages;

    #[ORM\ManyToOne(inversedBy: 'categorieFraisScolarites')]
    private ?Institut $institut = null;



    public function __construct()
    {
        $this->parametrages = new ArrayCollection();
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

    /**
     * @return Collection<int, ParametrageFraisScolarite>
     */
    public function getParametrages(): Collection
    {
        return $this->parametrages;
    }

    public function addParametrage(ParametrageFraisScolarite $parametrage): self
    {
        if (!$this->parametrages->contains($parametrage)) {
            $this->parametrages->add($parametrage);
            $parametrage->setCategorieFraisScolarite($this);
        }

        return $this;
    }

    public function removeParametrage(ParametrageFraisScolarite $parametrage): self
    {
        if ($this->parametrages->removeElement($parametrage)) {
            // set the owning side to null (unless already changed)
            if ($parametrage->getCategorieFraisScolarite() === $this) {
                $parametrage->setCategorieFraisScolarite(null);
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
