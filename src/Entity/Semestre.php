<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SemestreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SemestreRepository::class)]
#[ApiResource]
class Semestre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:periode:semestre','read:ue:semestre'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:periode:semestre','read:ue:semestre'])]
    private ?string $intitule = null;

    #[ORM\OneToMany(mappedBy: 'semestre', targetEntity: Periode::class, orphanRemoval: true)]
    private Collection $periodes;



    public function __construct()
    {
        $this->periodes = new ArrayCollection();

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

    /**
     * @return Collection<int, Periode>
     */
    public function getPeriodes(): Collection
    {
        return $this->periodes;
    }

    public function addPeriode(Periode $periode): self
    {
        if (!$this->periodes->contains($periode)) {
            $this->periodes->add($periode);
            $periode->setSemestre($this);
        }

        return $this;
    }

    public function removePeriode(Periode $periode): self
    {
        if ($this->periodes->removeElement($periode)) {
            // set the owning side to null (unless already changed)
            if ($periode->getSemestre() === $this) {
                $periode->setSemestre(null);
            }
        }

        return $this;
    }

}
