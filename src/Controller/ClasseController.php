<?php

namespace App\Controller;

use App\Repository\AnneeAcademicRepository;
use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClasseController extends AbstractController
{
    public function __construct(private ClasseRepository $classeRepo,private AnneeAcademicRepository $anneeRepo){

    }
    #[Route('/api/classe', name: 'app_classe')]
    public function index(Request $request): Response
    {
        $data = $request->request;
        $annee =  $this->anneeRepo->find($data->get('annee'));
        $classes=[];
        if($this->classeRepo->find($data->get('niveau'))){
            return new JsonResponse(json_encode($this->classeRepo->findBy(['niveau'=>$data->get('niveau')])),200);
        }
        foreach ($annee->getNiveaux() as $niveau){
           array_push($classes,$this->classeRepo->findBy(['niveau'=>$niveau]));
        }
        return $this->render('classe/index.html.twig', [
            'controller_name' => 'ClasseController',
        ]);
    }
}
