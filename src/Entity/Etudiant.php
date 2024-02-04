<?php

namespace App\Entity;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\UserController;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Repository\EtudiantRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
#[Vich\Uploadable()]
#[ApiResource(
    normalizationContext: ['groups'=>['read:etudiant','read:user','read:etudiant:classe','read:etudiant:classe:niveau',
    'read:etudiant:bourse','read:user:institut','read:etudiant:bourse:typeBourse','read:etudiant:classe:niveau:anneeAcademic',
      'read:etudiant:institut:anneeAcademic']],
    denormalizationContext: ['groups'=>['read:etudiant','write:user']],
    itemOperations: [
        "get",
        'put',
        'delete',
        'patch',
        'image'=>[
            'method' => 'POST',
            'deserialize' => false,
            'path' => '/etudiant/{id}/image',
            'controller' => UserController::class
        ]
    ]
)]

#[ApiFilter(
    SearchFilter::class,
    properties: [
        'classes'=>'exact',
        'instituts'=>'exact',
        'identifiant'=>'partial',
        'etablissement'=>"exact"
    ]
)]

#[ApiFilter(
    BooleanFilter::class,
    properties: [
        'boursier',
    ]
)]
class Etudiant extends User
{

    #[ORM\Column(length: 255)]
    #[Groups(['read:etudiant','read:groupe:etu','read:parametrageScolarite:etud','read:parcours:etudiant','read:passage:etudiant','read:bibliotheque:etudiant'])]
    private ?string $identifiant = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:etudiant'])]
    private ?string $ecoleProvenance = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:etudiant'])]
    private ?bool $redoublant = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:etudiant'])]
    private ?bool $admissionParallele = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:etudiant','read:parametrageScolarite:etud'])]
    private ?bool $compteActif = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:etudiant','read:parametrageScolarite:etud'])]
    private ?bool $boursier = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:etudiant'])]
    private ?bool $exemptDroitsInscriptions = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:etudiant'])]
    private ?bool $exemptFraisScolarite = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:etudiant'])]
    private ?bool $interdictionPaiementCheque = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:etudiant'])]
    private ?string $nationalite = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:etudiant'])]
    private ?string $statutProfessionel = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:etudiant'])]
    private ?string $employeur = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:etudiant'])]
    private ?string $numCni = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:etudiant'])]
    private ?string $numPasseport = null;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Sanction::class)]
    //#[Groups(['read:etudiant'])]
    private Collection $sanctions;

    #[ORM\ManyToOne(inversedBy: 'etudiants')]
    #[Groups(['read:etudiant','read:parametrageScolarite:etud'])]
    private ?Bourse $bourse = null;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Note::class)]
    //#[Groups(['read:etudiant'])]
    private Collection $notes;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Absence::class)]
    //#[Groups(['read:etudiant'])]
    private Collection $absences;

    #[ORM\ManyToMany(targetEntity: Classe::class, mappedBy: 'etudiants')]
    #[Groups(['read:etudiant','read:parametrageScolarite:etud'])]
    private Collection $classes;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Bulletin::class)]
    private Collection $bulletins;



    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Passage::class)]
    private Collection $passages;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Attestation::class)]
    private Collection $attestations;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Parcours::class)]
    private Collection $parcours;





    #[Vich\UploadableField(mapping:"user_avatar", fileNameProperty:"avatar")]
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[Groups(['read:etudiant','read:bibliotheque:etudiant','read:parametrageScolarite:etud','read:groupe:etu'])]
    private  $fileUrl;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: RecapAnnee::class)]
    private Collection $recaps;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:etudiant'])]
    private ?int $duree = null;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: PeriodePrec::class)]
    private Collection $periodeprecs;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Bibliotheque::class)]
    private Collection $bibliotheques;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: RecapBibliotheque::class)]
    private Collection $recapsbibliotheques;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: InfoSupplementaire::class)]
    private Collection $infos;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: ParametrageFraisScolariteEtud::class)]
    private Collection $parametrageFraisScolariteEtuds;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Paiement::class)]
    private Collection $paiements;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: SoldeEtudiant::class)]
    private Collection $soldes;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Quitus::class)]
    private Collection $quitus;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: FactureEtudiant::class)]
    private Collection $factureEtudiants;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:etudiant','read:parametrageScolarite:etud'])]
    private ?string $identifiantPaiement = null;

    #[ORM\ManyToMany(targetEntity: Groupe::class, mappedBy: 'etudiants')]
    private Collection $groupes;

    #[ORM\OneToMany(mappedBy: 'chefGroupe', targetEntity: Groupe::class)]
    private Collection $groupesChef;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $classeRedouble = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:etudiant'])]
    private ?string $tuteur = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:etudiant'])]
    private ?string $numeroTuteur = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:etudiant'])]
    private ?string $emailTuteur = null;





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

        $this->sanctions = new ArrayCollection();
        parent::__construct();
        $this->notes = new ArrayCollection();
        $this->absences = new ArrayCollection();
        $this->classes = new ArrayCollection();
        $this->bulletins = new ArrayCollection();
        $this->passages = new ArrayCollection();
        $this->attestations = new ArrayCollection();
        $this->parcours = new ArrayCollection();
        $this->recaps = new ArrayCollection();
        $this->periodeprecs = new ArrayCollection();
        $this->bibliotheques = new ArrayCollection();
        $this->recapsbibliotheques = new ArrayCollection();
        $this->infos = new ArrayCollection();
        $this->parametrageFraisScolariteEtuds = new ArrayCollection();
        $this->paiements = new ArrayCollection();
        $this->soldes = new ArrayCollection();
        $this->quitus = new ArrayCollection();
        $this->factureEtudiants = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->groupesChef = new ArrayCollection();

    }


    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(string $identifiant): self
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    public function getEcoleProvenance(): ?string
    {
        return $this->ecoleProvenance;
    }

    public function setEcoleProvenance(?string $ecoleProvenance): self
    {
        $this->ecoleProvenance = $ecoleProvenance;

        return $this;
    }

    public function isRedoublant(): ?bool
    {
        return $this->redoublant;
    }

    public function setRedoublant(?bool $redoublant): self
    {
        $this->redoublant = $redoublant;

        return $this;
    }

    public function isAdmissionParallele(): ?bool
    {
        return $this->admissionParallele;
    }

    public function setAdmissionParallele(?bool $admissionParallele): self
    {
        $this->admissionParallele = $admissionParallele;

        return $this;
    }

    public function isCompteActif(): ?bool
    {
        return $this->compteActif;
    }

    public function setCompteActif(?bool $compteActif): self
    {
        $this->compteActif = $compteActif;

        return $this;
    }

    public function isBoursier(): ?bool
    {
        return $this->boursier;
    }

    public function setBoursier(?bool $boursier): self
    {
        $this->boursier = $boursier;

        return $this;
    }

    public function isExemptDroitsInscriptions(): ?bool
    {
        return $this->exemptDroitsInscriptions;
    }

    public function setExemptDroitsInscriptions(?bool $exemptDroitsInscriptions): self
    {
        $this->exemptDroitsInscriptions = $exemptDroitsInscriptions;

        return $this;
    }

    public function isExemptFraisScolarite(): ?bool
    {
        return $this->exemptFraisScolarite;
    }

    public function setExemptFraisScolarite(?bool $exemptFraisScolarite): self
    {
        $this->exemptFraisScolarite = $exemptFraisScolarite;

        return $this;
    }

    public function isInterdictionPaiementCheque(): ?bool
    {
        return $this->interdictionPaiementCheque;
    }

    public function setInterdictionPaiementCheque(?bool $interdictionPaiementCheque): self
    {
        $this->interdictionPaiementCheque = $interdictionPaiementCheque;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(?string $nationalite): self
    {
        $this->nationalite = $nationalite;
        return $this;
    }

    public function getStatutProfessionel(): ?string
    {
        return $this->statutProfessionel;
    }

    public function setStatutProfessionel(?string $statutProfessionel): self
    {
        $this->statutProfessionel = $statutProfessionel;

        return $this;
    }

    public function getEmployeur(): ?string
    {
        return $this->employeur;
    }

    public function setEmployeur(?string $employeur): self
    {
        $this->employeur = $employeur;

        return $this;
    }

    public function getNumCni(): ?string
    {
        return $this->numCni;
    }

    public function setNumCni(?string $numCni): self
    {
        $this->numCni = $numCni;

        return $this;
    }

    public function getNumPasseport(): ?string
    {
        return $this->numPasseport;
    }

    public function setNumPasseport(?string $numPasseport): self
    {
        $this->numPasseport = $numPasseport;

        return $this;
    }


    /**
     * @return Collection<int, Sanction>
     */
    public function getSanctions(): Collection
    {
        return $this->sanctions;
    }

    public function addSanction(Sanction $sanction): self
    {
        if (!$this->sanctions->contains($sanction)) {
            $this->sanctions->add($sanction);
            $sanction->setEtudiant($this);
        }

        return $this;
    }

    public function removeSanction(Sanction $sanction): self
    {
        if ($this->sanctions->removeElement($sanction)) {
            // set the owning side to null (unless already changed)
            if ($sanction->getEtudiant() === $this) {
                $sanction->setEtudiant(null);
            }
        }

        return $this;
    }

    public function getBourse(): ?Bourse
    {
        return $this->bourse;
    }

    public function setBourse(?Bourse $bourse): self
    {
        $this->bourse = $bourse;

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setEtudiant($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getEtudiant() === $this) {
                $note->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Absence>
     */
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    public function addAbsence(Absence $absence): self
    {
        if (!$this->absences->contains($absence)) {
            $this->absences->add($absence);
            $absence->setEtudiant($this);
        }

        return $this;
    }

    public function removeAbsence(Absence $absence): self
    {
        if ($this->absences->removeElement($absence)) {
            // set the owning side to null (unless already changed)
            if ($absence->getEtudiant() === $this) {
                $absence->setEtudiant(null);
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
            $class->addEtudiant($this);
        }

        return $this;
    }

    public function removeClass(Classe $class): self
    {
        if ($this->classes->removeElement($class)) {
            $class->removeEtudiant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Bulletin>
     */
    public function getBulletins(): Collection
    {
        return $this->bulletins;
    }

    public function addBulletin(Bulletin $bulletin): self
    {
        if (!$this->bulletins->contains($bulletin)) {
            $this->bulletins->add($bulletin);
            $bulletin->setEtudiant($this);
        }

        return $this;
    }

    public function removeBulletin(Bulletin $bulletin): self
    {
        if ($this->bulletins->removeElement($bulletin)) {
            // set the owning side to null (unless already changed)
            if ($bulletin->getEtudiant() === $this) {
                $bulletin->setEtudiant(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, Passage>
     */
    public function getPassages(): Collection
    {
        return $this->passages;
    }

    public function addPassage(Passage $passage): self
    {
        if (!$this->passages->contains($passage)) {
            $this->passages->add($passage);
            $passage->setEtudiant($this);
        }

        return $this;
    }

    public function removePassage(Passage $passage): self
    {
        if ($this->passages->removeElement($passage)) {
            // set the owning side to null (unless already changed)
            if ($passage->getEtudiant() === $this) {
                $passage->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Attestation>
     */
    public function getAttestations(): Collection
    {
        return $this->attestations;
    }

    public function addAttestation(Attestation $attestation): self
    {
        if (!$this->attestations->contains($attestation)) {
            $this->attestations->add($attestation);
            $attestation->setEtudiant($this);
        }

        return $this;
    }

    public function removeAttestation(Attestation $attestation): self
    {
        if ($this->attestations->removeElement($attestation)) {
            // set the owning side to null (unless already changed)
            if ($attestation->getEtudiant() === $this) {
                $attestation->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Parcours>
     */
    public function getParcours(): Collection
    {
        return $this->parcours;
    }

    public function addParcour(Parcours $parcour): self
    {
        if (!$this->parcours->contains($parcour)) {
            $this->parcours->add($parcour);
            $parcour->setEtudiant($this);
        }

        return $this;
    }

    public function removeParcour(Parcours $parcour): self
    {
        if ($this->parcours->removeElement($parcour)) {
            // set the owning side to null (unless already changed)
            if ($parcour->getEtudiant() === $this) {
                $parcour->setEtudiant(null);
            }
        }

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

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
     * @return Collection<int, RecapAnnee>
     */
    public function getRecaps(): Collection
    {
        return $this->recaps;
    }

    public function addRecap(RecapAnnee $recap): self
    {
        if (!$this->recaps->contains($recap)) {
            $this->recaps->add($recap);
            $recap->setEtudiant($this);
        }

        return $this;
    }

    public function removeRecap(RecapAnnee $recap): self
    {
        if ($this->recaps->removeElement($recap)) {
            // set the owning side to null (unless already changed)
            if ($recap->getEtudiant() === $this) {
                $recap->setEtudiant(null);
            }
        }

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * @return Collection<int, PeriodePrec>
     */
    public function getPeriodeprecs(): Collection
    {
        return $this->periodeprecs;
    }

    public function addPeriodeprec(PeriodePrec $periodeprec): self
    {
        if (!$this->periodeprecs->contains($periodeprec)) {
            $this->periodeprecs->add($periodeprec);
            $periodeprec->setEtudiant($this);
        }

        return $this;
    }

    public function removePeriodeprec(PeriodePrec $periodeprec): self
    {
        if ($this->periodeprecs->removeElement($periodeprec)) {
            // set the owning side to null (unless already changed)
            if ($periodeprec->getEtudiant() === $this) {
                $periodeprec->setEtudiant(null);
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
            $bibliotheque->setEtudiant($this);
        }

        return $this;
    }

    public function removeBibliotheque(Bibliotheque $bibliotheque): self
    {
        if ($this->bibliotheques->removeElement($bibliotheque)) {
            // set the owning side to null (unless already changed)
            if ($bibliotheque->getEtudiant() === $this) {
                $bibliotheque->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RecapBibliotheque>
     */
    public function getRecapsbibliotheques(): Collection
    {
        return $this->recapsbibliotheques;
    }

    public function addRecapsbibliotheque(RecapBibliotheque $recapsbibliotheque): self
    {
        if (!$this->recapsbibliotheques->contains($recapsbibliotheque)) {
            $this->recapsbibliotheques->add($recapsbibliotheque);
            $recapsbibliotheque->setEtudiant($this);
        }

        return $this;
    }

    public function removeRecapsbibliotheque(RecapBibliotheque $recapsbibliotheque): self
    {
        if ($this->recapsbibliotheques->removeElement($recapsbibliotheque)) {
            // set the owning side to null (unless already changed)
            if ($recapsbibliotheque->getEtudiant() === $this) {
                $recapsbibliotheque->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, InfoSupplementaire>
     */
    public function getInfos(): Collection
    {
        return $this->infos;
    }

    public function addInfo(InfoSupplementaire $info): self
    {
        if (!$this->infos->contains($info)) {
            $this->infos->add($info);
            $info->setEtudiant($this);
        }

        return $this;
    }

    public function removeInfo(InfoSupplementaire $info): self
    {
        if ($this->infos->removeElement($info)) {
            // set the owning side to null (unless already changed)
            if ($info->getEtudiant() === $this) {
                $info->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ParametrageFraisScolariteEtud>
     */
    public function getParametrageFraisScolariteEtuds(): Collection
    {
        return $this->parametrageFraisScolariteEtuds;
    }

    public function addParametrageFraisScolariteEtud(ParametrageFraisScolariteEtud $parametrageFraisScolariteEtud): self
    {
        if (!$this->parametrageFraisScolariteEtuds->contains($parametrageFraisScolariteEtud)) {
            $this->parametrageFraisScolariteEtuds->add($parametrageFraisScolariteEtud);
            $parametrageFraisScolariteEtud->setEtudiant($this);
        }

        return $this;
    }

    public function removeParametrageFraisScolariteEtud(ParametrageFraisScolariteEtud $parametrageFraisScolariteEtud): self
    {
        if ($this->parametrageFraisScolariteEtuds->removeElement($parametrageFraisScolariteEtud)) {
            // set the owning side to null (unless already changed)
            if ($parametrageFraisScolariteEtud->getEtudiant() === $this) {
                $parametrageFraisScolariteEtud->setEtudiant(null);
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
            $paiement->setEtudiant($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): self
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getEtudiant() === $this) {
                $paiement->setEtudiant(null);
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
            $solde->setEtudiant($this);
        }

        return $this;
    }

    public function removeSolde(SoldeEtudiant $solde): self
    {
        if ($this->soldes->removeElement($solde)) {
            // set the owning side to null (unless already changed)
            if ($solde->getEtudiant() === $this) {
                $solde->setEtudiant(null);
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
            $quitu->setEtudiant($this);
        }

        return $this;
    }

    public function removeQuitu(Quitus $quitu): self
    {
        if ($this->quitus->removeElement($quitu)) {
            // set the owning side to null (unless already changed)
            if ($quitu->getEtudiant() === $this) {
                $quitu->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FactureEtudiant>
     */
    public function getFactureEtudiants(): Collection
    {
        return $this->factureEtudiants;
    }

    public function addFactureEtudiant(FactureEtudiant $factureEtudiant): self
    {
        if (!$this->factureEtudiants->contains($factureEtudiant)) {
            $this->factureEtudiants->add($factureEtudiant);
            $factureEtudiant->setEtudiant($this);
        }

        return $this;
    }

    public function removeFactureEtudiant(FactureEtudiant $factureEtudiant): self
    {
        if ($this->factureEtudiants->removeElement($factureEtudiant)) {
            // set the owning side to null (unless already changed)
            if ($factureEtudiant->getEtudiant() === $this) {
                $factureEtudiant->setEtudiant(null);
            }
        }

        return $this;
    }

    public function getIdentifiantPaiement(): ?string
    {
        return $this->identifiantPaiement;
    }

    public function setIdentifiantPaiement(?string $identifiantPaiement): self
    {
        $this->identifiantPaiement = $identifiantPaiement;

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
            $groupe->addEtudiant($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            $groupe->removeEtudiant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Groupe>
     */
    public function getGroupesChef(): Collection
    {
        return $this->groupesChef;
    }

    public function addGroupesChef(Groupe $groupesChef): self
    {
        if (!$this->groupesChef->contains($groupesChef)) {
            $this->groupesChef->add($groupesChef);
            $groupesChef->setChefGroupe($this);
        }

        return $this;
    }

    public function removeGroupesChef(Groupe $groupesChef): self
    {
        if ($this->groupesChef->removeElement($groupesChef)) {
            // set the owning side to null (unless already changed)
            if ($groupesChef->getChefGroupe() === $this) {
                $groupesChef->setChefGroupe(null);
            }
        }

        return $this;
    }

    public function getClasseRedouble(): ?string
    {
        return $this->classeRedouble;
    }

    public function setClasseRedouble(?string $classeRedouble): self
    {
        $this->classeRedouble = $classeRedouble;

        return $this;
    }

    public function getTuteur(): ?string
    {
        return $this->tuteur;
    }

    public function setTuteur(?string $tuteur): self
    {
        $this->tuteur = $tuteur;

        return $this;
    }

    public function getNumeroTuteur(): ?string
    {
        return $this->numeroTuteur;
    }

    public function setNumeroTuteur(?string $numeroTuteur): self
    {
        $this->numeroTuteur = $numeroTuteur;

        return $this;
    }

    public function getEmailTuteur(): ?string
    {
        return $this->emailTuteur;
    }

    public function setEmailTuteur(?string $emailTuteur): self
    {
        $this->emailTuteur = $emailTuteur;

        return $this;
    }

}
