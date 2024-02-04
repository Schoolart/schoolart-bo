<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
#[ApiResource]
#[ApiFilter(
    searchFilter::class,
    properties: [
        'etablissement'=>"exact"
    ]
)]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:user:profile'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:user:profile'])]
    private ?string $intitule = null;

    #[ORM\Column]
    #[Groups(['read:user:profile'])]
    private array $roles = [];

    #[ORM\OneToMany(mappedBy: 'profile', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'profile', targetEntity: Droit::class,cascade: ["persist","remove"])]
    private Collection $droits;

    #[ORM\ManyToOne(inversedBy: 'profiles')]
    private ?Etablissement $etablissement = null;



    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->droits = new ArrayCollection();
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
            $user->setProfile($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfile() === $this) {
                $user->setProfile(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Droit>
     */
    public function getDroits(): Collection
    {
        return $this->droits;
    }

    public function addDroit(Droit $droit): self
    {
        if (!$this->droits->contains($droit)) {
            $this->droits->add($droit);
            $droit->setProfile($this);
        }

        return $this;
    }

    public function removeDroit(Droit $droit): self
    {
        if ($this->droits->removeElement($droit)) {
            // set the owning side to null (unless already changed)
            if ($droit->getProfile() === $this) {
                $droit->setProfile(null);
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

}
