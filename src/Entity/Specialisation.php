<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\SpecialisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SpecialisationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:specialisation','read:specialisation:mention']],
    denormalizationContext: ['groups'=>['read:specialisation']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'mention'=>'exact',
        'programme'=>'exact'
    ]
)]
class Specialisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:specialisation','read:classe:specialisation','read:programme:grade:domaine:mention:specialisation'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:specialisation','read:classe:specialisation','read:programme:grade:domaine:mention:specialisation'])]
    private ?string $intitule = null;

    #[ORM\ManyToOne(inversedBy: 'specialisations')]
    #[Groups(['read:specialisation'])]
    private ?Mention $mention = null;

    #[ORM\OneToMany(mappedBy: 'specialisation', targetEntity: Classe::class)]
    private Collection $classes;

    #[ORM\ManyToOne(inversedBy: 'specialisation')]
    #[Groups(['read:specialisation'])]
    private ?Programme $programme = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:specialisation','read:classe:specialisation','read:programme:grade:domaine:mention:specialisation'])]
    private ?string $description = null;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
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

    public function getMention(): ?Mention
    {
        return $this->mention;
    }

    public function setMention(?Mention $mention): self
    {
        $this->mention = $mention;

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
            $class->setSpecialisation($this);
        }

        return $this;
    }

    public function removeClass(Classe $class): self
    {
        if ($this->classes->removeElement($class)) {
            // set the owning side to null (unless already changed)
            if ($class->getSpecialisation() === $this) {
                $class->setSpecialisation(null);
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
