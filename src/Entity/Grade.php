<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\GradeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>[
        'read:grade']],
    denormalizationContext: ['groups'=>['read:grade']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'programme'=>'exact'
    ]
)]
class Grade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:grade','read:domaine:grade','read:programme:grade','read:mention:domaine:grade'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:grade','read:domaine:grade','read:programme:grade','read:mention:domaine:grade'])]
    private ?string $intitule = null;

    #[ORM\ManyToOne(inversedBy: 'grades')]
    #[Groups(['read:grade'])]
    private ?Programme $programme = null;

    #[ORM\OneToMany(mappedBy: 'grade', targetEntity: Domaine::class)]
    #[Groups(['read:grade','read:programme:grade'])]
    private Collection $domaines;

    public function __construct()
    {
        $this->domaines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getProgramme(): ?Programme
    {
        return $this->programme;
    }

    public function setProgramme(?Programme $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    /**
     * @return Collection<int, Domaine>
     */
    public function getDomaines(): Collection
    {
        return $this->domaines;
    }

    public function addDomaine(Domaine $domaine): self
    {
        if (!$this->domaines->contains($domaine)) {
            $this->domaines->add($domaine);
            $domaine->setGrade($this);
        }

        return $this;
    }

    public function removeDomaine(Domaine $domaine): self
    {
        if ($this->domaines->removeElement($domaine)) {
            // set the owning side to null (unless already changed)
            if ($domaine->getGrade() === $this) {
                $domaine->setGrade(null);
            }
        }

        return $this;
    }
}
