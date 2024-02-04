<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\AnneeAcademicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnneeAcademicRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:anneeAcademic','read:anneeAcademic:institut']],
    denormalizationContext: ['groups'=>['write:anneeAcademic']]
)]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'institut'=>'exact',
        'etablissement'=>'exact'
    ]
)]
class AnneeAcademic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:anneeAcademic','read:classe:anneeAcademic','read:user:institut:anneeAcademic','read:professeur:classe:niveau:anneeAcademic',
        'read:etudiant:classe:niveau:anneeAcademic','read:niveau:anneeAcademic',
        'read:diplome:anneeAcademic','read:professeur:institut:anneeAcademic','read:etudiant:institut:anneeAcademic','read:solde:annee'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'anneeAcademics')]
    #[Groups(['read:anneeAcademic','write:anneeAcademic','read:niveau:anneeAcademic',
        'read:diplome:anneeAcademic',
        ])]
    private ?Institut $institut = null;


    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['read:anneeAcademic','write:anneeAcademic'])]
    private ?\DateTimeInterface $anneeDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['read:anneeAcademic','write:anneeAcademic'])]
    private ?\DateTimeInterface $anneeFin = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:anneeAcademic','write:anneeAcademic','read:professeur:classe:niveau:anneeAcademic',
        'read:etudiant:classe:niveau:anneeAcademic','read:user:institut:anneeAcademic','read:niveau:anneeAcademic',
        'read:diplome:anneeAcademic','read:professeur:institut:anneeAcademic','read:etudiant:institut:anneeAcademic','read:solde:annee'])]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Niveau::class,cascade: ['persist', 'remove'])]
    #[Groups(['read:anneeAcademic','read:user:institut:anneeAcademic'])]
    private Collection $niveaux;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Diplome::class,cascade: ['persist', 'remove'])]
    private Collection $diplomes;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Periode::class,cascade: ['persist', 'remove'])]
    private Collection $periodes;

    #[ORM\OneToOne(inversedBy: 'anneeAcademic', cascade: ['persist', 'remove'])]
    #[Groups(['read:anneeAcademic','write:anneeAcademic'])]
    private ?ParametrageInstitut $parametrage = null;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Attestation::class,cascade: ['persist', 'remove'])]
    private Collection $attestations;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: RecapAnnee::class)]
    private Collection $recaps;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:anneeAcademic','write:anneeAcademic'])]
    private ?bool $active = true;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: InfoSupplementaire::class)]
    private Collection $infos;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Bibliotheque::class)]
    private Collection $bibliotheques;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: RecapBibliotheque::class)]
    private Collection $recapBibliotheques;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: ParametrageFraisScolarite::class)]
    private Collection $parametrageFraisScolarites;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: SoldeEtudiant::class)]
    private Collection $soldes;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Quitus::class)]
    private Collection $quitus;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Paiement::class)]
    private Collection $paiements;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: FactureEtudiant::class)]
    private Collection $factureEtudiants;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Groupe::class)]
    private Collection $groupes;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Jury::class)]
    private Collection $juries;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Soutenance::class)]
    private Collection $soutenances;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Planning::class)]
    private Collection $plannings;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Encadrement::class)]
    private Collection $encadrements;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Chronologie::class)]
    private Collection $chronologies;

    #[ORM\ManyToOne(inversedBy: 'anneeAcademics')]
    private ?Etablissement $etablissement = null;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Absence::class)]
    private Collection $absences;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: FicheIdentification::class)]
    private Collection $ficheIdentifications;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Classe::class)]
    private Collection $classes;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Matiere::class)]
    private Collection $matieres;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Honoraire::class)]
    private Collection $honoraires;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Parcours::class)]
    private Collection $parcours;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: Contrat::class)]
    private Collection $contrats;

    #[ORM\OneToMany(mappedBy: 'anneeAcademic', targetEntity: HonoraireRecap::class)]
    private Collection $honoraireRecaps;


    public function __construct()
    {
        $this->niveaux = new ArrayCollection();
        $this->diplomes = new ArrayCollection();
        $this->periodes = new ArrayCollection();
        $this->attestations = new ArrayCollection();
        $this->recaps = new ArrayCollection();
        $this->infos = new ArrayCollection();
        $this->bibliotheques = new ArrayCollection();
        $this->recapBibliotheques = new ArrayCollection();
        $this->parametrageFraisScolarites = new ArrayCollection();
        $this->soldes = new ArrayCollection();
        $this->quitus = new ArrayCollection();
        $this->paiements = new ArrayCollection();
        $this->factureEtudiants = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->juries = new ArrayCollection();
        $this->soutenances = new ArrayCollection();
        $this->plannings = new ArrayCollection();
        $this->encadrements = new ArrayCollection();
        $this->chronologies = new ArrayCollection();
        $this->absences = new ArrayCollection();
        $this->ficheIdentifications = new ArrayCollection();
        $this->classes = new ArrayCollection();
        $this->matieres = new ArrayCollection();
        $this->honoraires = new ArrayCollection();
        $this->parcours = new ArrayCollection();
        $this->contrats = new ArrayCollection();
        $this->honoraireRecaps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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


    public function getAnneeDebut(): ?\DateTimeInterface
    {
        return $this->anneeDebut;
    }

    public function setAnneeDebut(?\DateTimeInterface $anneeDebut): self
    {
        $this->anneeDebut = $anneeDebut;

        return $this;
    }

    public function getAnneeFin(): ?\DateTimeInterface
    {
        return $this->anneeFin;
    }

    public function setAnneeFin(?\DateTimeInterface $anneeFin): self
    {
        $this->anneeFin = $anneeFin;

        return $this;
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

    /**
     * @return Collection<int, Niveau>
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux->add($niveau);
            $niveau->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->removeElement($niveau)) {
            // set the owning side to null (unless already changed)
            if ($niveau->getAnneeAcademic() === $this) {
                $niveau->setAnneeAcademic(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Diplome>
     */
    public function getDiplomes(): Collection
    {
        return $this->diplomes;
    }

    public function addDiplome(Diplome $diplome): self
    {
        if (!$this->diplomes->contains($diplome)) {
            $this->diplomes->add($diplome);
            $diplome->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeDiplome(Diplome $diplome): self
    {
        if ($this->diplomes->removeElement($diplome)) {
            // set the owning side to null (unless already changed)
            if ($diplome->getAnneeAcademic() === $this) {
                $diplome->setAnneeAcademic(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Periode>
     */
    public function getPeriodes(): Collection
    {
        return $this->periodes;
    }

    public function addPeriode(Periode $periode): self
    {
        if (!$this->periodes->contains($periode)) {
            $this->periodes->add($periode);
            $periode->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removePeriode(Periode $periode): self
    {
        if ($this->periodes->removeElement($periode)) {
            // set the owning side to null (unless already changed)
            if ($periode->getAnneeAcademic() === $this) {
                $periode->setAnneeAcademic(null);
            }
        }

        return $this;
    }

    public function getParametrage(): ?ParametrageInstitut
    {
        return $this->parametrage;
    }

    public function setParametrage(?ParametrageInstitut $parametrage): self
    {
        $this->parametrage = $parametrage;

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
            $attestation->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeAttestation(Attestation $attestation): self
    {
        if ($this->attestations->removeElement($attestation)) {
            // set the owning side to null (unless already changed)
            if ($attestation->getAnneeAcademic() === $this) {
                $attestation->setAnneeAcademic(null);
            }
        }

        return $this;
    }
    public function clearId()
    {
        $this->id = null; // également essayé avec "", 0, valeur de l'auto-incrément, true, false, -1

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
            $recap->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeRecap(RecapAnnee $recap): self
    {
        if ($this->recaps->removeElement($recap)) {
            // set the owning side to null (unless already changed)
            if ($recap->getAnneeAcademic() === $this) {
                $recap->setAnneeAcademic(null);
            }
        }

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;
        if(!$this->active){
           $periodes =  $this->getPeriodes();
           foreach ($periodes as $periode){
               $periode->setFerme(true);
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
            $info->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeInfo(InfoSupplementaire $info): self
    {
        if ($this->infos->removeElement($info)) {
            // set the owning side to null (unless already changed)
            if ($info->getAnneeAcademic() === $this) {
                $info->setAnneeAcademic(null);
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
            $bibliotheque->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeBibliotheque(Bibliotheque $bibliotheque): self
    {
        if ($this->bibliotheques->removeElement($bibliotheque)) {
            // set the owning side to null (unless already changed)
            if ($bibliotheque->getAnneeAcademic() === $this) {
                $bibliotheque->setAnneeAcademic(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RecapBibliotheque>
     */
    public function getRecapBibliotheques(): Collection
    {
        return $this->recapBibliotheques;
    }

    public function addRecapBibliotheque(RecapBibliotheque $recapBibliotheque): self
    {
        if (!$this->recapBibliotheques->contains($recapBibliotheque)) {
            $this->recapBibliotheques->add($recapBibliotheque);
            $recapBibliotheque->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeRecapBibliotheque(RecapBibliotheque $recapBibliotheque): self
    {
        if ($this->recapBibliotheques->removeElement($recapBibliotheque)) {
            // set the owning side to null (unless already changed)
            if ($recapBibliotheque->getAnneeAcademic() === $this) {
                $recapBibliotheque->setAnneeAcademic(null);
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
            $parametrageFraisScolarite->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeParametrageFraisScolarite(ParametrageFraisScolarite $parametrageFraisScolarite): self
    {
        if ($this->parametrageFraisScolarites->removeElement($parametrageFraisScolarite)) {
            // set the owning side to null (unless already changed)
            if ($parametrageFraisScolarite->getAnneeAcademic() === $this) {
                $parametrageFraisScolarite->setAnneeAcademic(null);
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
            $solde->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeSolde(SoldeEtudiant $solde): self
    {
        if ($this->soldes->removeElement($solde)) {
            // set the owning side to null (unless already changed)
            if ($solde->getAnneeAcademic() === $this) {
                $solde->setAnneeAcademic(null);
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
            $quitu->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeQuitu(Quitus $quitu): self
    {
        if ($this->quitus->removeElement($quitu)) {
            // set the owning side to null (unless already changed)
            if ($quitu->getAnneeAcademic() === $this) {
                $quitu->setAnneeAcademic(null);
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
            $paiement->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): self
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getAnneeAcademic() === $this) {
                $paiement->setAnneeAcademic(null);
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
            $factureEtudiant->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeFactureEtudiant(FactureEtudiant $factureEtudiant): self
    {
        if ($this->factureEtudiants->removeElement($factureEtudiant)) {
            // set the owning side to null (unless already changed)
            if ($factureEtudiant->getAnneeAcademic() === $this) {
                $factureEtudiant->setAnneeAcademic(null);
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
            $groupe->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getAnneeAcademic() === $this) {
                $groupe->setAnneeAcademic(null);
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
            $jury->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeJury(Jury $jury): self
    {
        if ($this->juries->removeElement($jury)) {
            // set the owning side to null (unless already changed)
            if ($jury->getAnneeAcademic() === $this) {
                $jury->setAnneeAcademic(null);
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
            $soutenance->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeSoutenance(Soutenance $soutenance): self
    {
        if ($this->soutenances->removeElement($soutenance)) {
            // set the owning side to null (unless already changed)
            if ($soutenance->getAnneeAcademic() === $this) {
                $soutenance->setAnneeAcademic(null);
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
            $planning->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if ($this->plannings->removeElement($planning)) {
            // set the owning side to null (unless already changed)
            if ($planning->getAnneeAcademic() === $this) {
                $planning->setAnneeAcademic(null);
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
            $encadrement->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeEncadrement(Encadrement $encadrement): self
    {
        if ($this->encadrements->removeElement($encadrement)) {
            // set the owning side to null (unless already changed)
            if ($encadrement->getAnneeAcademic() === $this) {
                $encadrement->setAnneeAcademic(null);
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
            $chronology->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeChronology(Chronologie $chronology): self
    {
        if ($this->chronologies->removeElement($chronology)) {
            // set the owning side to null (unless already changed)
            if ($chronology->getAnneeAcademic() === $this) {
                $chronology->setAnneeAcademic(null);
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
            $absence->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeAbsence(Absence $absence): self
    {
        if ($this->absences->removeElement($absence)) {
            // set the owning side to null (unless already changed)
            if ($absence->getAnneeAcademic() === $this) {
                $absence->setAnneeAcademic(null);
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
            $ficheIdentification->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeFicheIdentification(FicheIdentification $ficheIdentification): self
    {
        if ($this->ficheIdentifications->removeElement($ficheIdentification)) {
            // set the owning side to null (unless already changed)
            if ($ficheIdentification->getAnneeAcademic() === $this) {
                $ficheIdentification->setAnneeAcademic(null);
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
            $class->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeClass(Classe $class): self
    {
        if ($this->classes->removeElement($class)) {
            // set the owning side to null (unless already changed)
            if ($class->getAnneeAcademic() === $this) {
                $class->setAnneeAcademic(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Matiere>
     */
    public function getMatieres(): Collection
    {
        return $this->matieres;
    }

    public function addMatiere(Matiere $matiere): self
    {
        if (!$this->matieres->contains($matiere)) {
            $this->matieres->add($matiere);
            $matiere->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): self
    {
        if ($this->matieres->removeElement($matiere)) {
            // set the owning side to null (unless already changed)
            if ($matiere->getAnneeAcademic() === $this) {
                $matiere->setAnneeAcademic(null);
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
            $honoraire->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeHonoraire(Honoraire $honoraire): self
    {
        if ($this->honoraires->removeElement($honoraire)) {
            // set the owning side to null (unless already changed)
            if ($honoraire->getAnneeAcademic() === $this) {
                $honoraire->setAnneeAcademic(null);
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
            $parcour->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeParcour(Parcours $parcour): self
    {
        if ($this->parcours->removeElement($parcour)) {
            // set the owning side to null (unless already changed)
            if ($parcour->getAnneeAcademic() === $this) {
                $parcour->setAnneeAcademic(null);
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
            $contrat->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): self
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getAnneeAcademic() === $this) {
                $contrat->setAnneeAcademic(null);
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
            $honoraireRecap->setAnneeAcademic($this);
        }

        return $this;
    }

    public function removeHonoraireRecap(HonoraireRecap $honoraireRecap): self
    {
        if ($this->honoraireRecaps->removeElement($honoraireRecap)) {
            // set the owning side to null (unless already changed)
            if ($honoraireRecap->getAnneeAcademic() === $this) {
                $honoraireRecap->setAnneeAcademic(null);
            }
        }

        return $this;
    }

}
