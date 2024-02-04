<?php

namespace App\Controller;

use App\Entity\Sanction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SanctionController extends AbstractController
{
      public function __invoke(Request $request)
    {
        $file  = $request->files->get('file');
        $sanction = $request->attributes->get('data');
        if(!($sanction instanceof Sanction)){
            Throw new \RuntimeException("Sanction attendu");
        }
        $sanction->setFile($file);
        return $sanction;
    }
}
