<?php

namespace App\Controller;

use App\Entity\AnneeAcademic;
use App\Entity\AttesPassage;
use App\Entity\Etudiant;
use App\Entity\Institut;
use App\Repository\AnneeAcademicRepository;
use App\Repository\ClasseRepository;
use App\Repository\EtudiantRepository;
use App\Repository\InstitutRepository;
use App\Repository\PaiementRepository;
use App\Service\Generate_pdf;
use Doctrine\ORM\EntityManagerInterface;
use DOMDocument;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Snappy\Pdf;
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Label\Font\NotoSans;


class CarteEtudiantController extends AbstractController
{
    private String $public;
    private String $template;
    private Pdf $knpSnappyPdf;
    private InstitutRepository $institutRepository;
    private ClasseRepository $classeRepository;
    private AnneeAcademicRepository $anneeAcademicRepository;
    private EtudiantRepository $etudiantRepository;
    private EntityManagerInterface $em;
    public function __construct(Pdf $knpSnappyPdf,EntityManagerInterface $em,EtudiantRepository $etudiantRepository,AnneeAcademicRepository $anneeAcademicRepository,InstitutRepository $institutRepository,ClasseRepository $classeRepository){

        $this->knpSnappyPdf = $knpSnappyPdf;
        $this->institutRepository = $institutRepository;
        $this->classeRepository=$classeRepository;
        $this->anneeAcademicRepository = $anneeAcademicRepository;
        $this->etudiantRepository = $etudiantRepository;
        $this->em = $em;
    }
    #[Route('/api/carte/etudiant', name: 'app_carte_etudiant',methods:["POST"])]
    public function carte(Request $request,Generate_pdf $generate_pdf,PaiementRepository $paiementRepo): Response
    {
        $kernel = $this->getParameter('kernel');
        $photo = 'data:image/png;base64,' .base64_encode(file_get_contents($kernel."/public/assets/person.webp", FILE_USE_INCLUDE_PATH));
        $logo = 'data:image/png;base64,' .base64_encode(file_get_contents($kernel."/public/assets/person.webp", FILE_USE_INCLUDE_PATH));
        $data  = $request->request;
        $etudiant = $this->etudiantRepository->find($data->get('etudiant'));
        $classe = $this->classeRepository->find($data->get('classe'));
        $niveau = explode(' ',$classe->getNiveau()->getIntitule())[0];
        $annee = $this->anneeAcademicRepository->find($data->get('anneeAcademic'));
        $institut = $this->institutRepository->find($data->get('institut'));
        //if($paiementRepo->findOneBy(['etudiant'=>$etudiant,'anneeAcademic'=>$annee,"institut"=>$institut])
        //){
            if($etudiant->getAvatar()){
                $photo = 'data:image/' . explode('.',$etudiant->getAvatar())[1]. ';base64,' .base64_encode(file_get_contents($this->getParameter("avatars_directory")."/".$etudiant->getAvatar(), FILE_USE_INCLUDE_PATH));
            }
            if($etudiant->getInstituts()[0]->getLogo()){
                $logo = 'data:image/' . explode('.',$etudiant->getInstituts()[0]->getLogo())[1]. ';base64,' .base64_encode(file_get_contents($this->getParameter("instituts_directory")."/".$etudiant->getInstituts()[0]->getLogo(), FILE_USE_INCLUDE_PATH));

            }
            $filename = $etudiant->getPrenom() . " " . $etudiant->getNom() . '_' . (new \DateTime())->getTimestamp();
            $carteGenerate = $generate_pdf->generate(self::qrcodeGenerator($kernel,$etudiant, $institut, $annee),$filename,$annee, $classe, $institut,$etudiant,$photo,$logo)->toArray();
            $id=$carteGenerate["document"]["id"];
            sleep(4);
            $info = $generate_pdf->getPdf($id)->toArray();
            $lien = $info["document_card"]["download_url"];
            $pdf = file_get_contents($lien);
            $generate_pdf->deletePdf($id);
            $file = base64_encode($pdf);
            $json = array( "filename" => $filename , "file"=> $file);
            $json = json_encode($json,JSON_PRETTY_PRINT);
            return new JsonResponse($json,200,[],true);
        //}else {
        //   return new JsonResponse([],500,[]);
        //}

    }
    #[Route('/carte/recto', name: 'app_carte_recto')]
    public function indexR(Request $request): Response
    {
        $kernel = $this->getParameter('kernel');
        return $this->render('carte_etudiant/index.recto.html.twig', [
            'controller_name' => 'CarteEtudiantController',
            'kernel'=> $kernel
        ]);
    }
    #[Route('/carte/verso', name: 'app_carte_verso')]
    public function indexV(Request $request): Response
    {
        $kernel = $this->getParameter('kernel');
        return $this->render('carte_etudiant/index.verso.html.twig', [
            'controller_name' => 'CarteEtudiantController',
            'kernel'=> $kernel
        ]);
    }
    public function qrcodeGenerator(string $kernel,Etudiant $etudiant,Institut $institut,AnneeAcademic $anneeAcademic):string{
        $writer = new PngWriter();
        $info = $etudiant->getId().'/'.$institut->getId().'/'.$anneeAcademic->getId();
        $qrCode = QrCode::create($this->getParameter('client_url')."/".$this->getParameter('base_qrcode')."/".base64_encode($info))
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(500)
            ->setMargin(0)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
        $logo = Logo::create($kernel.'/public/images/instituts/'.$institut->getLogo())
            ->setResizeToWidth(60);
        $label = Label::create('')->setFont(new NotoSans(8));
        return $writer->write(
            $qrCode
        )->getDataUri();
    }
}
