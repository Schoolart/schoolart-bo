<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EtablissementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EtablissementRepository::class)]
#[ApiResource]
class Etablissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:institut:etablissement'])]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'etablissement', targetEntity: Institut::class)]
    private Collection $instituts;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:institut:etablissement'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $devise = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fuseauHoraire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siteWeb = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fax = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pays = null;

    #[ORM\OneToMany(mappedBy: 'etablissement', targetEntity: User::class)]
    private Collection $users;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sidenav = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $colorPrimary = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $colorPrimaryHover = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $colorSidenavLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $colorPlus = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $colorAvoir = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $colorText = null;

    #[ORM\OneToMany(mappedBy: 'etablissement', targetEntity: Profile::class)]
    private Collection $profiles;

    #[ORM\OneToMany(mappedBy: 'etablissement', targetEntity: AnneeAcademic::class)]
    private Collection $anneeAcademics;

    #[ORM\OneToMany(mappedBy: 'etablissement', targetEntity: Sponsor::class)]
    private Collection $Sponsors;

    public function __construct()
    {
        $this->instituts = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->profiles = new ArrayCollection();
        $this->anneeAcademics = new ArrayCollection();
        $this->Sponsors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Institut>
     */
    public function getInstituts(): Collection
    {
        return $this->instituts;
    }

    public function addInstitut(Institut $institut): self
    {
        if (!$this->instituts->contains($institut)) {
            $this->instituts->add($institut);
            $institut->setEtablissement($this);
        }

        return $this;
    }

    public function removeInstitut(Institut $institut): self
    {
        if ($this->instituts->removeElement($institut)) {
            // set the owning side to null (unless already changed)
            if ($institut->getEtablissement() === $this) {
                $institut->setEtablissement(null);
            }
        }

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

    public function getDevise(): ?string
    {
        return $this->devise;
    }

    public function setDevise(?string $devise): self
    {
        $this->devise = $devise;

        return $this;
    }

    public function getFuseauHoraire(): ?string
    {
        return $this->fuseauHoraire;
    }

    public function setFuseauHoraire(?string $fuseauHoraire): self
    {
        $this->fuseauHoraire = $fuseauHoraire;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(?string $siteWeb): self
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getAdresse1(): ?string
    {
        return $this->adresse1;
    }

    public function setAdresse1(?string $adresse1): self
    {
        $this->adresse1 = $adresse1;

        return $this;
    }

    public function getAdresse2(): ?string
    {
        return $this->adresse2;
    }

    public function setAdresse2(?string $adresse2): self
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setEtablissement($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getEtablissement() === $this) {
                $user->setEtablissement(null);
            }
        }

        return $this;
    }

    public function getSidenav(): ?string
    {
        return $this->sidenav;
    }

    public function setSidenav(?string $sidenav): self
    {
        $this->sidenav = $sidenav;

        return $this;
    }

    public function getColorPrimary(): ?string
    {
        return $this->colorPrimary;
    }

    public function setColorPrimary(?string $colorPrimary): self
    {
        $this->colorPrimary = $colorPrimary;

        return $this;
    }

    public function getColorPrimaryHover(): ?string
    {
        return $this->colorPrimaryHover;
    }

    public function setColorPrimaryHover(?string $colorPrimaryHover): self
    {
        $this->colorPrimaryHover = $colorPrimaryHover;

        return $this;
    }

    public function getColorSidenavLink(): ?string
    {
        return $this->colorSidenavLink;
    }

    public function setColorSidenavLink(?string $colorSidenavLink): self
    {
        $this->colorSidenavLink = $colorSidenavLink;

        return $this;
    }

    public function getColorPlus(): ?string
    {
        return $this->colorPlus;
    }

    public function setColorPlus(?string $colorPlus): self
    {
        $this->colorPlus = $colorPlus;

        return $this;
    }

    public function getColorAvoir(): ?string
    {
        return $this->colorAvoir;
    }

    public function setColorAvoir(?string $colorAvoir): self
    {
        $this->colorAvoir = $colorAvoir;

        return $this;
    }

    public function getColorText(): ?string
    {
        return $this->colorText;
    }

    public function setColorText(?string $colorText): self
    {
        $this->colorText = $colorText;

        return $this;
    }

    /**
     * @return Collection<int, Profile>
     */
    public function getProfiles(): Collection
    {
        return $this->profiles;
    }

    public function addProfile(Profile $profile): self
    {
        if (!$this->profiles->contains($profile)) {
            $this->profiles->add($profile);
            $profile->setEtablissement($this);
        }

        return $this;
    }

    public function removeProfile(Profile $profile): self
    {
        if ($this->profiles->removeElement($profile)) {
            // set the owning side to null (unless already changed)
            if ($profile->getEtablissement() === $this) {
                $profile->setEtablissement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AnneeAcademic>
     */
    public function getAnneeAcademics(): Collection
    {
        return $this->anneeAcademics;
    }

    public function addAnneeAcademic(AnneeAcademic $anneeAcademic): self
    {
        if (!$this->anneeAcademics->contains($anneeAcademic)) {
            $this->anneeAcademics->add($anneeAcademic);
            $anneeAcademic->setEtablissement($this);
        }

        return $this;
    }

    public function removeAnneeAcademic(AnneeAcademic $anneeAcademic): self
    {
        if ($this->anneeAcademics->removeElement($anneeAcademic)) {
            // set the owning side to null (unless already changed)
            if ($anneeAcademic->getEtablissement() === $this) {
                $anneeAcademic->setEtablissement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sponsor>
     */
    public function getSponsors(): Collection
    {
        return $this->Sponsors;
    }

    public function addSponsor(Sponsor $sponsor): self
    {
        if (!$this->Sponsors->contains($sponsor)) {
            $this->Sponsors->add($sponsor);
            $sponsor->setEtablissement($this);
        }

        return $this;
    }

    public function removeSponsor(Sponsor $sponsor): self
    {
        if ($this->Sponsors->removeElement($sponsor)) {
            // set the owning side to null (unless already changed)
            if ($sponsor->getEtablissement() === $this) {
                $sponsor->setEtablissement(null);
            }
        }

        return $this;
    }
}
