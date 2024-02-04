<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\ParametrageFraisScolariteController;
use App\Repository\ParametrageFraisScolariteNivRepository;
use App\Repository\SoldeEtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ParametrageFraisScolariteNivRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:parametrageScolarite','read:parametrageScolariteNiv','read:parametrageScolarite:niv','read:parametrageScolarite:Type','read:parametrageScolarite:Categorie']],
    collectionOperations:[
        'get',
        'post'=>[
            'controller' => ParametrageFraisScolariteController::class
        ]
    ],
    itemOperations: [
        'get',
        'put'=>[
            'controller' => ParametrageFraisScolariteController::class
        ],
        'delete'=>[
            'controller' => ParametrageFraisScolariteController::class
        ],
        'patch',
    ]
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'institut'=>'exact',
        'anneeAcademic'=>'exact',
        'niveau'=>'exact',
    ]
)]
class ParametrageFraisScolariteNiv extends ParametrageFraisScolarite
{

    #[ORM\ManyToOne(inversedBy: 'parametrageFraisScolariteNivs')]
    #[Groups(['read:parametrageScolariteNiv'])]
    private ?Niveau $niveau = null;

    #[ORM\ManyToMany(targetEntity: TypeBourse::class, mappedBy: 'parametrageFraisScolariteNivs')]
    #[Groups(['read:parametrageScolariteNiv'])]
    private Collection $typeBourses;

    public function __construct()
    {
        parent::__construct();
        $this->typeBourses = new ArrayCollection();
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection<int, TypeBourse>
     */
    public function getTypeBourses(): Collection
    {
        return $this->typeBourses;
    }

    public function addTypeBourse(TypeBourse $typeBourse): self
    {
        if (!$this->typeBourses->contains($typeBourse)) {
            $this->typeBourses->add($typeBourse);
            $typeBourse->addParametrageFraisScolariteNiv($this);
        }

        return $this;
    }

    public function removeTypeBourse(TypeBourse $typeBourse): self
    {
        if ($this->typeBourses->removeElement($typeBourse)) {
            $typeBourse->removeParametrageFraisScolariteNiv($this);
        }

        return $this;
    }


}
