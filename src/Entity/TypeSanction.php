<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TypeSanctionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TypeSanctionRepository::class)]
#[ApiResource]

class TypeSanction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read:typeSanction"])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
     #[Groups(["read:typeSanction"])]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'typeSanction', targetEntity: Sanction::class)]
    private Collection $sanctions;

    public function __construct()
    {
        $this->sanctions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Sanction>
     */
    public function getSanctions(): Collection
    {
        return $this->sanctions;
    }

    public function addSanction(Sanction $sanction): self
    {
        if (!$this->sanctions->contains($sanction)) {
            $this->sanctions->add($sanction);
            $sanction->setTypeSanction($this);
        }

        return $this;
    }

    public function removeSanction(Sanction $sanction): self
    {
        if ($this->sanctions->removeElement($sanction)) {
            // set the owning side to null (unless already changed)
            if ($sanction->getTypeSanction() === $this) {
                $sanction->setTypeSanction(null);
            }
        }

        return $this;
    }
}
