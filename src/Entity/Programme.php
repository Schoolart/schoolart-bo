<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ProgrammeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProgrammeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>[
        'read:programme',
        'read:programme:grade',
        'read:programme:grade:domaine',
        'read:programme:grade:domaine:mention',
        'read:programme:grade:domaine:mention:specialisation']],
    denormalizationContext: ['groups'=>['read:programme']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'institut'=>'exact'
    ]
)]
class Programme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:programme'])]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'programme', targetEntity: Grade::class)]
    #[Groups(['read:programme'])]
    private Collection $grades;

    #[ORM\OneToOne(mappedBy: 'programme', cascade: ['persist', 'remove'])]
    #[Groups(['read:programme'])]
    private ?Institut $institut = null;

    #[ORM\OneToMany(mappedBy: 'programme', targetEntity: Domaine::class)]
    private Collection $domaines;

    #[ORM\OneToMany(mappedBy: 'programme', targetEntity: Specialisation::class)]
    private Collection $specialisation;

    #[ORM\OneToMany(mappedBy: 'programme', targetEntity: Mention::class)]
    private Collection $mentions;

    public function __construct()
    {
        $this->grades = new ArrayCollection();
        $this->domaines = new ArrayCollection();
        $this->specialisation = new ArrayCollection();
        $this->mentions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Grade>
     */
    public function getGrades(): Collection
    {
        return $this->grades;
    }

    public function addGrade(Grade $grade): self
    {
        if (!$this->grades->contains($grade)) {
            $this->grades->add($grade);
            $grade->setProgramme($this);
        }

        return $this;
    }

    public function removeGrade(Grade $grade): self
    {
        if ($this->grades->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getProgramme() === $this) {
                $grade->setProgramme(null);
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
        // unset the owning side of the relation if necessary
        if ($institut === null && $this->institut !== null) {
            $this->institut->setProgramme(null);
        }

        // set the owning side of the relation if necessary
        if ($institut !== null && $institut->getProgramme() !== $this) {
            $institut->setProgramme($this);
        }

        $this->institut = $institut;

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
            $domaine->setProgramme($this);
        }

        return $this;
    }

    public function removeDomaine(Domaine $domaine): self
    {
        if ($this->domaines->removeElement($domaine)) {
            // set the owning side to null (unless already changed)
            if ($domaine->getProgramme() === $this) {
                $domaine->setProgramme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Specialisation>
     */
    public function getSpecialisation(): Collection
    {
        return $this->specialisation;
    }

    public function addSpecialisation(Specialisation $specialisation): self
    {
        if (!$this->specialisation->contains($specialisation)) {
            $this->specialisation->add($specialisation);
            $specialisation->setProgramme($this);
        }

        return $this;
    }

    public function removeSpecialisation(Specialisation $specialisation): self
    {
        if ($this->specialisation->removeElement($specialisation)) {
            // set the owning side to null (unless already changed)
            if ($specialisation->getProgramme() === $this) {
                $specialisation->setProgramme(null);
            }
        }

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
            $mention->setProgramme($this);
        }

        return $this;
    }

    public function removeMention(Mention $mention): self
    {
        if ($this->mentions->removeElement($mention)) {
            // set the owning side to null (unless already changed)
            if ($mention->getProgramme() === $this) {
                $mention->setProgramme(null);
            }
        }

        return $this;
    }
}
