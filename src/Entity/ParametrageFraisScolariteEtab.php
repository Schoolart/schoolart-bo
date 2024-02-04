<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\BibliothequeController;
use App\Controller\ParametrageFraisScolariteController;
use App\Controller\UserController;
use App\Repository\ParametrageFraisScolariteEtabRepository;
use App\Repository\SoldeEtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ParametrageFraisScolariteEtabRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:parametrageScolarite','read:parametrageScolariteEtab','read:parametrageScolarite:Type','read:parametrageScolarite:Categorie']],
    //denormalizationContext: ['groups'=>['write:bibliotheque']],
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
    ]
)]
class ParametrageFraisScolariteEtab extends ParametrageFraisScolarite
{
    #[ORM\ManyToMany(targetEntity: TypeBourse::class, mappedBy: 'parametrageFraisScolariteEtabs')]
    #[Groups(['read:parametrageScolariteEtab'])]
    private Collection $typeBourses;

    public function __construct()
    {
        parent::__construct();
        $this->typeBourses = new ArrayCollection();
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
            $typeBourse->addParametrageFraisScolariteEtab($this);
        }

        return $this;
    }

    public function removeTypeBourse(TypeBourse $typeBourse): self
    {
        if ($this->typeBourses->removeElement($typeBourse)) {
            $typeBourse->removeParametrageFraisScolariteEtab($this);
        }

        return $this;
    }

}
