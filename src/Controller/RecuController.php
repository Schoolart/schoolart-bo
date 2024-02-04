<?php

namespace App\Controller;

use App\Entity\Quitus;
use App\Entity\Recu;
use App\Repository\AnneeAcademicRepository;
use App\Repository\ClasseRepository;
use App\Repository\EtudiantRepository;
use App\Repository\InstitutRepository;
use App\Repository\PaiementRepository;
use App\Repository\ParametrageFraisScolariteEtabRepository;
use App\Repository\ParametrageFraisScolariteEtudRepository;
use App\Repository\ParametrageFraisScolariteNivRepository;
use App\Repository\SoldeEtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecuController extends AbstractController
{
    private String $public;
    private String $template;
    private Pdf $knpSnappyPdf;
    private InstitutRepository $institutRepository;
    private ClasseRepository $classeRepository;
    private AnneeAcademicRepository $anneeAcademicRepository;
    private EtudiantRepository $etudiantRepository;
    private EntityManagerInterface $em;
    public function __construct(Pdf $knpSnappyPdf,private PaiementRepository $repo,EntityManagerInterface $em){

        $this->knpSnappyPdf = $knpSnappyPdf;
        $this->em = $em;
    }
    #[Route('/api/recu', name: 'app_recu')]
    public function recu(Request $request): Response
    {
        $kernel = $this->getParameter('kernel');
        $data  = $request->request;
        $paiement = $this->repo->find($data->get('paiement'));
        if($paiement) {
            if(!$paiement->getRecu()) {
                $html = $this->renderView('recu/index.html.twig', [
                    'paiement' => $paiement,
                    'kernel'=>$kernel
                ]);
                $options = [
                    'margin-top' => 0,
                    'margin-right' => 0,
                    'margin-bottom' => 0,
                    'margin-left' => 0,
                    'page-size' => 'A6'


                ];
                $filename = $paiement->getEtudiant()->getPrenom() . "_" .  $paiement->getEtudiant()->getNom() . '_reçu_' . $paiement->getCode();
                $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
                $file = base64_encode($pdf);
                $recu = (new Recu())->setFile($file)->setFileName($filename)->setDate(new \DateTime());
                $paiement->setRecu($recu);
                $this->em->flush();
            }
            $json = array("id" =>  $paiement->getRecu()->getId(), "file" => $paiement->getRecu()->getFile(), "filename" =>$paiement->getRecu()->getFileName());
            $json = json_encode($json, JSON_PRETTY_PRINT);
            return new JsonResponse($json, 200, [], true);
        }
        return new JsonResponse(null, 200, [], true);
    }
}
