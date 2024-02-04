<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\BibliothequeController;
use App\Repository\InfoSupplementaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InfoSupplementaireRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:infoSupplementaire','read:infoSupplementaire:classe']],
    denormalizationContext: ['groups'=>['write:infoSupplementaire']],
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'classe'=>'exact',
        'etudiant'=>'exact',
        'anneeAcademic'=>'exact'
    ]
)]
class InfoSupplementaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:infoSupplementaire','write:infoSupplementaire'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:infoSupplementaire','write:infoSupplementaire'])]
    private ?string $matricule = null;

    #[ORM\ManyToOne(inversedBy: 'infos')]
    #[Groups(['write:infoSupplementaire'])]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'infos')]
    #[Groups(['read:infoSupplementaire','write:infoSupplementaire'])]
    private ?Classe $classe = null;

    #[ORM\ManyToOne(inversedBy: 'infos')]
    #[Groups(['write:infoSupplementaire'])]
    private ?AnneeAcademic $anneeAcademic = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(?string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
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

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

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
}
