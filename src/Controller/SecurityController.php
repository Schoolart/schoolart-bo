<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function apiLogin(): Response
    {
        $user = $this->getUser();
        if ($user instanceof User) {
            return $this->json([
                'id' => $user->getId(),
                'username' => $user->getUserIdentifier(),
                'password' => $user->getPassword(),
                'roles' =>   $user->getRoles(),

            ]);
        }else {
            return $this->json([]);
        }
    }

}
