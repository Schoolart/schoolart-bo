<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ParametrageInstitutRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ParametrageInstitutRepository::class)]
#[ApiResource]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'institut'=>'exact',
        'anneeAcademic'=>'exact'
    ]
)]
class ParametrageInstitut
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:appreciation:parametrage'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prefixMatricule = null;

    #[ORM\Column(nullable: true)]
    private ?int $debutNumerotationMatricule = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $systemCalcul = null;

    #[ORM\Column(nullable: true)]
    private ?bool $matriculeAutomatique = false;

    #[ORM\Column(nullable: true)]
    private ?bool $showFraisScolariteApprenant = false;

    #[ORM\Column(nullable: true)]
    private ?bool $showFraisScolariteParent = false;

    #[ORM\Column(nullable: true)]
    private ?bool $showNoteApprenant = false;

    #[ORM\Column(nullable: true)]
    private ?bool $showNoteParent = false;

    #[ORM\Column(nullable: true)]
    private ?bool $appreciationPersonnalise = false;

    #[ORM\Column(nullable: true)]
    private ?float $pourcentageCc = null;

    #[ORM\Column(nullable: true)]
    private ?int $bareme = null;

    #[ORM\Column(nullable: true)]
    private ?float $pourcentageExamen = null;

    #[ORM\Column(nullable: true)]
    private ?bool $envoiAutomatiqueFacture = false;

    #[ORM\Column(nullable: true)]
    private ?bool $envoiResponsable1 = false;

    #[ORM\Column(nullable: true)]
    private ?bool $envoiResponsable2 = false;

    #[ORM\Column(nullable: true)]
    private ?bool $envoiEtudiant = false;

    #[ORM\Column(nullable: true)]
    private ?int $jourEnvoiAvantDateLimite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emailCopieCache = null;

    #[ORM\OneToMany(mappedBy: 'parametrage', targetEntity: Appreciation::class, cascade: ['persist', 'remove'])]
    private Collection $appreciations;

    #[ORM\ManyToOne(inversedBy: 'parametrages')]
    private ?Institut $institut = null;

    #[ORM\OneToOne(mappedBy: 'parametrage', cascade: ['persist', 'remove'])]
    private ?AnneeAcademic $anneeAcademic = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $systemeEnseignement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $identifiantPaiement = null;



    public function __construct()
    {
        $this->appreciations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrefixMatricule(): ?string
    {
        return $this->prefixMatricule;
    }

    public function setPrefixMatricule(?string $prefixMatricule): self
    {
        $this->prefixMatricule = $prefixMatricule;

        return $this;
    }

    public function getDebutNumerotationMatricule(): ?int
    {
        return $this->debutNumerotationMatricule;
    }

    public function setDebutNumerotationMatricule(?int $debutNumerotationMatricule): self
    {
        $this->debutNumerotationMatricule = $debutNumerotationMatricule;

        return $this;
    }

    public function getSystemCalcul(): ?string
    {
        return $this->systemCalcul;
    }

    public function setSystemCalcul(?string $systemCalcul): self
    {
        $this->systemCalcul = $systemCalcul;

        return $this;
    }

    public function isMatriculeAutomatique(): ?bool
    {
        return $this->matriculeAutomatique;
    }

    public function setMatriculeAutomatique(?bool $matriculeAutomatique): self
    {
        $this->matriculeAutomatique = $matriculeAutomatique;

        return $this;
    }

    public function isShowFraisScolariteApprenant(): ?bool
    {
        return $this->showFraisScolariteApprenant;
    }

    public function setShowFraisScolariteApprenant(?bool $showFraisScolariteApprenant): self
    {
        $this->showFraisScolariteApprenant = $showFraisScolariteApprenant;

        return $this;
    }

    public function isShowFraisScolariteParent(): ?bool
    {
        return $this->showFraisScolariteParent;
    }

    public function setShowFraisScolariteParent(?bool $showFraisScolariteParent): self
    {
        $this->showFraisScolariteParent = $showFraisScolariteParent;

        return $this;
    }

    public function isShowNoteApprenant(): ?bool
    {
        return $this->showNoteApprenant;
    }

    public function setShowNoteApprenant(?bool $showNoteApprenant): self
    {
        $this->showNoteApprenant = $showNoteApprenant;

        return $this;
    }

    public function isShowNoteParent(): ?bool
    {
        return $this->showNoteParent;
    }

    public function setShowNoteParent(?bool $showNoteParent): self
    {
        $this->showNoteParent = $showNoteParent;

        return $this;
    }

    public function isAppreciationPersonnalise(): ?bool
    {
        return $this->appreciationPersonnalise;
    }

    public function setAppreciationPersonnalise(?bool $appreciationPersonnalise): self
    {
        $this->appreciationPersonnalise = $appreciationPersonnalise;

        return $this;
    }

    public function getPourcentageCc(): ?float
    {
        return $this->pourcentageCc;
    }

    public function setPourcentageCc(?float $pourcentageCc): self
    {
        $this->pourcentageCc = $pourcentageCc;

        return $this;
    }

    public function getBareme(): ?int
    {
        return $this->bareme;
    }

    public function setBareme(?int $bareme): self
    {
        $this->bareme = $bareme;

        return $this;
    }

    public function getPourcentageExamen(): ?float
    {
        return $this->pourcentageExamen;
    }

    public function setPourcentageExamen(?float $pourcentageExamen): self
    {
        $this->pourcentageExamen = $pourcentageExamen;

        return $this;
    }

    public function isEnvoiAutomatiqueFacture(): ?bool
    {
        return $this->envoiAutomatiqueFacture;
    }

    public function setEnvoiAutomatiqueFacture(?bool $envoiAutomatiqueFacture): self
    {
        $this->envoiAutomatiqueFacture = $envoiAutomatiqueFacture;

        return $this;
    }

    public function isEnvoiResponsable1(): ?bool
    {
        return $this->envoiResponsable1;
    }

    public function setEnvoiResponsable1(?bool $envoiResponsable1): self
    {
        $this->envoiResponsable1 = $envoiResponsable1;

        return $this;
    }

    public function isEnvoiResponsable2(): ?bool
    {
        return $this->envoiResponsable2;
    }

    public function setEnvoiResponsable2(?bool $envoiResponsable2): self
    {
        $this->envoiResponsable2 = $envoiResponsable2;

        return $this;
    }

    public function isEnvoiEtudiant(): ?bool
    {
        return $this->envoiEtudiant;
    }

    public function setEnvoiEtudiant(?bool $envoiEtudiant): self
    {
        $this->envoiEtudiant = $envoiEtudiant;

        return $this;
    }

    public function getJourEnvoiAvantDateLimite(): ?int
    {
        return $this->jourEnvoiAvantDateLimite;
    }

    public function setJourEnvoiAvantDateLimite(?int $jourEnvoiAvantDateLimite): self
    {
        $this->jourEnvoiAvantDateLimite = $jourEnvoiAvantDateLimite;

        return $this;
    }

    public function getEmailCopieCache(): ?string
    {
        return $this->emailCopieCache;
    }

    public function setEmailCopieCache(?string $emailCopieCache): self
    {
        $this->emailCopieCache = $emailCopieCache;

        return $this;
    }

    /**
     * @return Collection<int, Appreciation>
     */
    public function getAppreciations(): Collection
    {
        return $this->appreciations;
    }

    public function addAppreciation(Appreciation $appreciation): self
    {
        if (!$this->appreciations->contains($appreciation)) {
            $this->appreciations->add($appreciation);
            $appreciation->setParametrage($this);
        }

        return $this;
    }

    public function removeAppreciation(Appreciation $appreciation): self
    {
        if ($this->appreciations->removeElement($appreciation)) {
            // set the owning side to null (unless already changed)
            if ($appreciation->getParametrage() === $this) {
                $appreciation->setParametrage(null);
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

    public function getAnneeAcademic(): ?AnneeAcademic
    {
        return $this->anneeAcademic;
    }

    public function setAnneeAcademic(?AnneeAcademic $anneeAcademic): self
    {
        // unset the owning side of the relation if necessary
        if ($anneeAcademic === null && $this->anneeAcademic !== null) {
            $this->anneeAcademic->setParametrage(null);
        }

        // set the owning side of the relation if necessary
        if ($anneeAcademic !== null && $anneeAcademic->getParametrage() !== $this) {
            $anneeAcademic->setParametrage($this);
        }

        $this->anneeAcademic = $anneeAcademic;

        return $this;
    }
    public function clearId(string $prefixe)
    {
        $this->id = null; // également essayé avec "", 0, valeur de l'auto-incrément, true, false, -1
        $this->prefixMatricule= $prefixe;
        $this->anneeAcademic = null;
        $this->institut = null;
        $this->appreciations = new ArrayCollection();
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSystemeEnseignement(): ?string
    {
        return $this->systemeEnseignement;
    }

    public function setSystemeEnseignement(?string $systemeEnseignement): self
    {
        $this->systemeEnseignement = $systemeEnseignement;

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

}
