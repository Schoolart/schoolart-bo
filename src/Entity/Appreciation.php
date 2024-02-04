<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\AppreciationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AppreciationRepository::class)]
#[ApiResource (
    normalizationContext: ['groups'=>['read:appreciation','read:appreciation:parametrage']],
    denormalizationContext: ['groups'=>['read:appreciation']],

)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'parametrage'=>'exact'
    ]
)]
class Appreciation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:appreciation'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:appreciation'])]
    private ?string $libelle = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:appreciation'])]
    private ?int $min = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:appreciation'])]
    private ?int $max = null;

    #[ORM\ManyToOne(inversedBy: 'appreciations')]
    #[Groups(['read:appreciation'])]
    private ?ParametrageInstitut $parametrage=null;


    public function __construct()
    {
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

    public function getMin(): ?int
    {
        return $this->min;
    }

    public function setMin(?int $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }

    public function setMax(?int $max): self
    {
        $this->max = $max;

        return $this;
    }

    public function getParametrage(): ?ParametrageInstitut
    {
        return $this->parametrage;
    }

    public function setParametrage(?ParametrageInstitut $parametrage): self
    {
        $this->parametrage = $parametrage;

        return $this;
    }
    public function clearId()
    {
        $this->id = null; // également essayé avec "", 0, valeur de l'auto-incrément, true, false, -1
        $this->parametrage = null;
        return $this;
    }
}