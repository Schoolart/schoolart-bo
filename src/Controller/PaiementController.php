<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Entity\SoldeEtudiant;
use App\Repository\FactureEtudiantRepository;
use App\Repository\PaiementRepository;
use App\Repository\SoldeEtudiantRepository;
use App\Service\ContactNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use function DeepCopy\deep_copy;

class PaiementController extends AbstractController
{
    public function __invoke(Paiement $data,SoldeEtudiantRepository $soldeRepo,PaiementRepository $repo,FactureEtudiantRepository $factureRepo, ContactNotification $contact)
    {
        if($data instanceof Paiement){
            $factures = $factureRepo->findBySolder($data->getAnneeAcademic(),$data->getClasse(),$data->getEtudiant(),false);
            $montantPayer = deep_copy($data->getMontantTemp());
            foreach ($factures as &$facture){
                if($facture->getMontant()<=$montantPayer){
                    $montantPayer -=$facture->getMontant();
                    $facture->setSolder(true);
                }
            }
            $data->setCode(count($repo->findAll())+1);
            $solde  = $soldeRepo->findOneBy(["etudiant"=>$data->getEtudiant(),"anneeAcademic"=>$data->getAnneeAcademic(),"institut"=>$data->getInstitut()]);
            if($solde){
                if($data->getMontant()==0){
                    $solde->setSoldePaiement($solde->getSoldePaiement()+$data->getMontantTemp()-$data->getMontant());
                }else{
                    $solde->setSoldePaiement($solde->getSoldePaiement()+$data->getMontantTemp()-$data->getMontant());
                }
            }else{
                $solde  = (new SoldeEtudiant())->setEtudiant($data->getEtudiant())->setAnneeAcademic($data->getAnneeAcademic())->setInstitut($data->getInstitut());
                $solde->setSoldePaiement($solde->getSoldePaiement()+$data->getMontantTemp()-$data->getMontant());
            }
            $solde->setSolde($solde->getSoldePaiement()-$solde->getSoldeEcheance());
            $data->setMontant($data->getMontantTemp());
        }
        if(str_contains($data->getLibelle() ,"DI 1" )){
            $contact->NewEtudiantOfficielNotify($data->getEtudiant(),$data->getInstitut(),$this->getParameter('kernel'));
        }else{
            $contact->SendRecu($data,$data->getInstitut(),$this->getParameter('kernel'));

        }
        return $data;

    }
}
