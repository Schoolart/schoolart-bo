<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\AdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:user','read:user:profile','read:user:institut','read:user:institut:anneeAcademic','read:user:institut:anneeAcademic:niveau']],
    denormalizationContext: ['groups'=>['write:user']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'profile'=>'exact',
        'instituts'=>'exact',
        'etablissement'=>"exact"
    ]
)]
class Admin extends User
{
    #[ORM\OneToMany(mappedBy: 'userCreate', targetEntity: Paiement::class)]
    private Collection $paiements;

    #[ORM\OneToMany(mappedBy: 'userUpdate', targetEntity: Paiement::class)]
    private Collection $paiementUpdates;

    #[ORM\OneToMany(mappedBy: 'userContratCreate', targetEntity: Contrat::class)]
    private Collection $contrats;

    #[ORM\OneToMany(mappedBy: 'userHonoraireCreate', targetEntity: Honoraire::class)]
    private Collection $honoraires;

    #[ORM\OneToMany(mappedBy: 'userFicheCreate', targetEntity: FicheIdentification::class)]
    private Collection $ficheIdentifications;

    public function __construct()
    {
        parent::__construct();
        $this->paiements = new ArrayCollection();
        $this->paiementUpdates = new ArrayCollection();
        $this->contrats = new ArrayCollection();
        $this->honoraires = new ArrayCollection();
        $this->ficheIdentifications = new ArrayCollection();
    }


    /**
     * @return Collection<int, Paiement>
     */
    public function getPaiementUpdates(): Collection
    {
        return $this->paiementUpdates;
    }

    public function addPaiementUpdate(Paiement $paiementUpdate): self
    {
        if (!$this->paiementUpdates->contains($paiementUpdate)) {
            $this->paiementUpdates->add($paiementUpdate);
            $paiementUpdate->setUserUpdate($this);
        }

        return $this;
    }

    public function removePaiementUpdate(Paiement $paiementUpdate): self
    {
        if ($this->paiementUpdates->removeElement($paiementUpdate)) {
            // set the owning side to null (unless already changed)
            if ($paiementUpdate->getUserUpdate() === $this) {
                $paiementUpdate->setUserUpdate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contrat>
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }

    public function addContrat(Contrat $contrat): self
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats->add($contrat);
            $contrat->setUserContratCreate($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): self
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getUserContratCreate() === $this) {
                $contrat->setUserContratCreate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Honoraire>
     */
    public function getHonoraires(): Collection
    {
        return $this->honoraires;
    }

    public function addHonoraire(Honoraire $honoraire): self
    {
        if (!$this->honoraires->contains($honoraire)) {
            $this->honoraires->add($honoraire);
            $honoraire->setUserHonoraireCreate($this);
        }

        return $this;
    }

    public function removeHonoraire(Honoraire $honoraire): self
    {
        if ($this->honoraires->removeElement($honoraire)) {
            // set the owning side to null (unless already changed)
            if ($honoraire->getUserHonoraireCreate() === $this) {
                $honoraire->setUserHonoraireCreate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FicheIdentification>
     */
    public function getFicheIdentifications(): Collection
    {
        return $this->ficheIdentifications;
    }

    public function addFicheIdentification(FicheIdentification $ficheIdentification): self
    {
        if (!$this->ficheIdentifications->contains($ficheIdentification)) {
            $this->ficheIdentifications->add($ficheIdentification);
            $ficheIdentification->setUserFicheCreate($this);
        }

        return $this;
    }

    public function removeFicheIdentification(FicheIdentification $ficheIdentification): self
    {
        if ($this->ficheIdentifications->removeElement($ficheIdentification)) {
            // set the owning side to null (unless already changed)
            if ($ficheIdentification->getUserFicheCreate() === $this) {
                $ficheIdentification->setUserFicheCreate(null);
            }
        }

        return $this;
    }
}
