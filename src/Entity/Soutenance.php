<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\InstitutController;
use App\Controller\SoutenanceController;
use App\Repository\SoutenanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
#[Vich\Uploadable()]
#[ORM\Entity(repositoryClass: SoutenanceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:soutenance','read:soutenance:groupe','read:soutenance:jury','read:groupe:etu']],
    itemOperations: [
        'get',
        'put',
        'patch',
        'file'=>[
            'method' => 'POST',
            'deserialize' => false,
            'path' => '/soutenances/{id}/file',
            'controller' => SoutenanceController::class
        ]
    ]

)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'anneeAcademic'=>'exact',
        'institut'=>'exact',
        'groupe'=>'exact',
        'jury'=>'exact'
    ]
)]
class Soutenance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:soutenance'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:soutenance'])]
    private ?string $file = null;

    #[ORM\ManyToOne(inversedBy: 'soutenances')]
    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:soutenance'])]
    private ?string $etat = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:soutenance'])]
    private ?string $commentaire = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups(['read:soutenance'])]
    private ?Groupe $groupe = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:soutenance'])]
    private ?string $sujet = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[Groups(['read:soutenance'])]
    private  $fileUrl;

    /**
     * @return mixed
     */
    public function getFileUrl()
    {
        return $this->fileUrl;
    }

    /**
     * @param mixed $fileUrl
     */
    public function setFileUrl($fileUrl): void
    {
        $this->fileUrl = $fileUrl;
    }
    #[Vich\UploadableField(mapping:"soutenance_file", fileNameProperty:"file")]
    private ?File $vichFile = null;

    #[ORM\ManyToOne(inversedBy: 'soutenances')]
    #[Groups(['read:soutenance'])]
    private ?Jury $jury = null;

    #[ORM\ManyToOne(inversedBy: 'soutenances')]
    private ?Institut $institut = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:soutenance'])]
    private ?float $note = null;

    /**
     * @return File|null
     */
    public function getVichFile(): ?File
    {
        return $this->vichFile;
    }

    /**
     * @param File|null $vichFile
     */
    public function setVichFile(?File $vichFile): void
    {
        $this->vichFile = $vichFile;
        if ($vichFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAnneeAcademic(): ?AnneeAcademic
    {
        return $this->anneeAcademic;
    }

    public function setAnneeAcademic(?AnneeAcademic $anneeAcademic): self
    {
        $this->anneeAcademic = $anneeAcademic;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

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

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(?string $sujet): self
    {
        $this->sujet = $sujet;

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

    public function getJury(): ?Jury
    {
        return $this->jury;
    }

    public function setJury(?Jury $jury): self
    {
        $this->jury = $jury;

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

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): self
    {
        $this->note = $note;

        return $this;
    }
}
