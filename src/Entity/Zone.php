<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:zone','read:zone:institut']],
    denormalizationContext: ['groups'=>['read:zone']]
)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:zone'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:zone','write:zone'])]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Institut::class)]
    #[Groups(['read:zone','write:zone'])]
    private Collection $instituts;

    public function __construct()
    {
        $this->instituts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Institut>
     */
    public function getInstituts(): Collection
    {
        return $this->instituts;
    }

    public function addInstitut(Institut $institut): self
    {
        if (!$this->instituts->contains($institut)) {
            $this->instituts->add($institut);
            $institut->setZone($this);
        }

        return $this;
    }

    public function removeInstitut(Institut $institut): self
    {
        if ($this->instituts->removeElement($institut)) {
            // set the owning side to null (unless already changed)
            if ($institut->getZone() === $this) {
                $institut->setZone(null);
            }
        }

        return $this;
    }
}
