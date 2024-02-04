<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\SousDroitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SousDroitRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:droit:sousDroit']],
)]
#[ApiFilter(
    SearchFilter::class,
    properties:[
        'droit'=>'exact',
        'intitule'=>'exact',
    ]
)]
class SousDroit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("read:droit:sousDroit")]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups("read:droit:sousDroit")]
    private ?bool $lecture = null;

    #[ORM\Column(nullable: true)]
    #[Groups("read:droit:sousDroit")]
    private ?bool $modif = null;

    #[ORM\Column(nullable: true)]
    #[Groups("read:droit:sousDroit")]
    private ?bool $ajout = null;

    #[ORM\Column(nullable: true)]
    #[Groups("read:droit:sousDroit")]
    private ?bool $suppression = null;

    #[ORM\ManyToOne(inversedBy: 'sousDroits')]
    private ?Droit $droit = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("read:droit:sousDroit")]
    private ?string $intitule = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isLecture(): ?bool
    {
        return $this->lecture;
    }

    public function setLecture(?bool $lecture): self
    {
        $this->lecture = $lecture;

        return $this;
    }

    public function isModif(): ?bool
    {
        return $this->modif;
    }

    public function setModif(?bool $modif): self
    {
        $this->modif = $modif;

        return $this;
    }

    public function isAjout(): ?bool
    {
        return $this->ajout;
    }

    public function setAjout(?bool $ajout): self
    {
        $this->ajout = $ajout;

        return $this;
    }

    public function isSuppression(): ?bool
    {
        return $this->suppression;
    }

    public function setSuppression(?bool $suppression): self
    {
        $this->suppression = $suppression;

        return $this;
    }

    public function getDroit(): ?Droit
    {
        return $this->droit;
    }

    public function setDroit(?Droit $droit): self
    {
        $this->droit = $droit;

        return $this;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(?string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }
    public function clearId(){
        $this->id=null;
        $this->droit=null;
        return $this;
    }
}
