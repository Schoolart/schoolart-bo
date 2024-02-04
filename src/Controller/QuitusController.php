<?php

namespace App\Controller;

use App\Entity\AttesPassage;
use App\Entity\ParametrageFraisScolariteEtab;
use App\Entity\ParametrageFraisScolariteEtud;
use App\Entity\ParametrageFraisScolariteNiv;
use App\Entity\Quitus;
use App\Repository\AnneeAcademicRepository;
use App\Repository\ClasseRepository;
use App\Repository\EtudiantRepository;
use App\Repository\InstitutRepository;
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

class QuitusController extends AbstractController
{
    private String $public;
    private String $template;
    private Pdf $knpSnappyPdf;
    private InstitutRepository $institutRepository;
    private ClasseRepository $classeRepository;
    private AnneeAcademicRepository $anneeAcademicRepository;
    private EtudiantRepository $etudiantRepository;
    private EntityManagerInterface $em;
    public function __construct(Pdf $knpSnappyPdf,private ParametrageFraisScolariteEtabRepository  $parametabRepo,
        private ParametrageFraisScolariteNivRepository $paramnivRepo,private ParametrageFraisScolariteEtudRepository $parametudRepo
        ,private SoldeEtudiantRepository $soldeRepo,EntityManagerInterface $em,EtudiantRepository $etudiantRepository,AnneeAcademicRepository $anneeAcademicRepository,InstitutRepository $institutRepository,ClasseRepository $classeRepository){

        $this->knpSnappyPdf = $knpSnappyPdf;
        $this->institutRepository = $institutRepository;
        $this->classeRepository=$classeRepository;
        $this->anneeAcademicRepository = $anneeAcademicRepository;
        $this->etudiantRepository = $etudiantRepository;
        $this->em = $em;
    }
    #[Route('/api/quitus', name: 'app_quitus')]
    public function quitus(Request $request): Response
    {
        $kernel = $this->getParameter('kernel');
        $data  = $request->request;
        $etudiant = $this->etudiantRepository->find($data->get('etudiant'));
        $classe = $this->classeRepository->find($data->get('classe'));
        $annee = $this->anneeAcademicRepository->find($data->get('anneeAcademic'));
        $institut= $this->institutRepository->find($data->get('institut'));
        $specialisation = $classe->getSpecialisation();
        $solde=$this->soldeRepo->findOneBy(['etudiant'=>$etudiant,"anneeAcademic"=>$annee,"institut"=>$institut]);
        if($solde->getSolde()>=0) {
            $paramsEtab = $this->parametabRepo->findByDate($institut, $annee);
            $paramsNiv = $this->paramnivRepo->findByDate($institut, $annee, $classe->getNiveau());
            $paramsEtud = $this->parametudRepo->findByDate($institut, $annee, $etudiant, $classe);
            $soldeAdate = 0;
            foreach ($paramsEtab as $item) {
                $soldeAdate += $item->getMontant();
            }
            foreach ($paramsNiv as $item) {
                $soldeAdate += $item->getMontant();
            }
            foreach ($paramsEtud as $item) {
                $soldeAdate += $item->getMontant();
            }
            if ($solde) {
                $html = $this->renderView('quitus/index.html.twig', [
                    'annee' => $annee,
                    'classe' => $classe,
                    'institut' => $institut,
                    'specialisation' => $specialisation,
                    'etudiant' => $etudiant,
                    'kernel' => $kernel,
                    'solde' => $solde,
                    'soldeAdate' => $soldeAdate
                ]);
                $options = [
                    'margin-top' => 0,
                    'margin-right' => 0,
                    'margin-bottom' => 0,
                    'margin-left' => 0,
                    'page-size' => 'A6'


                ];
                $filename = $etudiant->getPrenom() . " " . $etudiant->getNom() . '_' . (new \DateTime())->getTimestamp();
                $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
                $file = base64_encode($pdf);
                $quitus = (new Quitus())->setFile($file)->setFileName($filename)->setEtudiant($etudiant)->setAnneeAcademic($annee)->setInstitut($institut)->setDate(new \DateTime());
                $this->em->persist($quitus);
                $this->em->flush();
                $json = array("id" => $quitus->getId(), "file" => $quitus->getFile(), "filename" => $quitus->getFileName());
                $json = json_encode($json, JSON_PRETTY_PRINT);
                return new JsonResponse($json, 200, [], true);
            }
        }
        return new JsonResponse(null, 200, [], true);
    }
}
