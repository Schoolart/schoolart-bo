<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\TopicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TopicRepository::class)]
#[ApiResource]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'institut'=>'exact',
    ]
)]
class Topic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:bibliotheque:topic'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:bibliotheque:topic'])]
    private ?string $intitule = null;

    #[ORM\OneToMany(mappedBy: 'topic', targetEntity: TypeDocument::class)]
    private Collection $typeDocuments;

    #[ORM\ManyToOne(inversedBy: 'topics')]
    private ?Institut $institut = null;

    #[ORM\OneToMany(mappedBy: 'topic', targetEntity: Bibliotheque::class)]
    private Collection $bibliotheques;

    public function __construct()
    {
        $this->typeDocuments = new ArrayCollection();
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

    /**
     * @return Collection<int, TypeDocument>
     */
    public function getTypeDocuments(): Collection
    {
        return $this->typeDocuments;
    }

    public function addTypeDocument(TypeDocument $typeDocument): self
    {
        if (!$this->typeDocuments->contains($typeDocument)) {
            $this->typeDocuments->add($typeDocument);
            $typeDocument->setTopic($this);
        }

        return $this;
    }

    public function removeTypeDocument(TypeDocument $typeDocument): self
    {
        if ($this->typeDocuments->removeElement($typeDocument)) {
            // set the owning side to null (unless already changed)
            if ($typeDocument->getTopic() === $this) {
                $typeDocument->setTopic(null);
            }
        }

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
            $bibliotheque->setTopic($this);
        }

        return $this;
    }

    public function removeBibliotheque(Bibliotheque $bibliotheque): self
    {
        if ($this->bibliotheques->removeElement($bibliotheque)) {
            // set the owning side to null (unless already changed)
            if ($bibliotheque->getTopic() === $this) {
                $bibliotheque->setTopic(null);
            }
        }

        return $this;
    }
}
