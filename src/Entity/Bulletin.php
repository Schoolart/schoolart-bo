<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\BulletinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
#[Vich\Uploadable()]
#[ORM\Entity(repositoryClass: BulletinRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:bulletin']],
    denormalizationContext: ['groups'=>['read:bulletin']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'periode'=>'exact',
        'classe'=>'exact',
        'etudiant'=>'exact'
    ]
)]
class Bulletin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:bulletin'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:bulletin'])]
    private ?string $fileName = null;

    #[ORM\ManyToOne(inversedBy: 'bulletins')]
    #[Groups(['read:bulletin'])]
    private ?Periode $periode = null;

    #[ORM\ManyToOne(inversedBy: 'bulletins')]
    #[Groups(['read:bulletin'])]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'bulletins')]
    #[Groups(['read:bulletin'])]
    private ?Classe $classe = null;

    #[ORM\Column(length: 2, nullable: true)]
    #[Groups(['read:bulletin'])]
    private ?string $langue = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:bulletin'])]
    private ?bool $admis = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:bulletin'])]
    private ?bool $nonAdmis = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:bulletin'])]
    private ?bool $conditionnel = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['read:bulletin'])]
    private ?string $file = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getPeriode(): ?Periode
    {
        return $this->periode;
    }

    public function setPeriode(?Periode $periode): self
    {
        $this->periode = $periode;

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

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(?string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function isAdmis(): ?bool
    {
        return $this->admis;
    }

    public function setAdmis(?bool $admis): self
    {
        $this->admis = $admis;

        return $this;
    }

    public function isNonAdmis(): ?bool
    {
        return $this->nonAdmis;
    }

    public function setNonAdmis(?bool $nonAdmis): self
    {
        $this->nonAdmis = $nonAdmis;

        return $this;
    }

    public function isConditionnel(): ?bool
    {
        return $this->conditionnel;
    }

    public function setConditionnel(?bool $conditionnel): self
    {
        $this->conditionnel = $conditionnel;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }





    /**
     * Get the value of updatedAt
     *
     * @return ?\DateTimeInterface
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param ?\DateTimeInterface $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}
