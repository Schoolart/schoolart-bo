<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(["user" => "User", "professeur" => "Professeur", "etudiant" => "Etudiant","admin"=>"Admin"])]
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
class User implements UserInterface, PasswordAuthenticatedUserInterface,JWTUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:parametrageScolarite:etud','read:honoraire:prof',"read:sanction:etudiant","read:fiche:prof",'read:user','read:groupe:etu','read:jury:prof','read:parcours:etudiant','read:classe:etudiant/professeur','read:bibliotheque:user','read:matiere:professeur','read:note:etudiant','read:absence:etudiant','read:passage:etudiant'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['read:user','write:user'])]
    private ?string $login = null;

    #[ORM\Column]
    #[Groups(['read:user','write:user'])]
    private array $roles = [];
    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[Groups(['write:user'])]
    private ?string $plainPassword = null;

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     */
    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }


    #[ORM\Column(length: 255)]
    #[Groups(['read:parametrageScolarite:etud','read:honoraire:prof',"read:sanction:etudiant","read:fiche:prof",'read:groupe:etu','read:user','read:jury:prof','write:user','read:parcours:etudiant','read:classe:etudiant/professeur','read:bibliotheque:user','read:matiere:professeur','read:note:etudiant','read:absence:etudiant','read:passage:etudiant'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:parametrageScolarite:etud','read:honoraire:prof',"read:sanction:etudiant","read:fiche:prof",'read:groupe:etu','read:jury:prof','read:user','write:user','read:parcours:etudiant','read:classe:etudiant/professeur','read:bibliotheque:user','read:matiere:professeur','read:note:etudiant','read:absence:etudiant','read:passage:etudiant'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 1)]
    #[Groups(['read:user','write:user'])]
    private ?string $sexe = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:user','write:user'])]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:user','write:user','read:parcours:etudiant'])]
    private ?string $emailPrincipale = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:user','write:user'])]
    private ?string $emailSecondaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:user','write:user'])]
    private ?string $villeNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:user','write:user'])]
    private ?string $telephonePortable = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:user','write:user'])]
    private ?string $telephoneFixe = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:user','write:user'])]
    private ?string $adresse1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:user','write:user'])]
    private ?string $adresse2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:user','write:user'])]
    private ?string $villeResidence = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:user','write:user'])]
    private ?string $paysResidence = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['read:user','write:user'])]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:user','write:user'])]
    private ?string $codePostal = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[Groups(['read:user','write:user'])]
    private ?Profile $profile = null;

    #[ORM\ManyToMany(targetEntity: Institut::class, inversedBy: 'users')]
    #[Groups(['read:user','write:user'])]
    private Collection $instituts;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:user','write:user'])]
    private ?string $paysNaissance = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[Groups(['read:user','write:user'])]
    private ?Etablissement $etablissement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $personneUrgence = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pss = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }
    public function  __construct(){
        $this->instituts = new ArrayCollection();
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {

        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }


    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }


    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getEmailPrincipale(): ?string
    {
        return $this->emailPrincipale;
    }

    public function setEmailPrincipale(?string $emailPrincipale): self
    {
        $this->emailPrincipale = $emailPrincipale;

        return $this;
    }

    public function getEmailSecondaire(): ?string
    {
        return $this->emailSecondaire;
    }

    public function setEmailSecondaire(?string $emailSecondaire): self
    {
        $this->emailSecondaire = $emailSecondaire;

        return $this;
    }

    public function getVilleNaissance(): ?string
    {
        return $this->villeNaissance;
    }

    public function setVilleNaissance(?string $villeNaissance): self
    {
        $this->villeNaissance = $villeNaissance;

        return $this;
    }

    public function getTelephonePortable(): ?string
    {
        return $this->telephonePortable;
    }

    public function setTelephonePortable(?string $telephonePortable): self
    {
        $this->telephonePortable = $telephonePortable;

        return $this;
    }

    public function getTelephoneFixe(): ?string
    {
        return $this->telephoneFixe;
    }

    public function setTelephoneFixe(?string $telephoneFixe): self
    {
        $this->telephoneFixe = $telephoneFixe;

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

    public function getVilleResidence(): ?string
    {
        return $this->villeResidence;
    }

    public function setVilleResidence(?string $villeResidence): self
    {
        $this->villeResidence = $villeResidence;

        return $this;
    }

    public function getPaysResidence(): ?string
    {
        return $this->paysResidence;
    }

    public function setPaysResidence(?string $paysResidence): self
    {
        $this->paysResidence = $paysResidence;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

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
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
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
        }

        return $this;
    }

    public function removeInstitut(Institut $institut): self
    {
        $this->instituts->removeElement($institut);

        return $this;
    }

    public function getPaysNaissance(): ?string
    {
        return $this->paysNaissance;
    }

    public function setPaysNaissance(?string $paysNaissance): self
    {
        $this->paysNaissance = $paysNaissance;

        return $this;
    }

    public static function createFromPayload($id, array $payload){
        return (new User())->setId($id)->setLogin($payload['username']??'')->setRoles($payload['roles']??'');
    }

    /**
     * Set the value of id
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

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

    public function getPersonneUrgence(): ?string
    {
        return $this->personneUrgence;
    }

    public function setPersonneUrgence(?string $personneUrgence): self
    {
        $this->personneUrgence = $personneUrgence;

        return $this;
    }

    public function getPss(): ?string
    {
        return $this->pss;
    }

    public function setPss(?string $pss): self
    {
        $this->pss = $pss;

        return $this;
    }
}