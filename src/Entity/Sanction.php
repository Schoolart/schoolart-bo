<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\SanctionController;
use App\Entity\Etudiant;
use App\Entity\TypeSanction;
use App\Repository\SanctionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\File;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable()]
#[ORM\Entity(repositoryClass: SanctionRepository::class)]
#[ApiResource (
    normalizationContext:["groups"=>["read:sanction","read:sanction:etudiant","read:typeSanction"]],
     itemOperations: [
    "get",
    'put',
    'patch',
    'image'=>[
        'method' => 'POST',
        'deserialize' => false,
        'path' => '/sanction/{id}',
        'controller' => SanctionController::class
        ]
    ]
)]
#[ApiFilter(
    SearchFilter::class,
    properties:[
        "etudiant"=>'exact',
        "typeSanction"=>"exact"
    ]
)]

class Sanction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read:sanction"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(["read:sanction"])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["read:sanction"])]
    private ?string $message = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filename = null;

    #[ORM\ManyToOne(inversedBy: 'sanctions')]
    #[Groups(["read:sanction"])]
    private ?TypeSanction $typeSanction = null;

    #[ORM\ManyToOne(inversedBy: 'sanctions')]
    #[Groups(["read:sanction"])]
    private ?Etudiant $etudiant = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;


    #[Vich\UploadableField(mapping:"sanction_file", fileNameProperty:"filename")]
    private ?File $file = null;

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $img
     */
    public function setFile(?File $file = null): void
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
    #[Groups(['read:institut'])]
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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
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

    public function getTypeSanction(): ?TypeSanction
    {
        return $this->typeSanction;
    }

    public function setTypeSanction(?TypeSanction $typeSanction): self
    {
        $this->typeSanction = $typeSanction;

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

}
