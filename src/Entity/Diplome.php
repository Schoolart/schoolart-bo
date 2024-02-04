<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\DiplomeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DiplomeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:diplome','read:diplome:anneeAcademic','read:diplome:anneeAcademic:institut']],
    denormalizationContext: ['groups'=>['write:diplome']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'anneeAcademic'=>'exact'
    ]
)]
class Diplome
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:diplome','read:classe:diplome'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:diplome','write:diplome'])]
    private ?string $intitule = null;

    #[ORM\OneToOne(mappedBy: 'diplome', cascade: ['persist', 'remove'])]
    #[Groups(['read:diplome'])]
    private ?Classe $classe = null;

    #[ORM\ManyToOne(inversedBy: 'diplomes')]
    #[Groups(['read:diplome','write:diplome'])]
    private ?AnneeAcademic $anneeAcademic = null;



    public function __construct()
    {

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

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        // unset the owning side of the relation if necessary
        if ($classe === null && $this->classe !== null) {
            $this->classe->setDiplome(null);
        }

        // set the owning side of the relation if necessary
        if ($classe !== null && $classe->getDiplome() !== $this) {
            $classe->setDiplome($this);
        }

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
