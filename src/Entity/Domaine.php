<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\DomaineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DomaineRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:domaine','read:domaine:grade']],
    denormalizationContext: ['groups'=>['read:domaine']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'grade'=>'exact',
        'programme'=>'exact'
    ]
)]
class Domaine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:domaine','read:mention:domaine'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:domaine','read:mention:domaine','read:programme:grade:domaine'])]
    private ?string $intitule = null;

    #[ORM\ManyToOne(inversedBy: 'domaines')]
    #[Groups(['read:domaine','read:mention:domaine'])]
    private ?Grade $grade = null;

    #[ORM\OneToMany(mappedBy: 'domaine', targetEntity: Mention::class)]
    #[Groups(['read:programme:grade:domaine'])]
    private Collection $mentions;

    #[ORM\ManyToOne(inversedBy: 'domaines')]
    #[Groups(['read:domaine'])]
    private ?Programme $programme = null;

    public function __construct()
    {
        $this->mentions = new ArrayCollection();
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

    public function getGrade(): ?Grade
    {
        return $this->grade;
    }

    public function setGrade(?Grade $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * @return Collection<int, Mention>
     */
    public function getMentions(): Collection
    {
        return $this->mentions;
    }

    public function addMention(Mention $mention): self
    {
        if (!$this->mentions->contains($mention)) {
            $this->mentions->add($mention);
            $mention->setDomaine($this);
        }

        return $this;
    }

    public function removeMention(Mention $mention): self
    {
        if ($this->mentions->removeElement($mention)) {
            // set the owning side to null (unless already changed)
            if ($mention->getDomaine() === $this) {
                $mention->setDomaine(null);
            }
        }

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
}
