<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\ParametrageFraisScolariteController;
use App\Repository\ParametrageFraisScolariteEtudRepository;
use App\Repository\SoldeEtudiantRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ParametrageFraisScolariteEtudRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:parametrageScolarite','read:parametrageScolariteEtud','read:parametrageScolarite:Categorie','read:parametrageScolarite:etud','read:parametrageScolarite:classe']],
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
        'classe'=>'exact',
        'etudiant'=>"exact",
    ]
)]
class ParametrageFraisScolariteEtud extends ParametrageFraisScolarite
{
    #[ORM\ManyToOne(inversedBy: 'parametrageFraisScolariteEtuds')]
    #[Groups(['read:parametrageScolariteEtud'])]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'parametrageFraisScolariteEtuds')]
    #[Groups(['read:parametrageScolariteEtud'])]
    private ?Classe $classe = null;

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
}
