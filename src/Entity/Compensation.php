<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\CompensationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompensationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:compensation','read:compensation:ue','read:compensation:ue:ueSup','read:compensation:ue:periode',]],
    denormalizationContext: ['groups'=>['read:compensation']]
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'classe'=>'exact',
        'ues'=>'exact'
    ]
)]
class Compensation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:compensation'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:compensation'])]
    private ?string $libelle = null;

    #[ORM\ManyToMany(targetEntity: Ue::class, inversedBy: 'compensations')]
    #[Groups(['read:compensation'])]
    private Collection $ues;

    #[ORM\ManyToOne(inversedBy: 'compensations')]
    #[Groups(['read:compensation'])]
    private ?Classe $classe = null;

    public function __construct()
    {
        $this->ues = new ArrayCollection();
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
     * @return Collection<int, Ue>
     */
    public function getUes(): Collection
    {
        return $this->ues;
    }

    public function addUe(Ue $ue): self
    {
        if (!$this->ues->contains($ue)) {
            $this->ues->add($ue);
        }

        return $this;
    }

    public function removeUe(Ue $ue): self
    {
        $this->ues->removeElement($ue);

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }
    public function clearId()
    {
        $this->id = null; // également essayé avec "", 0, valeur de l'auto-incrément, true, false, -1

        return $this;
    }
}
