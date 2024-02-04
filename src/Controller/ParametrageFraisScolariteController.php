<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\FactureEtudiant;
use App\Entity\Paiement;
use App\Entity\ParametrageFraisScolarite;
use App\Entity\ParametrageFraisScolariteEtab;
use App\Entity\ParametrageFraisScolariteEtud;
use App\Entity\ParametrageFraisScolariteNiv;
use App\Entity\SoldeEtudiant;
use App\Repository\FactureEtudiantRepository;
use App\Repository\PaiementRepository;
use App\Repository\SoldeEtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParametrageFraisScolariteController extends AbstractController
{
    public function __invoke(ParametrageFraisScolarite $data,Request $request,SoldeEtudiantRepository $soldeRepo,FactureEtudiantRepository $factureRepo,EntityManagerInterface $em)
    {
        $numeroFactureActu = count($factureRepo->findBy(["anneeAcademic"=>$data->getAnneeAcademic()]));
        if($data instanceof ParametrageFraisScolariteEtab){
            foreach ($data->getAnneeAcademic()->getNiveaux() as $niv){
                foreach ($niv->getClasses() as $classe){
                    foreach ($classe->getEtudiants() as $etudiant) {
                        $solde = $soldeRepo->findOneBy(["etudiant" => $etudiant, "anneeAcademic" => $data->getAnneeAcademic(), "institut" => $data->getInstitut()]);
                        $facture = $factureRepo->findOneBy(["etudiant" => $etudiant, "classe" => $classe, "anneeAcademic" => $data->getAnneeAcademic(), 'parametrageFraisScolarite' => $data]);
                        if(!$etudiant->isBoursier()){
                            if(!$facture){
                                $numeroFactureActu +=1;
                                $facture = (new FactureEtudiant())->setMontant($data->getMontantTemp())->setCategorie("etab")->setAnneeAcademic($data->getAnneeAcademic())->setClasse($classe)->setParametrageFraisScolarite($data)->setEtudiant($etudiant)->setCode( $numeroFactureActu);
                                $em->persist($facture);
                            }else{
                                $facture ->setMontant($facture->getMontant() + $data->getMontantTemp()-$data->getMontant());
                            }
                            if ($solde) {
                                if ($data->getMontant() == 0) {
                                    $solde->setSoldeEcheance($solde->getSoldeEcheance() + $data->getMontantTemp() - $data->getMontant());
                                } else {
                                    $solde->setSoldeEcheance($solde->getSoldeEcheance() + $data->getMontantTemp() - $data->getMontant());
                                }
                            } else {
                                $solde = (new SoldeEtudiant())->setEtudiant($etudiant)->setAnneeAcademic($data->getAnneeAcademic())->setInstitut($data->getInstitut());
                                $solde->setSoldeEcheance($solde->getSoldeEcheance() + $data->getMontantTemp() - $data->getMontant());
                                $em->persist($solde);
                            }
                            $solde->setSolde($solde->getSoldePaiement() - $solde->getSoldeEcheance());
                        }else{
                            if(key_exists("TypeBourses", (array)$data)  and in_array($etudiant->getBourse()->getTypeBourse(), $data->getTypeBourses()->getValues())){
                                if(!$facture){
                                    $numeroFactureActu +=1;
                                    $facture = (new FactureEtudiant())->setMontant($data->getMontantTemp()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100))->setCategorie("niv")->setAnneeAcademic($data->getAnneeAcademic())->setClasse($classe)->setParametrageFraisScolarite($data)->setEtudiant($etudiant)->setCode( $numeroFactureActu);
                                    $em->persist($facture);
                                }else{
                                    $facture ->setMontant($facture->getMontant() + $data->getMontantTemp()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100)-$data->getMontant()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100));
                                }
                                if ($solde) {
                                    if ($data->getMontant() == 0) {
                                        $solde->setSoldeEcheance($solde->getSoldeEcheance() + $data->getMontantTemp()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100) - $data->getMontant()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100));
                                    } else {
                                        $solde->setSoldeEcheance($solde->getSoldeEcheance() + $data->getMontantTemp()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100) - $data->getMontant()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100));
                                    }
                                } else {
                                    $solde = (new SoldeEtudiant())->setEtudiant($etudiant)->setAnneeAcademic($data->getAnneeAcademic())->setInstitut($data->getInstitut());
                                    $solde->setSoldeEcheance($solde->getSoldeEcheance() + $data->getMontantTemp()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100) - $data->getMontant()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100));
                                    $em->persist($solde);
                                }
                                $solde->setSolde($solde->getSoldePaiement() - $solde->getSoldeEcheance());
                            }else{
                                  if(!$facture){
                                        $numeroFactureActu +=1;
                                        $facture = (new FactureEtudiant())->setMontant($data->getMontantTemp())->setCategorie("etab")->setAnneeAcademic($data->getAnneeAcademic())->setClasse($classe)->setParametrageFraisScolarite($data)->setEtudiant($etudiant)->setCode( $numeroFactureActu);
                                        $em->persist($facture);
                                }else{
                                    $facture ->setMontant($facture->getMontant() + $data->getMontantTemp()-$data->getMontant());
                                }
                                if ($solde) {
                                    if ($data->getMontant() == 0) {
                                        $solde->setSoldeEcheance($solde->getSoldeEcheance() + $data->getMontantTemp() - $data->getMontant());
                                    } else {
                                        $solde->setSoldeEcheance($solde->getSoldeEcheance() + $data->getMontantTemp() - $data->getMontant());
                                    }
                                } else {
                                    $solde = (new SoldeEtudiant())->setEtudiant($etudiant)->setAnneeAcademic($data->getAnneeAcademic())->setInstitut($data->getInstitut());
                                    $solde->setSoldeEcheance($solde->getSoldeEcheance() + $data->getMontantTemp() - $data->getMontant());
                                    $em->persist($solde);
                                }
                                $solde->setSolde($solde->getSoldePaiement() - $solde->getSoldeEcheance());
                            }

                        }
                    }
                }
            }
            $data->setMontant($data->getMontantTemp());
        }
        if($data instanceof ParametrageFraisScolariteEtud){
            $solde  = $soldeRepo->findOneBy(["etudiant"=>$data->getEtudiant(),"anneeAcademic"=>$data->getAnneeAcademic(),"institut"=>$data->getInstitut()]);
            $facture =  $factureRepo->findOneBy(["etudiant"=>$etudiant,"classe"=>$classe,"anneeAcademic"=>$data->getAnneeAcademic(),'parametrageFraisScolarite'=>$data]);
            if(!$facture){
                $numeroFactureActu +=1;
                $facture = (new FactureEtudiant())->setMontant($data->getMontantTemp())->setCategorie("etud")->setAnneeAcademic($data->getAnneeAcademic())->setClasse($classe)->setParametrageFraisScolarite($data)->setEtudiant($etudiant)->setCode( $numeroFactureActu);
                $em->persist($facture);
            }else{
                $facture ->setMontant($facture->getMontant() + $data->getMontantTemp()-$data->getMontant());
            }
            if($solde){
                if($data->getMontant()==0){
                    $solde->setSoldeEcheance($solde->getSoldeEcheance()+$data->getMontantTemp()-$data->getMontant());
                }else{
                    $solde->setSoldeEcheance($solde->getSoldeEcheance()+$data->getMontantTemp()-$data->getMontant());
                }
            }else{
                $solde  = (new SoldeEtudiant())->setEtudiant($data->getEtudiant())->setAnneeAcademic($data->getAnneeAcademic())->setInstitut($data->getInstitut());
                $solde->setSoldeEcheance($solde->getSoldeEcheance()+$data->getMontantTemp()-$data->getMontant());
                $em->persist($solde);
            }
            $solde->setSolde($solde->getSoldePaiement()-$solde->getSoldeEcheance());
            $data->setMontant($data->getMontantTemp());
        }
        if($data instanceof ParametrageFraisScolariteNiv){
            foreach ($data->getNiveau()->getClasses() as $classe){

                foreach ($classe->getEtudiants() as $etudiant){
                    $solde  = $soldeRepo->findOneBy(["etudiant"=>$etudiant,"anneeAcademic"=>$data->getAnneeAcademic(),"institut"=>$data->getInstitut()]);
                    $facture =  $factureRepo->findOneBy(["etudiant"=>$etudiant,"classe"=>$classe,"anneeAcademic"=>$data->getAnneeAcademic(),'parametrageFraisScolarite'=>$data]);
                    if(!$etudiant->isBoursier() ){
                      
                        if(!$facture){
                            $numeroFactureActu +=1;
                            $facture = (new FactureEtudiant())->setMontant($data->getMontantTemp())->setCategorie("niv")->setAnneeAcademic($data->getAnneeAcademic())->setClasse($classe)->setParametrageFraisScolarite($data)->setEtudiant($etudiant)->setCode( $numeroFactureActu);
                            $em->persist($facture);
                        }else{
                            $facture ->setMontant($facture->getMontant() + $data->getMontantTemp()-$data->getMontant());
                        }
                        if($solde){
                            if($data->getMontant()==0){
                                $solde->setSoldeEcheance($solde->getSoldeEcheance()+$data->getMontantTemp()-$data->getMontant());
                            }else{
                                $solde->setSoldeEcheance($solde->getSoldeEcheance()+$data->getMontantTemp()-$data->getMontant());
                            }
                        }else{
                            $solde  = (new SoldeEtudiant())->setEtudiant($etudiant)->setAnneeAcademic($data->getAnneeAcademic())->setInstitut($data->getInstitut());
                            $solde->setSoldeEcheance($solde->getSoldeEcheance()+$data->getMontantTemp()-$data->getMontant());
                            $em->persist($solde);
                        }
                        $solde->setSolde($solde->getSoldePaiement()-$solde->getSoldeEcheance());
                    }else{
                          if( in_array( $etudiant->getBourse()->getTypeBourse(), $data->getTypeBourses()->getValues())){
                            if(!$facture){
                                $numeroFactureActu +=1;
                                $facture = (new FactureEtudiant())->setMontant($data->getMontantTemp()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100))->setCategorie("niv")->setAnneeAcademic($data->getAnneeAcademic())->setClasse($classe)->setParametrageFraisScolarite($data)->setEtudiant($etudiant)->setCode( $numeroFactureActu);
                                $em->persist($facture);
                            }else{
                                $facture ->setMontant($facture->getMontant() + $data->getMontantTemp()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100)-$data->getMontant()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100));
                            }
                            if ($solde) {
                                if ($data->getMontant() == 0) {
                                    $solde->setSoldeEcheance($solde->getSoldeEcheance() + $data->getMontantTemp()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100) - $data->getMontant()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100));
                                } else {
                                    $solde->setSoldeEcheance($solde->getSoldeEcheance() + $data->getMontantTemp()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100) - $data->getMontant()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100));
                                }
                            } else {
                                $solde = (new SoldeEtudiant())->setEtudiant($etudiant)->setAnneeAcademic($data->getAnneeAcademic())->setInstitut($data->getInstitut());
                                $solde->setSoldeEcheance($solde->getSoldeEcheance() + $data->getMontantTemp()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100) - $data->getMontant()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100));
                                $em->persist($solde);
                            }
                            $solde->setSolde($solde->getSoldePaiement() - $solde->getSoldeEcheance());
                          }else{
                               if(!$facture){
                                    $numeroFactureActu +=1;
                                    $facture = (new FactureEtudiant())->setMontant($data->getMontantTemp())->setCategorie("niv")->setAnneeAcademic($data->getAnneeAcademic())->setClasse($classe)->setParametrageFraisScolarite($data)->setEtudiant($etudiant)->setCode( $numeroFactureActu);
                                    $em->persist($facture);
                                }else{
                                    $facture ->setMontant($facture->getMontant() + $data->getMontantTemp()-$data->getMontant());
                                }
                                if($solde){
                                    if($data->getMontant()==0){
                                        $solde->setSoldeEcheance($solde->getSoldeEcheance()+$data->getMontantTemp()-$data->getMontant());
                                    }else{
                                        $solde->setSoldeEcheance($solde->getSoldeEcheance()+$data->getMontantTemp()-$data->getMontant());
                                    }
                                }else{
                                    $solde  = (new SoldeEtudiant())->setEtudiant($etudiant)->setAnneeAcademic($data->getAnneeAcademic())->setInstitut($data->getInstitut());
                                    $solde->setSoldeEcheance($solde->getSoldeEcheance()+$data->getMontantTemp()-$data->getMontant());
                                    $em->persist($solde);
                                }
                                $solde->setSolde($solde->getSoldePaiement()-$solde->getSoldeEcheance());
                        }
                    }
                }
            }
            $data->setMontant($data->getMontantTemp());
        }

        return $data;
    }

}
