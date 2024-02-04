<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\TypeDocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TypeDocumentRepository::class)]
#[ApiResource]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'topic'=>'exact',
        'institut'=>'exact',
    ]
)]
class TypeDocument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:bibliotheque:typeDocument'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:bibliotheque:typeDocument'])]
    private ?string $intitule = null;

    #[ORM\ManyToOne(inversedBy: 'typeDocuments')]
    private ?Topic $topic = null;

    #[ORM\ManyToOne(inversedBy: 'typeDocuments')]
    private ?Institut $institut = null;

    #[ORM\OneToMany(mappedBy: 'typeDocument', targetEntity: Bibliotheque::class)]
    private Collection $bibliotheques;

    public function __construct()
    {
        $this->bibliotheques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTopic(): ?Topic
    {
        return $this->topic;
    }

    public function setTopic(?Topic $topic): self
    {
        $this->topic = $topic;

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

    /**
     * @return Collection<int, Bibliotheque>
     */
    public function getBibliotheques(): Collection
    {
        return $this->bibliotheques;
    }

    public function addBibliotheque(Bibliotheque $bibliotheque): self
    {
        if (!$this->bibliotheques->contains($bibliotheque)) {
            $this->bibliotheques->add($bibliotheque);
            $bibliotheque->setTypeDocument($this);
        }

        return $this;
    }

    public function removeBibliotheque(Bibliotheque $bibliotheque): self
    {
        if ($this->bibliotheques->removeElement($bibliotheque)) {
            // set the owning side to null (unless already changed)
            if ($bibliotheque->getTypeDocument() === $this) {
                $bibliotheque->setTypeDocument(null);
            }
        }

        return $this;
    }
}
