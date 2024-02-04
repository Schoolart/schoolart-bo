<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\BibliothequeController;
use App\Controller\InstitutController;
use App\Repository\BibliothequeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
#[ORM\Entity(repositoryClass: BibliothequeRepository::class)]
#[Vich\Uploadable()]
#[ApiResource(
    normalizationContext: ['groups'=>['read:bibliotheque','read:bibliotheque:topic','read:bibliotheque:typeDocument','read:bibliotheque:etudiant','read:bibliotheque:user']],
    denormalizationContext: ['groups'=>['write:bibliotheque']],
    itemOperations: [
        "get",
        'put',
        'patch',
        'delete',
        'file'=>[
            'method' => 'POST',
            'deserialize' => false,
            'path' => '/bibliotheque/{id}/file',
            'controller' => BibliothequeController::class
        ]
    ]
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'classe'=>'exact',
        'etudiant'=>'exact',
        'topic'=>'exact',
        'typeDocument'=>'exact',
        'institut'=>'exact',
        'anneeAcademic'=>'exact'
    ]
)]
class Bibliotheque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:bibliotheque','write:bibliotheque'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:bibliotheque','write:bibliotheque'])]
    private ?string $filename = null;

    #[ORM\ManyToOne(inversedBy: 'bibliotheques')]
    #[Groups(['read:bibliotheque','write:bibliotheque'])]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'bibliotheques')]
    #[Groups(['write:bibliotheque'])]
    private ?Classe $classe = null;

    #[Groups(['read:bibliotheque','write:bibliotheque'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;


    #[Groups(['read:bibliotheque'])]
    private  $fileUrl;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:bibliotheque','write:bibliotheque'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:bibliotheque','write:bibliotheque'])]
    private ?string $resume = null;
    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }


    #[Vich\UploadableField(mapping:"bibliotheque_file", fileNameProperty:"filename")]
    private ?File $file = null;

    #[ORM\ManyToOne(inversedBy: 'bibliotheques')]
    #[Groups(['write:bibliotheque'])]
    private ?RecapBibliotheque $recapBibliotheque = null;

    #[ORM\ManyToOne(inversedBy: 'bibliotheques')]
    #[Groups(['read:bibliotheque','write:bibliotheque'])]
    private ?Topic $topic = null;

    #[ORM\ManyToOne(inversedBy: 'bibliotheques')]
    #[Groups(['read:bibliotheque','write:bibliotheque'])]
    private ?TypeDocument $typeDocument = null;

    #[ORM\ManyToOne(inversedBy: 'bibliotheques')]
    #[Groups(['write:bibliotheque'])]
    private ?Institut $institut = null;

    #[ORM\ManyToOne(inversedBy: 'bibliotheques')]
    #[Groups(['write:bibliotheque'])]
    private ?AnneeAcademic $anneeAcademic = null;

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $file
     */
    public function setFile(?File $file): void
    {
        $this->file = $file;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($file) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

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
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

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


    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getRecapBibliotheque(): ?RecapBibliotheque
    {
        return $this->recapBibliotheque;
    }

    public function setRecapBibliotheque(?RecapBibliotheque $recapBibliotheque): self
    {
        $this->recapBibliotheque = $recapBibliotheque;

        return $this;
    }

    public function getTopic(): ?Topic
    {
        return $this->topic;
    }

    public function setTopic(?Topic $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    public function getTypeDocument(): ?TypeDocument
    {
        return $this->typeDocument;
    }

    public function setTypeDocument(?TypeDocument $typeDocument): self
    {
        $this->typeDocument = $typeDocument;

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
}
