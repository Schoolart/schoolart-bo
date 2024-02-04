<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\DroitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DroitRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:droit','read:droit:sousDroit']],
    denormalizationContext: ['groups'=>['write:droit']]
)]
#[ApiFilter(
    SearchFilter::class,
    properties:[
        'profile'=>'exact',
        'intitule'=>'exact'
]
)]
class Droit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read:droit","write:droit"])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["read:droit","write:droit"])]
    private ?bool $lecture = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["read:droit","write:droit"])]
    private ?bool $ajout = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["read:droit","write:droit"])]
    private ?bool $modif = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["read:droit","write:droit"])]
    private ?bool $suppression = null;

    #[ORM\OneToMany(mappedBy: 'droit', targetEntity: SousDroit::class , cascade: ['persist', 'remove'])]
    #[Groups(["read:droit","write:droit"])]
    private Collection $sousDroits;

    #[ORM\ManyToOne(inversedBy: 'droits')]
    #[Groups(["write:droit"])]
    private ?Profile $profile = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["read:droit","write:droit"])]
    private ?string $intitule = null;





    public function __construct()
    {
        $this->sousDroits = new ArrayCollection();
    }

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

    public function isAjout(): ?bool
    {
        return $this->ajout;
    }

    public function setAjout(?bool $ajout): self
    {
        $this->ajout = $ajout;

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

    public function isSuppression(): ?bool
    {
        return $this->suppression;
    }

    public function setSuppression(?bool $suppression): self
    {
        $this->suppression = $suppression;

        return $this;
    }

    /**
     * @return Collection<int, SousDroit>
     */
    public function getSousDroits(): Collection
    {
        return $this->sousDroits;
    }

    public function addSousDroit(SousDroit $sousDroit): self
    {
        if (!$this->sousDroits->contains($sousDroit)) {
            $this->sousDroits->add($sousDroit);
            $sousDroit->setDroit($this);
        }

        return $this;
    }

    public function removeSousDroit(SousDroit $sousDroit): self
    {
        if ($this->sousDroits->removeElement($sousDroit)) {
            // set the owning side to null (unless already changed)
            if ($sousDroit->getDroit() === $this) {
                $sousDroit->setDroit(null);
            }
        }

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

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
        $this->sousDroits=  new ArrayCollection();
        $this->profile=null;
        return $this;
    }



}
