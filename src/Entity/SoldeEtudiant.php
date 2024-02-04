<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\SoldeEtudiantRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SoldeEtudiantRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:solde','read:etudiant','read:user','read:etudiant:classe',
        'read:etudiant:bourse','read:etudiant:bourse:typeBourse','read:solde:annee']],
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'institut'=>'exact',
        'anneeAcademic'=>'exact',
        'etudiant'=>'exact'
    ]
)]
class SoldeEtudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:solde'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'soldes')]
    #[Groups(['read:solde'])]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'soldes')]
    #[Groups(['read:solde'])]
    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:solde'])]
    private ?int $solde = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:solde'])]
    private ?int $soldePaiement = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:solde'])]
    private ?int $soldeEcheance = null;

    #[ORM\ManyToOne(inversedBy: 'soldes')]
    private ?Institut $institut = null;

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

    public function getAnneeAcademic(): ?AnneeAcademic
    {
        return $this->anneeAcademic;
    }

    public function setAnneeAcademic(?AnneeAcademic $anneeAcademic): self
    {
        $this->anneeAcademic = $anneeAcademic;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(?int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getSoldePaiement(): ?int
    {
        return $this->soldePaiement;
    }

    public function setSoldePaiement(?int $soldePaiement): self
    {
        $this->soldePaiement = $soldePaiement;

        return $this;
    }

    public function getSoldeEcheance(): ?int
    {
        return $this->soldeEcheance;
    }

    public function setSoldeEcheance(?int $soldeEcheance): self
    {
        $this->soldeEcheance = $soldeEcheance;

        return $this;
    }

    public function getInstitut(): ?Institut
    {
        return $this->institut;
    }

    public function setInstitut(?Institut $institut): self
    {
        $this->institut = $institut;

        return $this;
    }
}
