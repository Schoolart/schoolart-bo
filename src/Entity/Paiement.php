<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\PaiementController;
use App\Repository\PaiementRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use App\Repository\SoldeEtudiantRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\ParametrageFraisScolariteController;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:parametrageScolarite','read:paiement','read:parametrageScolarite:etud','read:parametrageScolarite:Categorie']],
    denormalizationContext: ['groups'=>['read:parametrageScolarite','write:paiement']],
    collectionOperations:[
        'get',
        'post'=>[
            'controller' => PaiementController::class
        ],
        'historique'=>[
            'method'=>"GET",
            'path'=>"/paiements/historique",
            'normalization_context'=>[
                'groups'=>['read:parametrageScolarite','read:historique','read:paiement','read:parametrageScolarite:etud','read:parametrageScolarite:Categorie','read:etudiant','read:user','read:etudiant:classe',
                    'read:etudiant:bourse','read:etudiant:bourse:typeBourse']
            ],

        ]
    ],
    itemOperations: [
        'get',
        'put'=>[
            'controller' => PaiementController::class
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
)]#[ApiFilter(
    DateFilter::class,
    properties: [
        'date'
    ]
)]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:paiement','write:paiement'])]
    private ?int $id = null;
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:paiement','write:paiement'])]
    private ?string $modePaiement = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:paiement','write:paiement'])]
    private ?string $numeroCheque = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['write:paiement'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['write:paiement'])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:paiement','write:paiement'])]
    private ?string $canal = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    #[Groups(['write:paiement'])]
    private ?Classe $classe = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    #[Groups(['write:paiement','read:historique'])]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    #[Groups(['read:paiement','write:paiement'])]
    private ?Admin $userCreate = null;

    #[ORM\ManyToOne(inversedBy: 'paiementUpdates')]
    #[Groups(['read:paiement','write:paiement'])]
    private ?Admin $userUpdate = null;

    #[ORM\OneToOne(inversedBy: 'paiement', cascade: ['persist', 'remove'])]
    private ?Recu $recu = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:paiement'])]
    private ?int $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:paiement','write:paiement'])]
    private ?string $libelle = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:paiement'])]
    private ?int $montant = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['read:paiement','write:paiement'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    #[Groups(['write:paiement'])]
    private ?Institut $institut = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    #[Groups(['write:paiement'])]
    private ?AnneeAcademic $anneeAcademic = null;


    #[Groups(['write:paiement'])]
    private ?int $montantTemp = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    #[Groups(['read:paiement','write:paiement'])]
    private ?ParametrageFraisScolarite $parametrageFraisScolarite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModePaiement(): ?string
    {
        return $this->modePaiement;
    }

    public function setModePaiement(?string $modePaiement): self
    {
        $this->modePaiement = $modePaiement;
        $this->updatedAt = new \DateTime() ;

        return $this;
    }

    public function getNumeroCheque(): ?string
    {
        return $this->numeroCheque;

    }

    public function setNumeroCheque(?string $numeroCheque): self
    {
        $this->numeroCheque = $numeroCheque;
        $this->updatedAt = new \DateTime() ;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        $this->updatedAt = new \DateTime() ;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;

    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCanal(): ?string
    {
        return $this->canal;
    }

    public function setCanal(?string $canal): self
    {
        $this->canal = $canal;
        $this->updatedAt = new \DateTime() ;
        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;
        $this->updatedAt = new \DateTime() ;
        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;
        $this->updatedAt = new \DateTime() ;
        return $this;
    }

    public function getUserCreate(): ?Admin
    {
        return $this->userCreate;
    }

    public function setUserCreate(?Admin $userCreate): self
    {
        $this->userCreate = $userCreate;
        $this->updatedAt = new \DateTime() ;
        return $this;
    }

    public function getUserUpdate(): ?Admin
    {
        return $this->userUpdate;
    }

    public function setUserUpdate(?Admin $userUpdate): self
    {
        $this->userUpdate = $userUpdate;
        $this->updatedAt = new \DateTime() ;
        return $this;
    }

    public function getRecu(): ?Recu
    {
        return $this->recu;
    }

    public function setRecu(?Recu $recu): self
    {
        $this->recu = $recu;

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

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getAnneeAcademic(): ?AnneeAcademic
    {
        return $this->anneeAcademic;
    }

    public function setAnneeAcademic(?AnneeAcademic $anneeAcademic): self
    {
        $this->anneeAcademic = $anneeAcademic;

        return $this;
    }

    public function getMontantTemp(): ?int
    {
        return $this->montantTemp;
    }

    public function setMontantTemp(?int $montantTemp): self
    {
        $this->montantTemp = $montantTemp;

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

}
