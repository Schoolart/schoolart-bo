<?php

namespace App\Controller;

use App\Entity\Honoraire;
use App\Entity\Professeur;
use App\Repository\AnneeAcademicRepository;
use App\Repository\HonoraireRepository;
use App\Repository\InstitutRepository;
use App\Repository\MatiereRepository;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HonoraireController extends AbstractController
{
     public function __construct(private Pdf $knpSnappyPdf){

    }
    #[Route('/api/honoraire/{id}', name: 'app_honoraire')]
    public function Fiche(Professeur $professeur,Request $request,HonoraireRepository $honoRepo,InstitutRepository $instRepo,AnneeAcademicRepository $annRepo,MatiereRepository $matiereRepo): Response
    {
        $kernel = $this->getParameter('kernel');
        $data = $request->request;
        $institut= $instRepo->find($data->get('institut'));
        $annee = $annRepo->find($data->get('annee'));
        $matiere =  $matiereRepo->find($data->get('matiere'));
        if($professeur->getStatut()=="Externe"){
            $fiches = $honoRepo->findByDate($annee,$institut,$professeur,(new CarbonImmutable($data->get('dateDebut'),'Africa/Dakar'))->format('Y-m-d'),(new CarbonImmutable($data->get('dateFin'),'Africa/Dakar'))->format('Y-m-d'),$data->get('cycle'),$matiere);
            if(count($fiches) > 0){
                $html = $this->renderView('honoraire/index.html.twig', [
                    'kernel' => $kernel,
                    "institut"=>$institut,
                    "professeur"=>$professeur,
                    "annee"=>$annee,
                    'fiches'=>$fiches,
                    'matiere'=>$matiere,
                    'dateDebut'=>$data->get('dateDebut'),
                    "dateNow"=> (new \DateTime())->format("d/m/Y")
                ]);
                $options = [];
                $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
                $file = base64_encode($pdf);
                $json = json_encode(["file"=>$file], JSON_PRETTY_PRINT);
                return new JsonResponse($json, 200, [], true);
            }else{
                return new JsonResponse([], 500, []);
            }
        }else{
            $listeWeeks = [];
            $datedebut = new CarbonImmutable($data->get('dateDebut'),'Africa/Dakar');
            $datefin= new CarbonImmutable($data->get('dateFin'),'Africa/Dakar');
            $fichesGlobal = $honoRepo->findByDate($annee,$institut,$professeur,$data->get('dateDebut'),$data->get('dateFin'),$data->get('cycle'),$matiere);
            while ($datefin->diffInDays($datedebut)>0) {
                if(count($listeWeeks)==0){
                   $startWeek = $datedebut->format('Y-m-d');
                }else{
                    $startWeek = $datedebut->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
                }
                 $endWeek = $datedebut->endOfWeek(Carbon::FRIDAY)->format('Y-m-d');
                 $startWeekend = (new CarbonImmutable($endWeek,'Africa/Dakar'))->addDay()->format('Y-m-d');
                 $nextWeek =  $datedebut->endOfWeek(Carbon::SUNDAY)->format('Y-m-d');
                 array_push($listeWeeks,[ "startWeek" =>$startWeek , "endWeek" => $endWeek,"startWeekend" => $startWeekend,"endWeekend" => $nextWeek]);
                 $datedebut = (new CarbonImmutable($nextWeek,'Africa/Dakar'))->addDay();
            }
            $listeHeureByWeeks = [];
            foreach ($listeWeeks as $week) {
                $newItem =[];
                $count =0;
                $fiches = $honoRepo->findByDate($annee,$institut,$professeur,$week['startWeek'],$week['endWeek'],$data->get('cycle'),$matiere);
                $count = $this->heure($fiches);
                $montant = 0;
                if($count > 12){
                    $montant = $matiere->getTauxHoraireBrut() * ($count-12);
                }
                $newItem["heureHebdomadaire"] = $count <= 12 ? $count : 12 ;
                $newItem["heureComplementaire"] = $count > 12 ? ($count-12) : 0 ;
            //    $newItem["montantComplementaire"]= $montant;
                $fiches = $honoRepo->findByDate($annee,$institut,$professeur,$week['startWeekend'],$week['endWeekend'],$data->get('cycle'),$matiere);
                $count = $this->heure($fiches);
                $montant = (50000/7.5) * $count;
                $newItem["heureweekend"] = $count ;
               // $newItem["montantweekend"] = $montant;
                $newItem["startWeek"] = $week['startWeek'];
                $newItem["endWeek"] = $week['endWeek'];
                $newItem["startWeekend"] = $week['startWeekend'];
                $newItem["endWeekend"] = $week['endWeekend'];
                array_push($listeHeureByWeeks,$newItem);
            }
            $html = $this->renderView('honoraire/index.html.interne.twig', [
                    'kernel' => $kernel,
                    "institut"=>$institut,
                    "professeur"=>$professeur,
                    "annee"=>$annee,
                    'fiches'=>$fichesGlobal,
                    'matiere'=>$matiere,
                    'listeHeureByWeeks'=>$listeHeureByWeeks,
                    'dateDebut'=>$data->get('dateDebut'),
                    "dateNow"=> (new \DateTime())->format("d/m/Y")
            ]);
            $options = [];
            $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
            $file = base64_encode($pdf);
            $json = json_encode(["file"=>$file], JSON_PRETTY_PRINT);
            return new JsonResponse($json, 200, [], true);
        }

    }

    public static function heure(Array $liste ) {
       $count = 0;
       foreach ($liste as $key) {
         if($key instanceof Honoraire){
            $count += $key->getVhe();
         }
       }
       return $count;
    }
}
