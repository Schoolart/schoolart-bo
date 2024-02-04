<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Contrat;
use App\Entity\FicheIdentification;
use App\Repository\AdminRepository;
use App\Repository\ContratRepository;
use App\Repository\FicheIdentificationRepository;
use App\Repository\PeriodeRepository;
use App\Repository\UeRepository;
use App\Service\Generate_pdf;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FicheIdentificationController extends AbstractController
{
    public function __construct(private Pdf $knpSnappyPdf){

    }
    #[Route('/api/fiches', name: 'app_fiche_identification')]
    public function Fiche(Request $request,FicheIdentificationRepository $ficheRepo): Response
    {
        $kernel = $this->getParameter('kernel');
        $fiche = $ficheRepo->find($request->request->get('fiche'));
        $html = $this->renderView('fiche_identification/index.html.twig', [
            'kernel' => $kernel,
            'fiche'=>$fiche,
            "dateNow"=> (new \DateTime())->format("d/m/Y")
        ]);
        $options = [];
        $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
        $file = base64_encode($pdf);
        $json = json_encode(["file"=>$file], JSON_PRETTY_PRINT);
        return new JsonResponse($json, 200, [], true);


    }
    #[Route('/api/contrat', name: 'app_contrat')]
    public function Contrat(Request $request,FicheIdentificationRepository $ficheRepo,AdminRepository $adminRepo ,ContratRepository $contratReppo ,EntityManagerInterface $em): Response
    {
        $kernel = $this->getParameter('kernel');
        $fiche = $ficheRepo->find($request->request->get('fiche'));
        $user = $adminRepo->find($request->request->get('userCreate'));
        $matieres  = $fiche->getMatieres();
        foreach ($matieres as &$matiere) {
            $matiere->setProfesseur($fiche->getProfesseur());
            $fiche->getProfesseur()->addClass($matiere->getClasse());
            $matiere->setTauxHoraireBrut($fiche->getTauxHoraireBrut());
            $matiere->setCycle($fiche->getCycleIntervention());
            $em->flush();
        }
        $html = $this->renderView('contrat/index.html.twig', [
            'kernel' => $kernel,
            'fiche'=>$fiche,
            "dateNow"=> (new \DateTime())->format("d/m/Y")
        ]);
        $options = [
            'margin-top' => 15,
            'margin-right' => 15,
            'margin-bottom' => 15,
            'margin-left' => 15,
            'page-size' => 'A4',
            "image-quality"=>100,
            'footer-center'=>"[page]/[topage]",
        ];
        $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
        $file = base64_encode($pdf);
        $json = json_encode(["file"=>$file], JSON_PRETTY_PRINT);
        $contrat = (new Contrat())->setDate(new \DateTime())
        ->setInstitut($fiche->getInstitut())
        ->setAnneeAcademic($fiche->getAnneeAcademic())
        ->setProfesseur($fiche->getProfesseur())
        ->setNumeroContrat($fiche->getNumeroContrat())
        ->setUserContratCreate($user)
        ->setFile($file)
        ->setCycleIntervention($fiche->getCycleIntervention());
        $em->persist($contrat);
        $em->flush();
        return new JsonResponse($json, 200, [], true);

    }
}
