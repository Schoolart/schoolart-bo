<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\TypeBourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TypeBourseRepository::class)]
#[ApiResource(
    normalizationContext:  ['groups'=>['read:typeBourse','read:typeBourse:sponsor']]
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'institut'=>'exact',
        'sponsor'=>'exact'
    ]
)]
class TypeBourse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:typeBourse','read:etudiant:bourse:typeBourse','read:parametrageScolarite:Type'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:typeBourse','read:etudiant:bourse:typeBourse','read:parametrageScolarite:Type'])]
    private ?string $libelle = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:typeBourse'])]
    private ?float $pourcentage = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:typeBourse'])]
    private ?string $detail = null;

    #[ORM\OneToMany(mappedBy: 'typeBourse', targetEntity: Bourse::class)]
    private Collection $bourses;



    #[ORM\ManyToOne(inversedBy: 'typeBourses')]
    private ?Institut $institut = null;

    #[ORM\ManyToMany(targetEntity: ParametrageFraisScolariteEtab::class, inversedBy: 'typeBourses')]
    private Collection $parametrageFraisScolariteEtabs;

    #[ORM\ManyToMany(targetEntity: ParametrageFraisScolariteNiv::class, inversedBy: 'typeBourses')]
    private Collection $parametrageFraisScolariteNivs;

    #[ORM\ManyToOne(inversedBy: 'typeBourses')]
    #[Groups(['read:typeBourse'])]
    private ?Sponsor $sponsor = null;


    public function __construct()
    {
        $this->bourses = new ArrayCollection();
        $this->parametrageFraisScolariteEtabs = new ArrayCollection();
        $this->parametrageFraisScolariteNivs = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPourcentage(): ?float
    {
        return $this->pourcentage;
    }

    public function setPourcentage(?float $pourcentage): self
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(?string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * @return Collection<int, Bourse>
     */
    public function getBourses(): Collection
    {
        return $this->bourses;
    }

    public function addBourse(Bourse $bourse): self
    {
        if (!$this->bourses->contains($bourse)) {
            $this->bourses->add($bourse);
            $bourse->setTypeBourse($this);
        }

        return $this;
    }

    public function removeBourse(Bourse $bourse): self
    {
        if ($this->bourses->removeElement($bourse)) {
            // set the owning side to null (unless already changed)
            if ($bourse->getTypeBourse() === $this) {
                $bourse->setTypeBourse(null);
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
     * @return Collection<int, ParametrageFraisScolariteEtab>
     */
    public function getParametrageFraisScolariteEtabs(): Collection
    {
        return $this->parametrageFraisScolariteEtabs;
    }

    public function addParametrageFraisScolariteEtab(ParametrageFraisScolariteEtab $parametrageFraisScolariteEtab): self
    {
        if (!$this->parametrageFraisScolariteEtabs->contains($parametrageFraisScolariteEtab)) {
            $this->parametrageFraisScolariteEtabs->add($parametrageFraisScolariteEtab);
        }

        return $this;
    }

    public function removeParametrageFraisScolariteEtab(ParametrageFraisScolariteEtab $parametrageFraisScolariteEtab): self
    {
        $this->parametrageFraisScolariteEtabs->removeElement($parametrageFraisScolariteEtab);

        return $this;
    }

    /**
     * @return Collection<int, ParametrageFraisScolariteNiv>
     */
    public function getParametrageFraisScolariteNivs(): Collection
    {
        return $this->parametrageFraisScolariteNivs;
    }

    public function addParametrageFraisScolariteNiv(ParametrageFraisScolariteNiv $parametrageFraisScolariteNiv): self
    {
        if (!$this->parametrageFraisScolariteNivs->contains($parametrageFraisScolariteNiv)) {
            $this->parametrageFraisScolariteNivs->add($parametrageFraisScolariteNiv);
        }

        return $this;
    }

    public function removeParametrageFraisScolariteNiv(ParametrageFraisScolariteNiv $parametrageFraisScolariteNiv): self
    {
        $this->parametrageFraisScolariteNivs->removeElement($parametrageFraisScolariteNiv);

        return $this;
    }

    public function getSponsor(): ?Sponsor
    {
        return $this->sponsor;
    }

    public function setSponsor(?Sponsor $sponsor): self
    {
        $this->sponsor = $sponsor;

        return $this;
    }
}
