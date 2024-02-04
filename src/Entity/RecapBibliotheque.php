<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\BibliothequeController;
use App\Repository\RecapBibliothequeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RecapBibliothequeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:recapbibliotheque','read:bibliotheque:etudiant','read:bibliotheque:user','read:bibliotheque']],
    denormalizationContext: ['groups'=>['write:recapbibliotheque']],
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'classe'=>'exact',
        'etudiant'=>'exact',
        'anneeAcademic'=>'exact'
    ]
)]
class RecapBibliotheque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:recapbibliotheque','write:recapbibliotheque'])]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'recapBibliotheque', targetEntity: Bibliotheque::class)]
    #[Groups(['read:recapbibliotheque'])]
    private Collection $bibliotheques;

    #[ORM\ManyToOne(inversedBy: 'recapsbibliotheques')]
    #[Groups(['read:recapbibliotheque','write:recapbibliotheque'])]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'recapsbibliotheques')]
    #[Groups(['read:recapbibliotheque','write:recapbibliotheque'])]
    private ?Classe $classe = null;

    #[ORM\ManyToOne(inversedBy: 'recapBibliotheques')]
    #[Groups(['write:recapbibliotheque'])]
    private ?AnneeAcademic $anneeAcademic = null;

    public function __construct()
    {
        $this->bibliotheques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $bibliotheque->setRecapBibliotheque($this);
        }

        return $this;
    }

    public function removeBibliotheque(Bibliotheque $bibliotheque): self
    {
        if ($this->bibliotheques->removeElement($bibliotheque)) {
            // set the owning side to null (unless already changed)
            if ($bibliotheque->getRecapBibliotheque() === $this) {
                $bibliotheque->setRecapBibliotheque(null);
            }
        }

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
