<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GroupeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:groupe','read:groupe:etu']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'anneeAcademic'=>'exact',
        'institut'=>'exact',
        'etudiants'=>'exact'
    ]
)]
class Groupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:groupe','read:soutenance:groupe'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:groupe','read:soutenance:groupe'])]
    private ?string $intitule = null;

    #[ORM\ManyToMany(targetEntity: Etudiant::class, inversedBy: 'groupes')]
    #[Groups(['read:groupe'])]
    private Collection $etudiants;

    #[ORM\ManyToOne(inversedBy: 'groupes')]
    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\ManyToOne(inversedBy: 'groupesChef')]
    #[Groups(['read:groupe','read:soutenance:groupe'])]
    private ?Etudiant $chefGroupe = null;

    #[ORM\ManyToOne(inversedBy: 'groupes')]
    private ?Institut $institut = null;

    #[ORM\ManyToOne(inversedBy: 'groupes')]
    #[Groups(['read:groupe','read:soutenance:groupe'])]
    private ?Professeur $professeur = null;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: Encadrement::class)]
    private Collection $encadrements;


    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
        $this->encadrements = new ArrayCollection();
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
     * @return Collection<int, Etudiant>
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants->add($etudiant);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        $this->etudiants->removeElement($etudiant);

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

    public function getChefGroupe(): ?Etudiant
    {
        return $this->chefGroupe;
    }

    public function setChefGroupe(?Etudiant $chefGroupe): self
    {
        $this->chefGroupe = $chefGroupe;

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

    public function getProfesseur(): ?Professeur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeur $professeur): self
    {
        $this->professeur = $professeur;

        return $this;
    }

    /**
     * @return Collection<int, Encadrement>
     */
    public function getEncadrements(): Collection
    {
        return $this->encadrements;
    }

    public function addEncadrement(Encadrement $encadrement): self
    {
        if (!$this->encadrements->contains($encadrement)) {
            $this->encadrements->add($encadrement);
            $encadrement->setGroupe($this);
        }

        return $this;
    }

    public function removeEncadrement(Encadrement $encadrement): self
    {
        if ($this->encadrements->removeElement($encadrement)) {
            // set the owning side to null (unless already changed)
            if ($encadrement->getGroupe() === $this) {
                $encadrement->setGroupe(null);
            }
        }

        return $this;
    }

}
