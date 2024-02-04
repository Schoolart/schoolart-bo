<?php
namespace App\Controller;

use App\Entity\Institut;
use App\Entity\User;
use PhpParser\Node\Expr\Throw_;
use Spipu\Html2Pdf\Tag\Html\Ins;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstitutController {

    public function __invoke(Request $request)
    {
        $file  = $request->files->get('file');
        $institut = $request->attributes->get('data');
        if(!($institut instanceof Institut)){
            Throw new \RuntimeException("Institut attendu");
        }
        $institut->setImage($file);
        return $institut;
    }
    #[Route('/api/etablissement/{id}', name: 'app_etablissement')]
    public function recu(User $user,Request $request): Response
    {
        $etablissement = $user->getInstituts()->getValues()[0]->getEtablissement();
        $json = json_encode($etablissement, JSON_PRETTY_PRINT);
        return new JsonResponse($json, 200, [], true);
    }
}