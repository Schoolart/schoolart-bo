<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\InstitutController;
use App\Repository\InstitutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: InstitutRepository::class)]
#[Vich\Uploadable()]
#[ApiResource(
    normalizationContext: ['groups'=>['read:institut','read:institut:etablissement']],
    denormalizationContext: ['groups'=>['write:institut']],
    itemOperations: [
    "get",
    'put',
    'patch',
    'image'=>[
        'method' => 'POST',
        'deserialize' => false,
        'path' => '/institut/{id}/image',
        'controller' => InstitutController::class
    ]
]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'etablissement'=>'exact',

    ]
)]

class Institut
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:institut','read:anneeAcademic:institut','read:user:institut',
        'read:zone:institut','read:professeur:institut','read:niveau:anneeAcademic:institut',
        'read:diplome:anneeAcademic:institut'])]
    private ?int $id = null;
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:institut','write:institut','read:anneeAcademic:institut','read:user:institut',
        'read:zone:institut','read:professeur:institut','read:niveau:anneeAcademic:institut',
        'read:diplome:anneeAcademic:institut',
])]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:institut','write:institut'])]
    private ?string $devise = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:institut','write:institut'])]
    private ?string $fuseauHoraire = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:institut','write:institut'])]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:institut','write:institut'])]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:institut','write:institut'])]
    private ?string $siteWeb = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:institut','write:institut'])]
    private ?string $fax = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:institut','write:institut'])]
    private ?string $adresse1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:institut','write:institut'])]
    private ?string $adresse2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:institut','write:institut'])]
    private ?string $codePostal = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:institut','write:institut'])]
    private ?string $ville = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:institut','write:institut'])]
    private ?string $pays = null;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: AnneeAcademic::class)]
    #[Groups(['read:institut','read:user:institut','read:professeur:institut','read:etudiant:institut'])]
    private Collection $anneeAcademics;

    #[ORM\ManyToOne(inversedBy: 'instituts')]
    #[Groups(['read:institut','write:institut'])]
    private ?Etablissement $etablissement = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'instituts')]
    #[Groups(['read:institut'])]
    private Collection $users;

    #[ORM\ManyToOne(inversedBy: 'instituts')]
    #[Groups(['read:institut','write:institut'])]
    private ?Zone $zone = null;


    #[ORM\OneToOne(inversedBy: 'institut', cascade: ['persist', 'remove'])]
    #[Groups(['read:institut'])]
    private ?Programme $programme = null;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: ParametrageInstitut::class)]
    private Collection $parametrages;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;


    #[Vich\UploadableField(mapping:"institut_logo", fileNameProperty:"logo")]
    private ?File $image = null;

    /**
     * @return File|null
     */
    public function getImage(): ?File
    {
        return $this->image;
    }

    /**
     * @param File|null $img
     */
    public function setImage(?File $img = null): void
    {
        $this->image = $img;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($img) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }
    #[Groups(['read:institut'])]
    private  $fileUrl;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: Topic::class)]
    private Collection $topics;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: TypeDocument::class)]
    private Collection $typeDocuments;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: Bibliotheque::class)]
    private Collection $bibliotheques;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: CategorieFraisScolarite::class)]
    private Collection $categorieFraisScolarites;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: TypeBourse::class)]
    private Collection $typeBourses;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: ParametrageFraisScolarite::class)]
    private Collection $parametrageFraisScolarites;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: SoldeEtudiant::class)]
    private Collection $soldes;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: Quitus::class)]
    private Collection $quitus;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: Paiement::class)]
    private Collection $paiements;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: Jury::class)]
    private Collection $juries;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: Groupe::class)]
    private Collection $groupes;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: Soutenance::class)]
    private Collection $soutenances;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: Planning::class)]
    private Collection $plannings;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: Encadrement::class)]
    private Collection $encadrements;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: Chronologie::class)]
    private Collection $chronologies;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: FicheIdentification::class)]
    private Collection $ficheIdentifications;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: Classe::class)]
    private Collection $classes;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: Honoraire::class)]
    private Collection $honoraires;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: Contrat::class)]
    private Collection $contrats;

    #[ORM\OneToMany(mappedBy: 'institut', targetEntity: HonoraireRecap::class)]
    private Collection $honoraireRecaps;



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





    public function __construct()
    {
        $this->anneeAcademics = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->parametrages = new ArrayCollection();
        $this->topics = new ArrayCollection();
        $this->typeDocuments = new ArrayCollection();
        $this->bibliotheques = new ArrayCollection();
        $this->categorieFraisScolarites = new ArrayCollection();
        $this->typeBourses = new ArrayCollection();
        $this->parametrageFraisScolarites = new ArrayCollection();
        $this->soldes = new ArrayCollection();
        $this->quitus = new ArrayCollection();
        $this->paiements = new ArrayCollection();
        $this->juries = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->soutenances = new ArrayCollection();
        $this->plannings = new ArrayCollection();
        $this->encadrements = new ArrayCollection();
        $this->chronologies = new ArrayCollection();
        $this->ficheIdentifications = new ArrayCollection();
        $this->classes = new ArrayCollection();
        $this->honoraires = new ArrayCollection();
        $this->contrats = new ArrayCollection();
        $this->honoraireRecaps = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
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
            $anneeAcademic->setInstitut($this);
        }

        return $this;
    }

    public function removeAnneeAcademic(AnneeAcademic $anneeAcademic): self
    {
        if ($this->anneeAcademics->removeElement($anneeAcademic)) {
            // set the owning side to null (unless already changed)
            if ($anneeAcademic->getInstitut() === $this) {
                $anneeAcademic->setInstitut(null);
            }
        }

        return $this;
    }

    public function getEtablissement(): ?Etablissement
    {
        return $this->etablissement;
    }

    public function setEtablissement(?Etablissement $etablissement): self
    {
        $this->etablissement = $etablissement;

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
            $user->addInstitut($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeInstitut($this);
        }

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }


    public function getProgramme(): ?Programme
    {
        return $this->programme;
    }

    public function setProgramme(?Programme $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    /**
     * @return Collection<int, ParametrageInstitut>
     */
    public function getParametrages(): Collection
    {
        return $this->parametrages;
    }

    public function addParametrage(ParametrageInstitut $parametrage): self
    {
        if (!$this->parametrages->contains($parametrage)) {
            $this->parametrages->add($parametrage);
            $parametrage->setInstitut($this);
        }

        return $this;
    }

    public function removeParametrage(ParametrageInstitut $parametrage): self
    {
        if ($this->parametrages->removeElement($parametrage)) {
            // set the owning side to null (unless already changed)
            if ($parametrage->getInstitut() === $this) {
                $parametrage->setInstitut(null);
            }
        }

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Topic>
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics->add($topic);
            $topic->setInstitut($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topics->removeElement($topic)) {
            // set the owning side to null (unless already changed)
            if ($topic->getInstitut() === $this) {
                $topic->setInstitut(null);
            }
        }

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
            $typeDocument->setInstitut($this);
        }

        return $this;
    }

    public function removeTypeDocument(TypeDocument $typeDocument): self
    {
        if ($this->typeDocuments->removeElement($typeDocument)) {
            // set the owning side to null (unless already changed)
            if ($typeDocument->getInstitut() === $this) {
                $typeDocument->setInstitut(null);
            }
        }

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
            $bibliotheque->setInstitut($this);
        }

        return $this;
    }

    public function removeBibliotheque(Bibliotheque $bibliotheque): self
    {
        if ($this->bibliotheques->removeElement($bibliotheque)) {
            // set the owning side to null (unless already changed)
            if ($bibliotheque->getInstitut() === $this) {
                $bibliotheque->setInstitut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CategorieFraisScolarite>
     */
    public function getCategorieFraisScolarites(): Collection
    {
        return $this->categorieFraisScolarites;
    }

    public function addCategorieFraisScolarite(CategorieFraisScolarite $categorieFraisScolarite): self
    {
        if (!$this->categorieFraisScolarites->contains($categorieFraisScolarite)) {
            $this->categorieFraisScolarites->add($categorieFraisScolarite);
            $categorieFraisScolarite->setInstitut($this);
        }

        return $this;
    }

    public function removeCategorieFraisScolarite(CategorieFraisScolarite $categorieFraisScolarite): self
    {
        if ($this->categorieFraisScolarites->removeElement($categorieFraisScolarite)) {
            // set the owning side to null (unless already changed)
            if ($categorieFraisScolarite->getInstitut() === $this) {
                $categorieFraisScolarite->setInstitut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TypeBourse>
     */
    public function getTypeBourses(): Collection
    {
        return $this->typeBourses;
    }

    public function addTypeBourse(TypeBourse $typeBourse): self
    {
        if (!$this->typeBourses->contains($typeBourse)) {
            $this->typeBourses->add($typeBourse);
            $typeBourse->setInstitut($this);
        }

        return $this;
    }

    public function removeTypeBourse(TypeBourse $typeBourse): self
    {
        if ($this->typeBourses->removeElement($typeBourse)) {
            // set the owning side to null (unless already changed)
            if ($typeBourse->getInstitut() === $this) {
                $typeBourse->setInstitut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ParametrageFraisScolarite>
     */
    public function getParametrageFraisScolarites(): Collection
    {
        return $this->parametrageFraisScolarites;
    }

    public function addParametrageFraisScolarite(ParametrageFraisScolarite $parametrageFraisScolarite): self
    {
        if (!$this->parametrageFraisScolarites->contains($parametrageFraisScolarite)) {
            $this->parametrageFraisScolarites->add($parametrageFraisScolarite);
            $parametrageFraisScolarite->setInstitut($this);
        }

        return $this;
    }

    public function removeParametrageFraisScolarite(ParametrageFraisScolarite $parametrageFraisScolarite): self
    {
        if ($this->parametrageFraisScolarites->removeElement($parametrageFraisScolarite)) {
            // set the owning side to null (unless already changed)
            if ($parametrageFraisScolarite->getInstitut() === $this) {
                $parametrageFraisScolarite->setInstitut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SoldeEtudiant>
     */
    public function getSoldes(): Collection
    {
        return $this->soldes;
    }

    public function addSolde(SoldeEtudiant $solde): self
    {
        if (!$this->soldes->contains($solde)) {
            $this->soldes->add($solde);
            $solde->setInstitut($this);
        }

        return $this;
    }

    public function removeSolde(SoldeEtudiant $solde): self
    {
        if ($this->soldes->removeElement($solde)) {
            // set the owning side to null (unless already changed)
            if ($solde->getInstitut() === $this) {
                $solde->setInstitut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Quitus>
     */
    public function getQuitus(): Collection
    {
        return $this->quitus;
    }

    public function addQuitu(Quitus $quitu): self
    {
        if (!$this->quitus->contains($quitu)) {
            $this->quitus->add($quitu);
            $quitu->setInstitut($this);
        }

        return $this;
    }

    public function removeQuitu(Quitus $quitu): self
    {
        if ($this->quitus->removeElement($quitu)) {
            // set the owning side to null (unless already changed)
            if ($quitu->getInstitut() === $this) {
                $quitu->setInstitut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Paiement>
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): self
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements->add($paiement);
            $paiement->setInstitut($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): self
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getInstitut() === $this) {
                $paiement->setInstitut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Jury>
     */
    public function getJuries(): Collection
    {
        return $this->juries;
    }

    public function addJury(Jury $jury): self
    {
        if (!$this->juries->contains($jury)) {
            $this->juries->add($jury);
            $jury->setInstitut($this);
        }

        return $this;
    }

    public function removeJury(Jury $jury): self
    {
        if ($this->juries->removeElement($jury)) {
            // set the owning side to null (unless already changed)
            if ($jury->getInstitut() === $this) {
                $jury->setInstitut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Groupe>
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes->add($groupe);
            $groupe->setInstitut($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getInstitut() === $this) {
                $groupe->setInstitut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Soutenance>
     */
    public function getSoutenances(): Collection
    {
        return $this->soutenances;
    }

    public function addSoutenance(Soutenance $soutenance): self
    {
        if (!$this->soutenances->contains($soutenance)) {
            $this->soutenances->add($soutenance);
            $soutenance->setInstitut($this);
        }

        return $this;
    }

    public function removeSoutenance(Soutenance $soutenance): self
    {
        if ($this->soutenances->removeElement($soutenance)) {
            // set the owning side to null (unless already changed)
            if ($soutenance->getInstitut() === $this) {
                $soutenance->setInstitut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Planning>
     */
    public function getPlannings(): Collection
    {
        return $this->plannings;
    }

    public function addPlanning(Planning $planning): self
    {
        if (!$this->plannings->contains($planning)) {
            $this->plannings->add($planning);
            $planning->setInstitut($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if ($this->plannings->removeElement($planning)) {
            // set the owning side to null (unless already changed)
            if ($planning->getInstitut() === $this) {
                $planning->setInstitut(null);
            }
        }

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
            $encadrement->setInstitut($this);
        }

        return $this;
    }

    public function removeEncadrement(Encadrement $encadrement): self
    {
        if ($this->encadrements->removeElement($encadrement)) {
            // set the owning side to null (unless already changed)
            if ($encadrement->getInstitut() === $this) {
                $encadrement->setInstitut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Chronologie>
     */
    public function getChronologies(): Collection
    {
        return $this->chronologies;
    }

    public function addChronology(Chronologie $chronology): self
    {
        if (!$this->chronologies->contains($chronology)) {
            $this->chronologies->add($chronology);
            $chronology->setInstitut($this);
        }

        return $this;
    }

    public function removeChronology(Chronologie $chronology): self
    {
        if ($this->chronologies->removeElement($chronology)) {
            // set the owning side to null (unless already changed)
            if ($chronology->getInstitut() === $this) {
                $chronology->setInstitut(null);
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
            $ficheIdentification->setInstitut($this);
        }

        return $this;
    }

    public function removeFicheIdentification(FicheIdentification $ficheIdentification): self
    {
        if ($this->ficheIdentifications->removeElement($ficheIdentification)) {
            // set the owning side to null (unless already changed)
            if ($ficheIdentification->getInstitut() === $this) {
                $ficheIdentification->setInstitut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classe $class): self
    {
        if (!$this->classes->contains($class)) {
            $this->classes->add($class);
            $class->setInstitut($this);
        }

        return $this;
    }

    public function removeClass(Classe $class): self
    {
        if ($this->classes->removeElement($class)) {
            // set the owning side to null (unless already changed)
            if ($class->getInstitut() === $this) {
                $class->setInstitut(null);
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
            $honoraire->setInstitut($this);
        }

        return $this;
    }

    public function removeHonoraire(Honoraire $honoraire): self
    {
        if ($this->honoraires->removeElement($honoraire)) {
            // set the owning side to null (unless already changed)
            if ($honoraire->getInstitut() === $this) {
                $honoraire->setInstitut(null);
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
            $contrat->setInstitut($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): self
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getInstitut() === $this) {
                $contrat->setInstitut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HonoraireRecap>
     */
    public function getHonoraireRecaps(): Collection
    {
        return $this->honoraireRecaps;
    }

    public function addHonoraireRecap(HonoraireRecap $honoraireRecap): self
    {
        if (!$this->honoraireRecaps->contains($honoraireRecap)) {
            $this->honoraireRecaps->add($honoraireRecap);
            $honoraireRecap->setInstitut($this);
        }

        return $this;
    }

    public function removeHonoraireRecap(HonoraireRecap $honoraireRecap): self
    {
        if ($this->honoraireRecaps->removeElement($honoraireRecap)) {
            // set the owning side to null (unless already changed)
            if ($honoraireRecap->getInstitut() === $this) {
                $honoraireRecap->setInstitut(null);
            }
        }

        return $this;
    }

}