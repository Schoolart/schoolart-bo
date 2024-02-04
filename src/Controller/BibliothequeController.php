<?php

namespace App\Controller;

use App\Entity\Bibliotheque;
use App\Repository\BibliothequeRepository;
use App\Service\Generate_pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BibliothequeController extends AbstractController
{
    public function __invoke(Request $request)
    {
        $file  = $request->files->get('file');
        $bibliotheque = $request->attributes->get('data');
        if(!($bibliotheque instanceof Bibliotheque)){
            Throw new \RuntimeException("fichier attendu");
        }
        $bibliotheque->setFile($file);
        return $bibliotheque;
    }

    #[Route('/api/bibliotheque/file', name: 'app_bibliotheque_file',methods:["POST"])]
    public function Bibiotheque(Request $request,BibliothequeRepository $repo): Response
    {
        $data = $request->request;
        $ids =  $data->get("ids");
        $json = array();
        foreach (explode(";",$ids) as $id){
            if($id!=""){
                $bibliotheque = $repo->find(intval($id));
                $pdf =file_get_contents($this->getParameter("bibliotheque_directory")."/".$bibliotheque->getFilename(),FILE_USE_INCLUDE_PATH);
                $file = base64_encode($pdf);
                array_push($json,array(
                    "topic"=>$bibliotheque->getTopic()->getIntitule(),
                    "file"=>$file,
                    'typeDocument'=>$bibliotheque->getTypeDocument()->getIntitule(),
                    "filename"=>$bibliotheque->getNom().".".explode(".",$bibliotheque->getFilename())[1]
                ));
            }
        }
        $json = json_encode($json,JSON_PRETTY_PRINT);
        return new JsonResponse($json,200,[],true);
    }
}
