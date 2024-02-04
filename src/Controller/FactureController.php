<?php

namespace App\Controller;

use App\Entity\AnneeAcademic;
use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Entity\Facture;
use App\Entity\FactureEtudiant;
use App\Entity\Institut;
use App\Entity\ParametrageFraisScolarite;
use App\Entity\Quitus;
use App\Repository\AnneeAcademicRepository;
use App\Repository\ClasseRepository;
use App\Repository\EtudiantRepository;
use App\Repository\FactureEtudiantRepository;
use App\Repository\InstitutRepository;
use App\Repository\ParametrageFraisScolariteEtabRepository;
use App\Repository\ParametrageFraisScolariteEtudRepository;
use App\Repository\ParametrageFraisScolariteNivRepository;
use App\Repository\ParametrageFraisScolariteRepository;
use App\Repository\SoldeEtudiantRepository;
use App\Service\ContactNotification;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FactureController extends AbstractController
{
    private String $public;
    private String $template;
    private Pdf $knpSnappyPdf;
    private InstitutRepository $institutRepository;
    private ClasseRepository $classeRepository;
    private AnneeAcademicRepository $anneeAcademicRepository;
    private EtudiantRepository $etudiantRepository;
    private string $kernel;
    private EntityManagerInterface $em;
    public function __construct(Pdf $knpSnappyPdf,private FactureEtudiantRepository $factureRepo,private FactureEtudiantRepository $paramRepo,private ParametrageFraisScolariteEtabRepository  $parametabRepo,
                                private ParametrageFraisScolariteNivRepository $paramnivRepo,private ParametrageFraisScolariteEtudRepository $parametudRepo
        ,private SoldeEtudiantRepository $soldeRepo,EntityManagerInterface $em,EtudiantRepository $etudiantRepository,AnneeAcademicRepository $anneeAcademicRepository,InstitutRepository $institutRepository,ClasseRepository $classeRepository){
        $this->knpSnappyPdf = $knpSnappyPdf;
        $this->institutRepository = $institutRepository;
        $this->classeRepository=$classeRepository;
        $this->anneeAcademicRepository = $anneeAcademicRepository;
        $this->etudiantRepository = $etudiantRepository;
        $this->em = $em;
    }
    #[Route('/api/facture', name: 'app-facture')]
    public function facture(Request $request): Response
    {
        $data  = $request->request;
        $etudiant = $this->etudiantRepository->find($data->get('etudiant'));
        $classe = $this->classeRepository->find($data->get('classe'));
        $annee = $this->anneeAcademicRepository->find($data->get('anneeAcademic'));
        $institut= $this->institutRepository->find($data->get('institut'));
        $facture = $this->paramRepo->find($data->get('facture'));
        if($this->generateFacture($etudiant,$classe,$annee,$institut,$facture)){
            $filename = $etudiant->getPrenom() . " " . $etudiant->getNom();
            $file = base64_encode($this->generateFacture($etudiant,$classe,$annee,$institut,$facture));
            $facture = (new Facture())->setFile($file)->setFileName($filename)->setDate(new \DateTime());
            $this->em->persist($facture);
            $this->em->flush();
            $json = array("id" => $facture->getId(), "file" => $file, "filename" => $filename);
            $json = json_encode($json, JSON_PRETTY_PRINT);
            return new JsonResponse($json, 200, [], true);
        }
        return new JsonResponse(null, 200, [], true);
    }
    #[Route('/api/facture/send', name: 'app-facture-send')]
    public function sendfacture(Request $request,ContactNotification $notif): Response
    {
        $data  = $request->request;
        $etudiant = $this->etudiantRepository->find($data->get('etudiant'));
        $classe = $this->classeRepository->find($data->get('classe'));
        $annee = $this->anneeAcademicRepository->find($data->get('anneeAcademic'));
        $institut= $this->institutRepository->find($data->get('institut'));
        $facture = $this->paramRepo->find($data->get('facture'));
        if($this->generateFacture($etudiant,$classe,$annee,$institut,$facture)){
            $filename = $etudiant->getPrenom() . " " . $etudiant->getNom();
            //file_put_contents($this->getParameter('facture_directory').'/'.$filename.'.pdf', $pdf);
            $notif->SendFacture( $facture , $this->generateFacture($etudiant,$classe,$annee,$institut,$facture) , $institut , $this->getParameter('kernel'),$filename);
            return new JsonResponse([], 200, []);
        }
        return new JsonResponse(null, 200, [], true);
    }

    /**
     * Get the value of kernel
     *
     * @return string
     */
    public function getKernel(): string
    {
        return $this->kernel;
    }

    /**
     * Set the value of kernel
     *
     * @param string $kernel
     *
     * @return self
     */
    public function setKernel(string $kernel): self
    {
        $this->kernel = $kernel;

        return $this;
    }
    public function generateFacture(Etudiant $etudiant, Classe $classe, AnneeAcademic $annee,Institut $institut,FactureEtudiant $facture)
    {
        $this->kernel =  $this->getParameter('kernel');
        $specialisation = $classe->getSpecialisation();
        $solde=$this->soldeRepo->findOneBy(['etudiant'=>$etudiant,"anneeAcademic"=>$annee,"institut"=>$institut]);
        $paramsEtab = $this->parametabRepo->findByDate($institut,$annee);
        $paramsNiv = $this->paramnivRepo->findByDate($institut,$annee,$classe->getNiveau());
        $paramsEtud = $this->parametudRepo->findByDate($institut,$annee,$etudiant,$classe);
        $soldeAdate=0;
        $factures = $this->factureRepo->findByDate($annee ,$classe,$etudiant,false,new \DateTime());
        $factures = array_splice($factures ,array_search($facture , $factures)+1,1);
        foreach ($paramsEtab  as $item){
            $soldeAdate +=$item->getMontant();
        }
        foreach ($paramsNiv  as $item){
            $soldeAdate +=$item->getMontant();
        }
        foreach ($paramsEtud  as $item){
            $soldeAdate +=$item->getMontant();
        }
        if($solde) {
            $html = $this->renderView('facture/index.html.twig', [
                'annee' => $annee,
                'classe' => $classe,
                'institut' => $institut,
                'specialisation' => $specialisation,
                'etudiant' => $etudiant,
                'kernel' => $this->kernel,
                'solde'=>$solde,
                'soldeAdate'=>$soldeAdate,
                "facture"=>$facture,
                "factures"=>$factures
            ]);
            $options = [
                'margin-top' => 0,
                'margin-right' => 0,
                'margin-bottom' => 0,
                'margin-left' => 0,
                'page-size' => 'A4'


            ];
            return $this->knpSnappyPdf->getOutputFromHtml($html, $options);
        }
        return null;
    }
}
