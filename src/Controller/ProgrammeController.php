<?php

namespace App\Controller;

use App\Entity\AttesPassage;
use App\Entity\Classe;
use App\Entity\Periode;
use App\Repository\PeriodeRepository;
use App\Repository\RecapAnneeRepository;
use App\Repository\UeRepository;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgrammeController extends AbstractController
{
    public function __construct(private Pdf $knpSnappyPdf){

    }
    #[Route('/api/programme/{id}', name: 'app_programme')]
    public function passage(Classe $classe,UeRepository $ueRepo,Request $request,PeriodeRepository $periodeRepo): Response
    {

        $periode = $periodeRepo->find($request->request->get('periode'));
        $forEt = $request->request->get('forEtudiant');
        $kernel = $this->getParameter('kernel');
        if($forEt=="false"){
            $html = $this->renderView('programme/index.html.twig', [
                'classe' => $classe,
                'kernel' => $kernel,
                'ues'=>$ueRepo->findByClasseByPeriode($classe,$periode),
                'periode'=>$periode
            ]);
        }else{
            $html = $this->renderView('programme/index.forEt.html.twig', [
                'classe' => $classe,
                'kernel' => $kernel,
                'ues'=>$ueRepo->findByClasseByPeriode($classe,$periode),
                'periode'=>$periode
            ]);
        }
        $options = [
            'margin-top' => 0,
            'margin-right' => 0,
            'margin-bottom' => 0,
            'margin-left' => 0,
        ];
        $filename =  'Programme '.$classe->getNomClasse(). ' '.$classe->getNiveau()->getAnneeAcademic()->getLibelle();
        $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
        $file = base64_encode($pdf);
        $json = array("file" => $file, "filename" => $filename);
        $json = json_encode($json, JSON_PRETTY_PRINT);
        return new JsonResponse($json, 200, [], true);

    }
}
