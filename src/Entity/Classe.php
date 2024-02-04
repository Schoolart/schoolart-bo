<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:classe']],
    denormalizationContext: ['groups'=>['write:classe']],
    collectionOperations:[
        'get'=>[
            'normalization_context'=> ['groups'=>['read:classe']],
    'denormalization_context'=>['groups'=>['write:classe']]
    ],
        'post'=>[
            'normalization_context'=> ['groups'=>['read:classe']],
            'denormalization_context'=>['groups'=>['write:classe']]
        ],
        'info'=>[
            'method' => 'GET',
            'path' => '/classes/information',
            'normalization_context'=> ['groups'=>['read:classe','read:classe:niveau','read:classe:etudiant/professeur','read:classe:specialisation',
                'read:classe:anneeAcademic','read:classe:diplome','read:classe:matiere','read:classe:matiere:matiereSup','read:classe:niveau:periode']],
            'denormalization_context'=> ['groups'=>['write:classe']]
        ],
        'classe'=>[
            'method' => 'GET',
            'path' => '/classes/info',
            'normalization_context'=> ['groups'=>['read:classe:info','read:classe:niveau','read:classe:specialisation','read:classe:niveau:periode']],
            'denormalization_context'=> ['groups'=>['write:classe']]
        ],
    ],
    itemOperations: [
        'get',
        'put',
        'patch',
        'delete',
        'classeInfo'=>[
            'method' => 'GET',
            'path' => '/classes/infoClasse/{id}',
            'normalization_context'=> ['groups'=>['read:classe:infoClasse']],
            'denormalization_context'=> ['groups'=>['write:classe']]
        ],
        'classeInfoEdit'=>[
            'method' => 'GET',
            'path' => '/classes/infoEdit/{id}',
            'normalization_context'=> ['groups'=>['read:classe:infoEdit','read:classe:niveau','read:classe:etudiant/professeur','read:classe:specialisation',
                'read:classe:anneeAcademic','read:classe:diplome',]],
            'denormalization_context'=> ['groups'=>['write:classe']]
        ],
    ]
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'niveau'=>'exact',
        'professeurs'=>'exact',
        'etudiants'=>'exact',
        'institut'=>'exact',
        "anneeAcademic"=>'exact'
    ]
)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:classe','read:parametrageScolarite:classe','read:matiere:classe','read:fiche:classe','read:parcours:classe','read:classe:infoEdit','read:classe:infoClasse','read:classe:info','read:etudiant:classe','read:professeur:classe','read:professeur:matiere:classe','read:passage:classe','read:infoSupplementaire:classe'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:classe','read:parametrageScolarite:classe','read:matiere:classe','read:fiche:classe','read:parcours:classe','read:classe:infoEdit','read:classe:infoClasse','read:classe:info','write:classe','read:etudiant:classe','read:professeur:classe','read:professeur:matiere:classe','read:passage:classe','read:infoSupplementaire:classe'])]
    private ?string $nomClasse = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups(['read:classe','write:classe','read:classe:infoEdit'])]
    private ?Etudiant $delegue1 = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups(['read:classe','write:classe','read:classe:infoEdit'])]
    private ?Etudiant $delegue2 = null;

    #[ORM\ManyToOne(inversedBy: 'classes')]
    #[Groups(['read:classe','read:parametrageScolarite:classe','read:classe:infoEdit','read:classe:info','write:classe','read:professeur:classe','read:etudiant:classe'])]
    private ?Niveau $niveau = null;


    #[ORM\Column(nullable: true)]
    #[Groups(['read:classe','write:classe'])]
    private ?int $effectif = null;

    #[ORM\ManyToOne(inversedBy: 'classes')]
    #[Groups(['read:classe','read:classe:infoEdit','write:classe','read:classe:info',])]
    private ?Specialisation $specialisation = null;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Ue::class)]
    #[Groups(['read:classe','read:classe:infoClasse'])]
    private Collection $ues;

    #[ORM\OneToOne(inversedBy: 'classe', cascade: ['persist', 'remove'])]
    #[Groups(['read:classe','read:classe:infoEdit','write:classe'])]
    private ?Diplome $diplome = null;

    #[ORM\ManyToMany(targetEntity: Etudiant::class, inversedBy: 'classes')]
    #[Groups(['read:classe','read:classe:info','read:classe:infoClasse'])]
    private Collection $etudiants;

    #[ORM\ManyToMany(targetEntity: Professeur::class, inversedBy: 'classes')]
    #[Groups(['read:classe','read:classe:infoClasse'])]
    private Collection $professeurs;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Matiere::class)]
    #[Groups(['read:classe','read:classe:infoClasse'])]
    private Collection $matieres;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups(['read:classe','write:classe','read:classe:infoEdit'])]
    private ?Professeur $professeurPrincipal = null;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Compensation::class)]
    //#[Groups(['read:classe'])]
    private Collection $compensations;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:classe','write:classe','read:classe:infoClasse','read:classe:infoEdit','read:classe:info','read:passage:classe'])]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Bulletin::class)]
    private Collection $bulletins;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Passage::class)]
    private Collection $passages;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Parcours::class)]
    private Collection $parcours;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:classe','write:classe','read:classe:infoEdit'])]
    private ?int $prochainNiveau = null;

    /**
     * @return int|null
     */
    public function getProchainNiveau(): ?int
    {
        return $this->prochainNiveau;
    }

    /**
     * @param int|null $prochainNiveau
     */
    public function setProchainNiveau(?int $prochainNiveau): void
    {
        $this->prochainNiveau = $prochainNiveau;
    }

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Attestation::class)]
    private Collection $attestations;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: PeriodePrec::class)]
    private Collection $periodeprecs;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Bibliotheque::class)]
    private Collection $bibliotheques;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: RecapBibliotheque::class)]
    private Collection $recapsbibliotheques;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: InfoSupplementaire::class)]
    private Collection $infos;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Note::class)]
    private Collection $notes;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: ParametrageFraisScolariteEtud::class)]
    private Collection $parametrageFraisScolariteEtuds;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Paiement::class)]
    private Collection $paiements;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: FactureEtudiant::class)]
    private Collection $factureEtudiants;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Absence::class)]
    private Collection $absences;

    #[ORM\ManyToMany(targetEntity: FicheIdentification::class, mappedBy: 'classes')]
    private Collection $ficheIdentifications;

    #[ORM\ManyToOne(inversedBy: 'classes')]
    private ?Institut $institut = null;

    #[ORM\ManyToOne(inversedBy: 'classes')]
    private ?AnneeAcademic $anneeAcademic = null;


    public function __construct()
    {
        $this->ues = new ArrayCollection();
        $this->etudiants = new ArrayCollection();
        $this->professeurs = new ArrayCollection();
        $this->matieres = new ArrayCollection();
        $this->compensations = new ArrayCollection();
        $this->bulletins = new ArrayCollection();
        $this->passages = new ArrayCollection();
        $this->parcours = new ArrayCollection();
        $this->attestations = new ArrayCollection();
        $this->periodeprecs = new ArrayCollection();
        $this->bibliotheques = new ArrayCollection();
        $this->recapsbibliotheques = new ArrayCollection();
        $this->infos = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->parametrageFraisScolariteEtuds = new ArrayCollection();
        $this->paiements = new ArrayCollection();
        $this->factureEtudiants = new ArrayCollection();
        $this->absences = new ArrayCollection();
        $this->ficheIdentifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClasse(): ?string
    {
        return $this->nomClasse;
    }

    public function setNomClasse(string $nomClasse): self
    {
        $this->nomClasse = $nomClasse;

        return $this;
    }

    public function getDelegue1(): ?Etudiant
    {
        return $this->delegue1;
    }

    public function setDelegue1(?Etudiant $delegue1): self
    {
        $this->delegue1 = $delegue1;

        return $this;
    }

    public function getDelegue2(): ?Etudiant
    {
        return $this->delegue2;
    }

    public function setDelegue2(?Etudiant $delegue2): self
    {
        $this->delegue2 = $delegue2;

        return $this;
    }


    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }


    public function getEffectif(): ?int
    {
        return $this->effectif;
    }

    public function setEffectif(?int $effectif): self
    {
        $this->effectif = $effectif;

        return $this;
    }

    public function getSpecialisation(): ?Specialisation
    {
        return $this->specialisation;
    }

    public function setSpecialisation(?Specialisation $specialisation): self
    {
        $this->specialisation = $specialisation;

        return $this;
    }

    /**
     * @return Collection<int, Ue>
     */
    public function getUes(): Collection
    {
        return $this->ues;
    }

    public function addUe(Ue $ue): self
    {
        if (!$this->ues->contains($ue)) {
            $this->ues->add($ue);
            $ue->setClasse($this);
        }

        return $this;
    }

    public function removeUe(Ue $ue): self
    {
        if ($this->ues->removeElement($ue)) {
            // set the owning side to null (unless already changed)
            if ($ue->getClasse() === $this) {
                $ue->setClasse(null);
            }
        }

        return $this;
    }

    public function getDiplome(): ?Diplome
    {
        return $this->diplome;
    }

    public function setDiplome(?Diplome $diplome): self
    {
        $this->diplome = $diplome;

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

    /**
     * @return Collection<int, Professeur>
     */
    public function getProfesseurs(): Collection
    {
        return $this->professeurs;
    }

    public function addProfesseur(Professeur $professeur): self
    {
        if (!$this->professeurs->contains($professeur)) {
            $this->professeurs->add($professeur);
        }

        return $this;
    }

    public function removeProfesseur(Professeur $professeur): self
    {
        $this->professeurs->removeElement($professeur);

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
            $matiere->setClasse($this);
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): self
    {
        if ($this->matieres->removeElement($matiere)) {
            // set the owning side to null (unless already changed)
            if ($matiere->getClasse() === $this) {
                $matiere->setClasse(null);
            }
        }

        return $this;
    }

    public function getProfesseurPrincipal(): ?Professeur
    {
        return $this->professeurPrincipal;
    }

    public function setProfesseurPrincipal(?Professeur $professeurPrincipal): self
    {
        $this->professeurPrincipal = $professeurPrincipal;

        return $this;
    }

    /**
     * @return Collection<int, Compensation>
     */
    public function getCompensations(): Collection
    {
        return $this->compensations;
    }

    public function addCompensation(Compensation $compensation): self
    {
        if (!$this->compensations->contains($compensation)) {
            $this->compensations->add($compensation);
            $compensation->setClasse($this);
        }

        return $this;
    }

    public function removeCompensation(Compensation $compensation): self
    {
        if ($this->compensations->removeElement($compensation)) {
            // set the owning side to null (unless already changed)
            if ($compensation->getClasse() === $this) {
                $compensation->setClasse(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
            $bulletin->setClasse($this);
        }

        return $this;
    }

    public function removeBulletin(Bulletin $bulletin): self
    {
        if ($this->bulletins->removeElement($bulletin)) {
            // set the owning side to null (unless already changed)
            if ($bulletin->getClasse() === $this) {
                $bulletin->setClasse(null);
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
            $passage->setClasse($this);
        }

        return $this;
    }

    public function removePassage(Passage $passage): self
    {
        if ($this->passages->removeElement($passage)) {
            // set the owning side to null (unless already changed)
            if ($passage->getClasse() === $this) {
                $passage->setClasse(null);
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
            $parcour->setClasse($this);
        }

        return $this;
    }

    public function removeParcour(Parcours $parcour): self
    {
        if ($this->parcours->removeElement($parcour)) {
            // set the owning side to null (unless already changed)
            if ($parcour->getClasse() === $this) {
                $parcour->setClasse(null);
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
            $attestation->setClasse($this);
        }

        return $this;
    }

    public function removeAttestation(Attestation $attestation): self
    {
        if ($this->attestations->removeElement($attestation)) {
            // set the owning side to null (unless already changed)
            if ($attestation->getClasse() === $this) {
                $attestation->setClasse(null);
            }
        }

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
            $periodeprec->setClasse($this);
        }

        return $this;
    }

    public function removePeriodeprec(PeriodePrec $periodeprec): self
    {
        if ($this->periodeprecs->removeElement($periodeprec)) {
            // set the owning side to null (unless already changed)
            if ($periodeprec->getClasse() === $this) {
                $periodeprec->setClasse(null);
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
            $bibliotheque->setClasse($this);
        }

        return $this;
    }

    public function removeBibliotheque(Bibliotheque $bibliotheque): self
    {
        if ($this->bibliotheques->removeElement($bibliotheque)) {
            // set the owning side to null (unless already changed)
            if ($bibliotheque->getClasse() === $this) {
                $bibliotheque->setClasse(null);
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
            $recapsbibliotheque->setClasse($this);
        }

        return $this;
    }

    public function removeRecapsbibliotheque(RecapBibliotheque $recapsbibliotheque): self
    {
        if ($this->recapsbibliotheques->removeElement($recapsbibliotheque)) {
            // set the owning side to null (unless already changed)
            if ($recapsbibliotheque->getClasse() === $this) {
                $recapsbibliotheque->setClasse(null);
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
            $info->setClasse($this);
        }

        return $this;
    }

    public function removeInfo(InfoSupplementaire $info): self
    {
        if ($this->infos->removeElement($info)) {
            // set the owning side to null (unless already changed)
            if ($info->getClasse() === $this) {
                $info->setClasse(null);
            }
        }

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
            $note->setClasse($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getClasse() === $this) {
                $note->setClasse(null);
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
            $parametrageFraisScolariteEtud->setClasse($this);
        }

        return $this;
    }

    public function removeParametrageFraisScolariteEtud(ParametrageFraisScolariteEtud $parametrageFraisScolariteEtud): self
    {
        if ($this->parametrageFraisScolariteEtuds->removeElement($parametrageFraisScolariteEtud)) {
            // set the owning side to null (unless already changed)
            if ($parametrageFraisScolariteEtud->getClasse() === $this) {
                $parametrageFraisScolariteEtud->setClasse(null);
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
            $paiement->setClasse($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): self
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getClasse() === $this) {
                $paiement->setClasse(null);
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
            $factureEtudiant->setClasse($this);
        }

        return $this;
    }

    public function removeFactureEtudiant(FactureEtudiant $factureEtudiant): self
    {
        if ($this->factureEtudiants->removeElement($factureEtudiant)) {
            // set the owning side to null (unless already changed)
            if ($factureEtudiant->getClasse() === $this) {
                $factureEtudiant->setClasse(null);
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
            $absence->setClasse($this);
        }

        return $this;
    }

    public function removeAbsence(Absence $absence): self
    {
        if ($this->absences->removeElement($absence)) {
            // set the owning side to null (unless already changed)
            if ($absence->getClasse() === $this) {
                $absence->setClasse(null);
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
            $ficheIdentification->addClass($this);
        }

        return $this;
    }

    public function removeFicheIdentification(FicheIdentification $ficheIdentification): self
    {
        if ($this->ficheIdentifications->removeElement($ficheIdentification)) {
            $ficheIdentification->removeClass($this);
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
