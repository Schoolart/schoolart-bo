<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken as BaseRefreshToken;

#[ORM\Entity]
#[ApiResource]
#[ORM\Table("refresh_tokens")]
class RefreshToken extends BaseRefreshToken
{
}
