<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BourseRepository::class)]
#[ApiResource]
class Bourse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:etudiant:bourse'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:etudiant:bourse'])]
    private ?string $originBourse = null;

    #[ORM\ManyToOne(inversedBy: 'bourses')]
    #[Groups(['read:etudiant:bourse'])]
    private ?TypeBourse $typeBourse = null;

    #[ORM\OneToMany(mappedBy: 'bourse', targetEntity: Etudiant::class)]
    private Collection $etudiants;



    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginBourse(): ?string
    {
        return $this->originBourse;
    }

    public function setOriginBourse(?string $originBourse): self
    {
        $this->originBourse = $originBourse;

        return $this;
    }

    public function getTypeBourse(): ?TypeBourse
    {
        return $this->typeBourse;
    }

    public function setTypeBourse(?TypeBourse $typeBourse): self
    {
        $this->typeBourse = $typeBourse;

        return $this;
    }

    /**
     * @return Collection<int, Etudiant>
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants->add($etudiant);
            $etudiant->setBourse($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getBourse() === $this) {
                $etudiant->setBourse(null);
            }
        }

        return $this;
    }
}
