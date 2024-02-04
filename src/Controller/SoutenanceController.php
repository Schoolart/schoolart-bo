<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Institut;
use App\Entity\Soutenance;
use App\Repository\AnneeAcademicRepository;
use App\Repository\InstitutRepository;
use App\Repository\PlanningRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SoutenanceController extends AbstractController
{
    public function __construct(private AnneeAcademicRepository $anneeAcademicRepository ,private InstitutRepository $institutRepository, private Pdf $knpSnappyPdf ,private EntityManagerInterface $em)
    {
    }
    public function __invoke(Request $request)
    {
        $file  = $request->files->get('file');
        $soutenance = $request->attributes->get('data');
        if(!($soutenance instanceof Soutenance)){
            Throw new \RuntimeException("Soutenance attendu");
        }
        $soutenance->setVichFile($file);
        return $soutenance;
    }
    #[Route('/api/planning', name: 'app-planning')]
    public function planning(Request $request,PlanningRepository $planRepo): Response
    {
        $kernel = $this->getParameter('kernel');
        $data  = $request->request;
        $annee = $this->anneeAcademicRepository->find($data->get('anneeAcademic'));
        $institut= $this->institutRepository->find($data->get('institut'));
        $seances = $planRepo->findBy(['institut'=>$institut,'AnneeAcademic']);
        if($seances) {
            $html = $this->renderView('soutenance/index.html.twig', [
                'annee' => $annee,
                'institut' => $institut,
                'kernel' => $kernel,
                'seances'=>$seances
            ]);
            $options = [
                'margin-top' => 0,
                'margin-right' => 0,
                'margin-bottom' => 0,
                'margin-left' => 0,
                'page-size' => 'A4'


            ];
            $filename ="Fiche de suivi de mémoire".'_' . (new \DateTime())->getTimestamp();
            $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
            $file = base64_encode($pdf);
            $facture = (new Facture())->setFile($file)->setFileName($filename)->setDate(new \DateTime());
            $this->em->persist($facture);
            $this->em->flush();
            $json = array("id" => $facture->getId(), "file" => $facture->getFile(), "filename" => $facture->getFileName());
            $json = json_encode($json, JSON_PRETTY_PRINT);
            return new JsonResponse($json, 200, [], true);
        }
        return new JsonResponse(null, 200, [], true);
    }
}
