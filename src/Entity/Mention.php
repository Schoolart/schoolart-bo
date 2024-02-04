<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\MentionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MentionRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:mention','read:mention:domaine','read:mention:domaine:grade']],
    denormalizationContext: ['groups'=>['read:mention']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'domaine'=>'exact',
        'programme'=>'exact'
    ]
)]
class Mention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:mention','read:specialisation:mention'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:mention','read:specialisation:mention','read:programme:grade:domaine:mention'])]
    private ?string $intitule = null;

    #[ORM\ManyToOne(inversedBy: 'mentions')]
    #[Groups(['read:mention'])]
    private ?Domaine $domaine = null;

    #[ORM\OneToMany(mappedBy: 'mention', targetEntity: Specialisation::class)]
    #[Groups(['read:programme:grade:domaine:mention'])]
    private Collection $specialisations;

    #[ORM\ManyToOne(inversedBy: 'mentions')]
    #[Groups(['read:mention'])]
    private ?Programme $programme = null;

    public function __construct()
    {
        $this->specialisations = new ArrayCollection();
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

    public function getDomaine(): ?Domaine
    {
        return $this->domaine;
    }

    public function setDomaine(?Domaine $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    /**
     * @return Collection<int, Specialisation>
     */
    public function getSpecialisations(): Collection
    {
        return $this->specialisations;
    }

    public function addSpecialisation(Specialisation $specialisation): self
    {
        if (!$this->specialisations->contains($specialisation)) {
            $this->specialisations->add($specialisation);
            $specialisation->setMention($this);
        }

        return $this;
    }

    public function removeSpecialisation(Specialisation $specialisation): self
    {
        if ($this->specialisations->removeElement($specialisation)) {
            // set the owning side to null (unless already changed)
            if ($specialisation->getMention() === $this) {
                $specialisation->setMention(null);
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
