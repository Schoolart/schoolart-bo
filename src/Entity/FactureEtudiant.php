<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FactureEtudiantRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

#[ORM\Entity(repositoryClass: FactureEtudiantRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:factureEt','read:parametrageScolarite','read:parametrageScolarite:Categorie','read:parametrageScolarite:etud','read:parametrageScolarite:classe']],
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'anneeAcademic'=>'exact',
        'etudiant'=>'exact',
        'classe'=>'exact',
        'parametrageFraisScolarite'=>'exact',
    ]
)]
#[ApiFilter(
    BooleanFilter::class,
    properties: [
        'solder',
    ]
)]

class FactureEtudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:factureEt'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'factureEtudiants')]
    #[Groups(['read:factureEt'])]
    private ?Etudiant $etudiant = null;


    #[ORM\ManyToOne(inversedBy: 'factureEtudiants')]
    #[Groups(['read:factureEt'])]
    private ?ParametrageFraisScolarite $parametrageFraisScolarite = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:factureEt'])]
    private ?int $code = null;

    #[ORM\ManyToOne(inversedBy: 'factureEtudiants')]
    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\ManyToOne(inversedBy: 'factureEtudiants')]
    #[Groups(['read:factureEt'])]
    private ?Classe $classe = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:factureEt'])]
    private ?string $categorie = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:factureEt'])]
    private ?int $montant = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:factureEt'])]
    private ?bool $solder = false;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getParametrageFraisScolarite(): ?ParametrageFraisScolarite
    {
        return $this->parametrageFraisScolarite;
    }

    public function setParametrageFraisScolarite(?ParametrageFraisScolarite $parametrageFraisScolarite): self
    {
        $this->parametrageFraisScolarite = $parametrageFraisScolarite;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(?int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getAnneeAcademic(): ?AnneeAcademic
    {
        return $this->anneeAcademic;
    }

    public function setAnneeAcademic(?AnneeAcademic $anneeAcademic): self
    {
        $this->anneeAcademic = $anneeAcademic;

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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(?int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function isSolder(): ?bool
    {
        return $this->solder;
    }

    public function setSolder(?bool $solder): self
    {
        $this->solder = $solder;

        return $this;
    }
}
