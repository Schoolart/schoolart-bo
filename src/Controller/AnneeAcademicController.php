<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Entity\FactureEtudiant;
use App\Entity\Niveau;
use App\Entity\ParametrageFraisScolarite;
use App\Entity\ParametrageFraisScolariteEtab;
use App\Entity\ParametrageFraisScolariteNiv;
use App\Entity\RecapAnnee;
use App\Entity\SoldeEtudiant;
use App\Repository\AnneeAcademicRepository;
use App\Repository\ClasseRepository;
use App\Repository\EtudiantRepository;
use App\Repository\FactureEtudiantRepository;
use App\Repository\InstitutRepository;
use App\Repository\NiveauRepository;
use App\Repository\ParametrageFraisScolariteEtabRepository;
use App\Repository\ParametrageFraisScolariteEtudRepository;
use App\Repository\ParametrageFraisScolariteNivRepository;
use App\Repository\ParametrageFraisScolariteRepository;
use App\Repository\ParcoursRepository;
use App\Repository\RecapAnneeRepository;
use App\Repository\SoldeEtudiantRepository;
use App\Service\ContactNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function DeepCopy\deep_copy;

class AnneeAcademicController extends AbstractController
{

    private AnneeAcademicRepository $anneeRepo;
    private EntityManagerInterface $em;
    private EtudiantRepository $etudiantRepo;
    private ParcoursRepository $parcoursRepo;
    private ClasseRepository $classeRepo;
    private NiveauRepository $niveauRepo;
    private RecapAnneeRepository $recapRepo;

    public function __construct(AnneeAcademicRepository $anneeRepo, EntityManagerInterface $em,NiveauRepository $niveauRepo,
                                RecapAnneeRepository $recapRepo,EtudiantRepository $etudiantRepo,ParcoursRepository $parcoursRepo,ClasseRepository $classeRepo,private ContactNotification $contact)
    {
        $this->anneeRepo = $anneeRepo;
        $this->em = $em;
        $this->etudiantRepo = $etudiantRepo;
        $this->parcoursRepo = $parcoursRepo;
        $this->classeRepo = $classeRepo;
        $this->niveauRepo=$niveauRepo;
        $this->recapRepo = $recapRepo;

    }

    #[Route('/api/annee_academic/create', name: 'app_annee_academic', methods: ['POST'])]
    public function index(Request $request): Response
    {
        $data = $request->request;
        $anneeNew = $this->anneeRepo->find($data->get('anneeNew'));
        $anneeOld = $this->anneeRepo->find($data->get('anneeOld'));
        if ($anneeNew && $anneeOld) {
            $new_prefix = explode('-', $anneeNew->getLibelle());
            $new_parameter = clone $anneeOld->getParametrage();
            $new_parameter->clearId("ISM" . substr(trim($new_prefix[0]), -2) . substr(trim($new_prefix[1]), -2) . '/');
            $new_parameter->setPassword("ismapps" . trim($new_prefix[0]));
            $new_parameter->setInstitut($anneeOld->getInstitut());
            $appreciations = clone $anneeOld->getParametrage()->getAppreciations();
            foreach ($appreciations as $appreciation) {
                $new_appreciation = clone $appreciation;
                $new_appreciation->clearId();
                $new_parameter->addAppreciation($new_appreciation);
            }
            $anneeNew->setParametrage($new_parameter);
            $niveaux = clone $anneeOld->getNiveaux();
            foreach ($niveaux as $niv) {
                $classes = clone $niv->getClasses();
                $matiereSups = clone $niv->getMatiereSups();
                $ueSups = clone $niv->getUeSups();
                $periodes = clone $niv->getPeriodes();
                $new_niv = new Niveau();
                //$this->em->persist($new_niv);
                $new_niv->setIntitule($niv->getIntitule());
                foreach ($matiereSups as $matiereSup) {
                    $new_matiereSup = clone $matiereSup;
                    $new_matiereSup->clearId();
                    $new_niv->addMatiereSup($new_matiereSup);
                }
                foreach ($ueSups as $ueSup) {
                    $new_ueSup = clone $ueSup;
                    $new_ueSup->clearId();
                    $new_niv->addUeSup($new_ueSup);
                }
                foreach ($classes as $classe) {
                    $new_classe = new Classe();
                    $new_classe->setNomClasse($classe->getNomClasse())
                        ->setNiveau($new_niv)
                        ->setDescription($classe->getDescription());
                    $new_niv->addClass($new_classe);
                }
                foreach ($periodes as $periode) {
                    $new_periode = clone $periode;
                    $new_periode->clearId();
                    $new_niv->addPeriode($new_periode);
                    $anneeNew->addPeriode($new_periode);
                }
                $anneeNew->addNiveau($new_niv);
                $this->em->flush();
                $niv->setSuivant($new_niv->getId());
            }
            $this->em->flush();
            return new Response(null, 200, [], false);
        }
        return new Response(null, 500, [], false);
    }

    #[Route('/api/annee_academic/inscription', name: 'app_annee_academic_inscription', methods: ['POST'])]
    public function inscription(Request $request): Response
    {
        $maybe_inscription=false;
        $data = $request->request;
        $etudiant = $this->etudiantRepo->find($data->get('etudiant'));
        $classes  = $etudiant->getClasses();
        $recaps=[];
        foreach ($classes as $classe){
            $annee =  $classe->getNiveau()->getAnneeAcademic();
            $recap = $this->recapRepo->findOneBy(['etudiant'=>$etudiant,'anneeAcademic'=>$annee]);
            if($recap) {
                array_push($recaps, $recap);
            }
        }
       //dd($recaps);
        $countRecap =  count($recaps);
        if($etudiant->getDuree()>=5) {
            //dd($countRecap);
            if ($countRecap == 0) {
                $maybe_inscription = true;
            } else if ($countRecap == 1 && $recaps[$countRecap - 1]->getTotalCredit() >= 42) {
                $maybe_inscription = true;
            } else if ($countRecap == 2 && ($recaps[$countRecap - 2]->getTotalCredit() + $recaps[$countRecap - 1]->getTotalCredit()) >= 102 && $recaps[$countRecap - 2]->getTotalCredit() == 60) {
                $maybe_inscription = true;
            } else if ($countRecap == 3 && ($recaps[$countRecap - 3]->getTotalCredit() + $recaps[$countRecap - 2]->getTotalCredit() + $recaps[$countRecap - 1]->getTotalCredit()) == 180) {
                $maybe_inscription = true;
            } else if ($countRecap == 4 && $recaps[$countRecap - 1] >= 42) {
                $maybe_inscription = true;
            }
        }else if($etudiant->getDuree()==4){
            if ($countRecap == 0) {
                $maybe_inscription = true;
            } else if ($countRecap == 1 && $recaps[$countRecap - 1]->getTotalCredit() >= 42) {
                $maybe_inscription = true;
            } else if ($countRecap == 2 && ($recaps[$countRecap - 2]->getTotalCredit() + $recaps[$countRecap - 1]->getTotalCredit()) >= 120) {
                $maybe_inscription = true;
            } else if ($countRecap == 3 && $recaps[$countRecap - 1]->getTotalCredit() >= 42) {
                $maybe_inscription = true;
            }
        }else if($etudiant->getDuree()==3){
            if ($countRecap == 0) {
                $maybe_inscription = true;
            } else if ($countRecap == 1 && $recaps[$countRecap - 1]->getTotalCredit() >= 60) {
                $maybe_inscription = true;
            } else if ($countRecap == 2 && $recaps[$countRecap - 1]->getTotalCredit() >= 42) {
                $maybe_inscription = true;
            }
        }
        else if($etudiant->getDuree()==2){
            if ($countRecap == 0) {
                $maybe_inscription = true;
            } else if ($countRecap == 1 && $recaps[$countRecap - 1]->getTotalCredit() >= 42) {
                $maybe_inscription = true;
            }
        }
        else if($etudiant->getDuree()==1){
            if ($countRecap == 0) {
                $maybe_inscription = true;
            }
        }
        else if($etudiant->getDuree()==0){
                $maybe_inscription = true;
        }
       if($maybe_inscription){
           return new Response(null, 200, [], false);
       }
        return new Response($countRecap, 500, [], false);
    }
    #[Route('/api/annee_academic/inscription_paiement/{id}', name: 'app_annee_academic_inscription_paiement', methods: ['POST'])]
    public function inscriptionPaiement(Etudiant $etudiant,Request $request,FactureEtudiantRepository $factureRepo, SoldeEtudiantRepository $soldeRepo,EntityManagerInterface $em,ParametrageFraisScolariteEtabRepository  $parametabRepo,
                                        ParametrageFraisScolariteNivRepository $paramnivRepo,ParametrageFraisScolariteEtudRepository $parametudRepo): Response
    {
        $annee = $this->anneeRepo->find($request->request->get('anneeAcademic'));
        $classe = $this->classeRepo->find($request->request->get('classe'));
        /*$factures = $factureRepo->findBySolder($annee,$classe,$etudiant,false);
        $montantPayer = 100000;
        //dd($factures);
        foreach ($factures as &$facture){
            if($facture instanceof FactureEtudiant and $facture->getMontant()<=$montantPayer){
                $montantPayer -=$facture->getMontant();
                $facture->setSolder(true);
            }
        }
        dd($factures);
       */
        $paramsEtab = $parametabRepo->findBy(['institut'=>$annee->getInstitut(),'anneeAcademic'=>$annee]);
        $paramsNiv = $paramnivRepo->findBy(['institut'=>$annee->getInstitut(),'anneeAcademic'=>$annee,'niveau'=>$classe->getNiveau()]);
        $params = array_merge($paramsEtab,$paramsNiv);
        $numeroFactureActu = count($factureRepo->findBy(["anneeAcademic"=>$annee]));
        foreach ($params as $param) {
            $solde = $soldeRepo->findOneBy(["etudiant" => $etudiant, "anneeAcademic" => $annee, "institut" => $annee->getInstitut()]);
            $facture = $factureRepo->findOneBy(["etudiant" => $etudiant, "classe" => $classe, "anneeAcademic" => $annee, 'parametrageFraisScolarite' => $param]);
            if( !$etudiant->isBoursier()) {
                if (!$facture) {
                    $numeroFactureActu += 1;
                    if ($param instanceof ParametrageFraisScolariteNiv) {
                        $facture = (new FactureEtudiant())->setMontant($param->getMontant())->setCategorie('niv')->setAnneeAcademic($annee)->setClasse($classe)->setParametrageFraisScolarite($param)->setEtudiant($etudiant)->setCode($numeroFactureActu);
                    }
                    if ($param instanceof ParametrageFraisScolariteEtab) {
                        $facture = (new FactureEtudiant())->setMontant($param->getMontant())->setCategorie('etab')->setAnneeAcademic($annee)->setClasse($classe)->setParametrageFraisScolarite($param)->setEtudiant($etudiant)->setCode($numeroFactureActu);
                    }
                    $em->persist($facture);
                    $em->flush();
                }
                if ($solde) {
                    $solde->setSoldeEcheance($solde->getSoldeEcheance() + $param->getMontant());
                } else {
                    $solde = (new SoldeEtudiant())->setEtudiant($etudiant)->setAnneeAcademic($annee)->setInstitut($annee->getInstitut());
                    $solde->setSoldeEcheance($solde->getSoldeEcheance() + $param->getMontant());
                    $em->persist($solde);
                    $em->flush();
                }
                $solde->setSolde($solde->getSoldePaiement() - $solde->getSoldeEcheance());
            }else{
                if(in_array( $etudiant->getBourse()->getTypeBourse(), $param->getTypeBourses()->getValues()) ){
                    if (!$facture) {
                        $numeroFactureActu += 1;
                        if ($param instanceof ParametrageFraisScolariteNiv) {
                            $facture = (new FactureEtudiant())->setMontant($param->getMontant()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100))->setCategorie('niv')->setAnneeAcademic($annee)->setClasse($classe)->setParametrageFraisScolarite($param)->setEtudiant($etudiant)->setCode($numeroFactureActu);
                        }
                        if ($param instanceof ParametrageFraisScolariteEtab) {
                            $facture = (new FactureEtudiant())->setMontant($param->getMontant()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100))->setCategorie('etab')->setAnneeAcademic($annee)->setClasse($classe)->setParametrageFraisScolarite($param)->setEtudiant($etudiant)->setCode($numeroFactureActu);
                        }
                        $em->persist($facture);
                        $em->flush();
                    }
                    if ($solde) {
                        $solde->setSoldeEcheance($solde->getSoldeEcheance() + $param->getMontant()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100));
                    } else {
                        $solde = (new SoldeEtudiant())->setEtudiant($etudiant)->setAnneeAcademic($annee)->setInstitut($annee->getInstitut());
                        $solde->setSoldeEcheance($solde->getSoldeEcheance() + $param->getMontant()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100));
                        $em->persist($solde);
                        $em->flush();
                    }
                    $solde->setSolde($solde->getSoldePaiement() - $solde->getSoldeEcheance());
                }else{
                        if (!$facture) {
                        $numeroFactureActu += 1;
                        if ($param instanceof ParametrageFraisScolariteNiv) {
                            $facture = (new FactureEtudiant())->setMontant($param->getMontant())->setCategorie('niv')->setAnneeAcademic($annee)->setClasse($classe)->setParametrageFraisScolarite($param)->setEtudiant($etudiant)->setCode($numeroFactureActu);
                        }
                        if ($param instanceof ParametrageFraisScolariteEtab) {
                            $facture = (new FactureEtudiant())->setMontant($param->getMontant())->setCategorie('etab')->setAnneeAcademic($annee)->setClasse($classe)->setParametrageFraisScolarite($param)->setEtudiant($etudiant)->setCode($numeroFactureActu);
                        }
                        $em->persist($facture);
                        $em->flush();
                    }
                    if ($solde) {
                        $solde->setSoldeEcheance($solde->getSoldeEcheance() + $param->getMontant());
                    } else {
                        $solde = (new SoldeEtudiant())->setEtudiant($etudiant)->setAnneeAcademic($annee)->setInstitut($annee->getInstitut());
                        $solde->setSoldeEcheance($solde->getSoldeEcheance() + $param->getMontant());
                        $em->persist($solde);
                        $em->flush();
                    }
                    $solde->setSolde($solde->getSoldePaiement() - $solde->getSoldeEcheance());
                }
            }
        }
        $this->contact->NewEtudiantNotify($etudiant,$annee->getInstitut(),$this->getParameter('kernel'));
        $em->flush();

        return new Response(null, 200, [], false);
    }
    #[Route('/api/annee_academic/inscription_paiement_delete/{id}', name: 'app_annee_academic_inscription_paiement_delete', methods: ['POST'])]
    public function inscriptionDeletePaiement(Etudiant $etudiant,Request $request,FactureEtudiantRepository $factureRepo, SoldeEtudiantRepository $soldeRepo,EntityManagerInterface $em,ParametrageFraisScolariteEtabRepository  $parametabRepo,
                                        ParametrageFraisScolariteNivRepository $paramnivRepo,ParametrageFraisScolariteEtudRepository $parametudRepo): Response
    {
        $annee = $this->anneeRepo->find($request->request->get('anneeAcademic'));
        $classe = $this->classeRepo->find($request->request->get('classe'));
        $paramsEtab = $parametabRepo->findBy(['institut'=>$annee->getInstitut(),'anneeAcademic'=>$annee]);
        $paramsNiv = $paramnivRepo->findBy(['institut'=>$annee->getInstitut(),'anneeAcademic'=>$annee,'niveau'=>$classe->getNiveau()]);
        $params = array_merge($paramsEtab,$paramsNiv);
        foreach ($params as $param) {
            $solde = $soldeRepo->findOneBy(["etudiant" => $etudiant, "anneeAcademic" => $annee, "institut" => $annee->getInstitut()]);
            $facture = $factureRepo->findOneBy(["etudiant" => $etudiant, "classe" => $classe, "anneeAcademic" => $annee, 'parametrageFraisScolarite' => $param]);
            if(!$etudiant->isBoursier()) {
                if ($facture) {
                    $em->remove($facture);
                    $em->flush();
                }
                if ($solde) {
                    $solde->setSoldeEcheance($solde->getSoldeEcheance() - $param->getMontant());
                }
                $solde->setSolde($solde->getSoldePaiement() - $solde->getSoldeEcheance());
            }else{
                if(in_array($etudiant->getBourse()->getTypeBourse(), $param->getTypeBourses()->getValues())){
                    if ($facture) {
                        $em->remove($facture);
                        $em->flush();
                    }
                    if ($solde) {
                        $solde->setSoldeEcheance($solde->getSoldeEcheance() - $param->getMontant()*((100-$etudiant->getBourse()->getTypeBourse()->getPourcentage())/100));
                    }
                    $solde->setSolde($solde->getSoldePaiement() - $solde->getSoldeEcheance());
                }else{
                    if ($facture) {
                    $em->remove($facture);
                    $em->flush();
                    }
                    if ($solde) {
                        $solde->setSoldeEcheance($solde->getSoldeEcheance() - $param->getMontant());
                    }
                    $solde->setSolde($solde->getSoldePaiement() - $solde->getSoldeEcheance());
                }
            }
        }
        $em->flush();

        return new Response(null, 200, [], false);
    }
    public function maybeInscription(Etudiant $etudiant): Response
    {
        $maybe_inscription=false;
        $classes  = $etudiant->getClasses();
        $recaps=[];
        foreach ($classes as $classe){
            $annee =  $classe->getNiveau()->getAnneeAcademic();
            $recap = $this->recapRepo->findOneBy(['etudiant'=>$etudiant,'anneeAcademic'=>$annee]);
            if($recap) {
                array_push($recaps, $recap);
            }
        }
        //dd($recaps);
        $countRecap =  count($recaps);
        if($etudiant->getDuree()>=5) {
            //dd($countRecap);
            if ($countRecap == 0) {
                $maybe_inscription = true;
            } else if ($countRecap == 1 && $recaps[$countRecap - 1]->getTotalCredit() >= 42) {
                $maybe_inscription = true;
            } else if ($countRecap == 2 && ($recaps[$countRecap - 2]->getTotalCredit() + $recaps[$countRecap - 1]->getTotalCredit()) >= 102 && $recaps[$countRecap - 2]->getTotalCredit() == 60) {
                $maybe_inscription = true;
            } else if ($countRecap == 3 && ($recaps[$countRecap - 3]->getTotalCredit() + $recaps[$countRecap - 2]->getTotalCredit() + $recaps[$countRecap - 1]->getTotalCredit()) == 180) {
                $maybe_inscription = true;
            } else if ($countRecap == 4 && $recaps[$countRecap - 1] >= 42) {
                $maybe_inscription = true;
            }
        }else if($etudiant->getDuree()==4){
            if ($countRecap == 0) {
                $maybe_inscription = true;
            } else if ($countRecap == 1 && $recaps[$countRecap - 1]->getTotalCredit() >= 42) {
                $maybe_inscription = true;
            } else if ($countRecap == 2 && ($recaps[$countRecap - 2]->getTotalCredit() + $recaps[$countRecap - 1]->getTotalCredit()) >= 120) {
                $maybe_inscription = true;
            } else if ($countRecap == 3 && $recaps[$countRecap - 1]->getTotalCredit() >= 42) {
                $maybe_inscription = true;
            }
        }else if($etudiant->getDuree()==3){
            if ($countRecap == 0) {
                $maybe_inscription = true;
            } else if ($countRecap == 1 && $recaps[$countRecap - 1]->getTotalCredit() >= 60) {
                $maybe_inscription = true;
            } else if ($countRecap == 2 && $recaps[$countRecap - 1]->getTotalCredit() >= 42) {
                $maybe_inscription = true;
            }
        }
        else if($etudiant->getDuree()==2){
            if ($countRecap == 0) {
                $maybe_inscription = true;
            } else if ($countRecap == 1 && $recaps[$countRecap - 1]->getTotalCredit() >= 42) {
                $maybe_inscription = true;
            }
        }
        else if($etudiant->getDuree()==1){
            if ($countRecap == 0) {
                $maybe_inscription = true;
            }
        }
        else if($etudiant->getDuree()==0){
            $maybe_inscription = true;
        }
        return $maybe_inscription;
    }
    #[Route('/api/annee_academic/is_ajour/{id}', name: 'app_annee_academic_is_ajour', methods: ['POST'])]

    public function is_ajour(Etudiant $etudiant,Request $request,InstitutRepository $institutRepository,SoldeEtudiantRepository $soldeRepo,ParametrageFraisScolariteEtabRepository $parametabRepo,ParametrageFraisScolariteNivRepository $paramnivRepo,ParametrageFraisScolariteEtudRepository $parametudRepo  ): Response
    {
        $data  = $request->request;
        $annee = $this->anneeRepo->find($data->get('anneeAcademic'));
        $institut= $institutRepository->find($data->get('institut'));
        $solde=$soldeRepo->findOneBy(['etudiant'=>$etudiant,"anneeAcademic"=>$annee,"institut"=>$institut]);
        $paramsEtab = $parametabRepo->findByDate($institut,$annee);
        $paramsNiv = $paramnivRepo->findByDateToAjour($institut,$annee);
        $paramsEtud = $parametudRepo->findByDateToAjour($institut,$annee,$etudiant);
        $soldeAdate=0;
        $isAjour = false;
        foreach ($paramsEtab  as $item){
            $soldeAdate +=$item->getMontant();
        }
        foreach ($paramsNiv  as $item){
            $soldeAdate +=$item->getMontant();
        }
        foreach ($paramsEtud  as $item){
            $soldeAdate +=$item->getMontant();
        }
        if($solde->getSoldePaiement() >= $soldeAdate){
            $isAjour = true;
        }
        return new Response($isAjour, 200, [], true);
    }

}
