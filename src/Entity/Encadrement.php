<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\EncadrementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EncadrementRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:encadrement','read:groupe','read:groupe:etu']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'anneeAcademic'=>'exact',
        'institut'=>'exact',

    ]
)]
class Encadrement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:encadrement'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['read:encadrement'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'encadrements')]
    #[Groups(['read:encadrement'])]
    private ?Groupe $groupe = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['read:encadrement'])]
    private ?string $objet = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['read:encadrement'])]
    private ?string $observation = null;

    #[ORM\ManyToOne(inversedBy: 'encadrements')]
    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\ManyToOne(inversedBy: 'encadrements')]
    private ?Institut $institut = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(?string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

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
