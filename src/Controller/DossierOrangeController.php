<?php

namespace App\Controller;

use Knp\Snappy\Pdf;
use App\Entity\Etudiant;
use App\Repository\ClasseRepository;
use App\Repository\InstitutRepository;
use App\Repository\ParcoursRepository;
use App\Repository\AnneeAcademicRepository;
use App\Repository\BulletinRepository;
use App\Repository\PaiementRepository;
use App\Repository\SanctionRepository;
use App\Repository\SoldeEtudiantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DossierOrangeController extends AbstractController
{
    public function __construct(private Pdf $knpSnappyPdf){

    }
    #[Route('/api/dossier_orange/{id}', name: 'app_dossier_orange')]
    public function Dossier(Etudiant $etudiant,Request $request,ParcoursRepository $parcoursRepo,
    ClasseRepository $classeRepo,InstitutRepository $instRepo,AnneeAcademicRepository $annRepo,
    SoldeEtudiantRepository $soldeRepo, PaiementRepository $paiementRepository,SanctionRepository $sanctionRepo,BulletinRepository $bulletinRepo): Response
    {
        $kernel = $this->getParameter('kernel');
        $data = $request->request;
       /* $institut = $instRepo->find($data->get('institut'));
        $annee = $annRepo->find($data->get('annee'));
        */
        $institut = $instRepo->find($data->get('institut'));
        $annee = $annRepo->find($data->get('annee'));
        $classe =  $classeRepo->find($data->get('classe'));
        $parcours = $parcoursRepo->findBy(["etudiant"=>$etudiant]);
        $recaps = array();
        foreach ($parcours as $key1) {
            $semestre1 = explode (' / ' ,$key1->getPeriode()->getLibelle())[0];
            $recaps[$semestre1]=$key1;
            foreach ($parcours as $key2) {
                $semestre2 = explode (' / ' ,$key2->getPeriode()->getLibelle())[0];
                if($semestre1 == $semestre2 and explode (' / ' ,$key2->getPeriode()->getLibelle())[1]=="Session 2"){
                    $recaps[$semestre1]=$key2;
                }
            }
        }
        $total=[0,0];
        foreach ($recaps as $item) {
            $total[0] += $item->getMoyenne();
            $total[1] += $item->getCreditCapitalise();
        }
        $total[0] = $total[0]/count($recaps);
        $soldes = $soldeRepo->findBy(["etudiant"=>$etudiant]);
        $paiements = $paiementRepository->findBy(["etudiant"=>$etudiant]);
        $sanctions = $sanctionRepo->findBy(['etudiant'=>$etudiant]);
        $bulletins = $bulletinRepo->findBy(['etudiant'=>$etudiant,"classe"=>$classe]);
        if($etudiant){
            $html = $this->renderView('dossier_orange/index.html.twig', [
                'kernel' => $kernel,
                "institut"=> $institut,
                "etudiant"=>$etudiant,
                "annee"=>$annee,
                "parcours"=>$parcours,
                'soldes'=>$soldes,
                'paiements'=>$paiements,
                'sanctions'=>$sanctions,
                "classe"=>$classe,
                "bulletins"=>$bulletins,
                "total"=>$total,
                "dateNow"=> (new \DateTime())->format("d/m/Y")
            ]);
            $headerHtml = $this->renderView(
            'dossier_orange/header.html.twig', [
                "etudiant"=>$etudiant,
                "classe"=>$classe
            ]);
            $options = [
                'margin-top' => 8,
                'margin-right' => 0,
                'margin-bottom' => 8,
                'margin-left' => 0,
                'page-size' => 'A4',
                "image-quality"=>100,
                'footer-center'=>"[page]/[topage]",
            ];
            $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
            //return new PdfResponse($pdf);
            $file = base64_encode($pdf);
            $json = json_encode(["file"=>$file], JSON_PRETTY_PRINT);
            return new JsonResponse($json, 200, [], true);
        }else{
            return new JsonResponse([], 500, [], true);
        }

    }
}
