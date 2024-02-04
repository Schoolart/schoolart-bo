<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CertificatScolariteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CertificatScolariteRepository::class)]
#[ApiResource]
class CertificatScolarite extends Attestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
