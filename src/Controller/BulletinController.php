<?php

namespace App\Controller;

use App\Entity\Bulletin;
use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Entity\Niveau;
use App\Entity\Note;
use App\Entity\Parcours;
use App\Entity\Periode;
use App\Entity\PeriodePrec;
use App\Entity\RecapAnnee;
use App\Entity\Specialisation;
use App\Repository\AbsenceRepository;
use App\Repository\AnneeAcademicRepository;
use App\Repository\BulletinRepository;
use App\Repository\CategorieProduitRepository;
use App\Repository\ClasseRepository;
use App\Repository\DomaineRepository;
use App\Repository\EtudiantRepository;
use App\Repository\GradeRepository;
use App\Repository\InstitutRepository;
use App\Repository\MatiereRepository;
use App\Repository\MentionRepository;
use App\Repository\NiveauRepository;
use App\Repository\NoteRepository;
use App\Repository\ParcoursRepository;
use App\Repository\PassageRepository;
use App\Repository\PeriodePrecRepository;
use App\Repository\PeriodeRepository;
use App\Repository\RecapAnneeRepository;
use App\Repository\SpecialisationRepository;
use App\Repository\UeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BulletinController extends AbstractController
{
    private EntityManagerInterface $em;
    private Pdf $knpSnappyPdf;
    private ParcoursRepository $parcoursRepo;
    private InstitutRepository $instRepo;
    private AbsenceRepository $absRepo;
    private UeRepository $ueRepo;
    private AnneeAcademicRepository $anneeRepo;
    private PeriodeRepository $periodeRepo;
    private ClasseRepository $classeRepo;
    private NoteRepository $noteRepo;
    private NiveauRepository $nivRepo;
    private PassageRepository $passageRepo;
    private RecapAnneeRepository $recapAnneeRepo;
    private PeriodePrecRepository $periodePrecRepo;

    public function __construct(NiveauRepository       $nivRepo, PeriodePrecRepository $periodePrecRepo,
                                EntityManagerInterface $em, RecapAnneeRepository $recapAnneeRepo, private BulletinRepository $bulletinRepo,
                                Pdf                    $knpSnappyPdf, PassageRepository $passageRepo, ParcoursRepository $parcoursRepo, InstitutRepository $instRepo, AbsenceRepository $absRepo, UeRepository $ueRepo, AnneeAcademicRepository $anneeRepo, PeriodeRepository $periodeRepo, ClasseRepository $classeRepo, NoteRepository $noteRepo)
    {
        $this->em = $em;
        $this->knpSnappyPdf = $knpSnappyPdf;
        $this->parcoursRepo = $parcoursRepo;
        $this->instRepo = $instRepo;
        $this->absRepo = $absRepo;
        $this->ueRepo = $ueRepo;
        $this->anneeRepo = $anneeRepo;
        $this->periodeRepo = $periodeRepo;
        $this->classeRepo = $classeRepo;
        $this->noteRepo = $noteRepo;
        $this->passageRepo = $passageRepo;
        $this->nivRepo = $nivRepo;
        $this->recapAnneeRepo = $recapAnneeRepo;
        $this->periodePrecRepo = $periodePrecRepo;
    }

    public static function calcul(int $total_absence, int $total_absence_justifie): int
    {
        $absence = $total_absence - $total_absence_justifie;
        return (20 - ($absence * 0.5));
    }

    #[Route('/api/bulletins/S1/All', name: 'app_:bulletin_S1_all', methods: ['POST'])]
    public function indexSemestre1All(Request $request)
    {
        $data = $request->request;
        $annee = $this->anneeRepo->find($data->get('anneeAcademic'));
        $classe = $this->classeRepo->find($data->get('classe'));
        $periode = $this->periodeRepo->find($data->get('periode'));
        $dataEt = [];
        $ues = $this->ueRepo->findByClasseByPeriode($classe->getId(), $periode->getId());
        foreach ($classe->getEtudiants() as &$etudiant) {
            $notes = $this->noteRepo->findBy(["etudiant" => $etudiant, "periode" => $periode, "classe" => $classe]);
            $totalG = 0;
            $totalCredit = 0;
            $totalCreditCapitalise = 0;
            $totalGD = 0;
            $total_absence = 0;
            $total_absence_justifie = 0;
            $absences = $this->absRepo->findByClasseAndPeriode($etudiant, $periode->getDateDebut(), $periode->getDateFin());
            foreach ($absences as &$absence) {
                $total_absence += $absence->getNbreAbsence();
                $total_absence_justifie += $absence->getAbsenceJustifie();
            }
            $totalAssiduite = $this->calcul($total_absence, $total_absence_justifie);

            $ueComp = [];
            foreach ($ues as &$ue) {
                $creditCapitalise = 0;
                $ue->setNoteFinal(0);
                $ue->setMoyenne(0);
                $ue->setCredit(0);
                $ue->setCoef(0);
                foreach ($ue->getMatieres() as &$matiere) {
                    $exist = false;
                    foreach ($notes as &$note) {
                        if ($note->getMatiere()->getId() == $matiere->getId()) {
                            $exist = true;
                            $matiere->ereaseNote();
                            $matiere->addNote($note);
                            $moyenneCC = number_format(($note->getCc1() + $note->getCc2()) / 2, 2, '.', ',');
                            $noteFinal = number_format($moyenneCC * 0.4 + $note->getExamen() * 0.6, 2, '.', ',');
                            $ue->setNoteFinal($ue->getNoteFinal() +
                                $noteFinal * $matiere->getCoefficients());
                            if ($noteFinal < 10) {
                                $creditCapitalise += 0;
                            } else {
                                $creditCapitalise += $matiere->getCredits();
                            }
                        }
                    }
                    if (!$exist) {
                        if ($periode->getSession()->getIntitule() != "Session 2") {
                            $newNote = (new Note())->setClasse($classe)->setPeriode($periode)->setEtudiant($etudiant);
                            $this->em->persist($newNote);
                            array_push($notes, $newNote);
                            $matiere->ereaseNote();
                            $matiere->addNote($newNote);
                        } else {
                            return new Response(null, 500, [], true);
                        }
                    }
                    $ue->setCoef($ue->getCoef() + $matiere->getCoefficients());
                    $ue->setCredit($ue->getCredit() + $matiere->getCredits());
                    $ue->setSession($periode->getSession()->getIntitule());
                }
                $ue->setMoyenne(number_format($ue->getNoteFinal() / $ue->getCoef(), 2, '.', ','));
                /*if ($ue->getMoyenne() < 10) {
                    array_push($ueComp, $ue);
                } else {
                    $creditCapitalise = $ue->getCredit();
                    $ue->setResultat("Validée");
                }*/
                $ue->setCreditCapitalise($creditCapitalise);
                $totalG += number_format($ue->getMoyenne() * $ue->getCredit(), 2, '.', ',');
                $totalGD += $ue->getCredit() * 20;
                $totalCredit += $ue->getCredit();
                $totalCreditCapitalise += $ue->getCreditCapitalise();
            }
            $resultat = ($totalG + ($totalAssiduite - 10)) / $totalCredit;
            $et['totalAssiduite'] = $totalAssiduite;
            $et['totalAbsence'] = $total_absence;
            $et['totalAbsenceJustifie'] = $total_absence_justifie;
            $et['totalG'] = $totalG;
            $et['totalGD'] = $totalGD;
            $et['totalCredit'] = $totalCredit;
            $et['totalCreditCapitalise'] = $totalCreditCapitalise;
            $et['resultat'] = $resultat;
            $et['etudiant'] = $etudiant;
            array_push($dataEt, $et);
        }
        return $this->indexSemestre1Option($dataEt, $request);
    }

    public function indexSemestre1Option(array $dataEt, Request $request)
    {
        if (count($dataEt) > 0) {
            $kernel = $this->getParameter('kernel');
            $data = $request->request;
            $annee = $this->anneeRepo->find($data->get('anneeAcademic'));
            $classe = $this->classeRepo->find($data->get('classe'));
            $periode = $this->periodeRepo->find($data->get('periode'));
            $institut = $this->instRepo->find($data->get('institut'));
            $parametrage = $annee->getParametrage();
            $appreciations = $parametrage->getAppreciations();
            $spec = $classe->getSpecialisation();
            $mention = $spec->getMention();
            $domaine = $mention->getDomaine();
            $grade = $domaine->getGrade();
            $option = $data->get('filtre');
            $etudiants = [];
            $etudiantsSession2 = [];
            if ($periode->getSession()->getIntitule() == "Session 2") {
                $passages = $this->passageRepo->findBy(['periode' => $periode, 'classe' => $classe]);
                foreach ($passages as $passage) {
                    if (!in_array($passage->getEtudiant(), $etudiantsSession2)) {
                        array_push($etudiantsSession2, $passage->getEtudiant());
                    }

                }
            }
            if ($option == 1) {
                foreach ($dataEt as $etudiant) {
                    if ($etudiant['totalCreditCapitalise'] == 30) {
                        if (count($etudiantsSession2) > 0) {
                            foreach ($etudiantsSession2 as $item) {
                                if ($item->getId() == $etudiant['etudiant']->getId()) {
                                    array_push($etudiants, $etudiant);
                                }
                            }
                        } else {
                            array_push($etudiants, $etudiant);
                        }
                    }
                }
            } elseif ($option == 2) {
                foreach ($dataEt as $etudiant) {
                    if ($etudiant['totalCreditCapitalise'] < 30) {
                        if (count($etudiantsSession2) > 0) {
                            foreach ($etudiantsSession2 as $item) {
                                if ($item->getId() == $etudiant['etudiant']->getId()) {
                                    array_push($etudiants, $etudiant);
                                }
                            }
                        } else {
                            array_push($etudiants, $etudiant);
                        }
                    }
                }
            } else {
                if (count($etudiantsSession2) > 0) {
                    foreach ($etudiantsSession2 as $item) {
                        foreach ($dataEt as $etudiant) {
                            if ($item->getId() == $etudiant['etudiant']->getId()) {
                                array_push($etudiants, $etudiant);
                            }
                        }
                    }


                } else {
                    $etudiants = $dataEt;
                }
            }
            $html = $this->renderView("bulletin/S1ALL/header.html.twig", [
                'kernel' => $kernel
            ]);
            $ues = $this->ueRepo->findByClasseByPeriode($classe->getId(), $periode->getId());
            foreach ($etudiants as &$et) {
                $totalCreditCapitalise = 0;
                $apprec = "Echec";
                $resultat = $et['resultat'];
                $notes = $this->noteRepo->findBy(["etudiant" => $et['etudiant'], "periode" => $periode, "classe" => $classe]);
                if ($notes) {
                    $ueComp = [];
                    foreach ($ues as &$ue) {
                        $ue->setResultat("Non validée");
                        if ($periode->getSession()->getIntitule() == "Session 2") {
                            $sessionUe = $this->passageRepo->findOneBy(['etudiant' => $et['etudiant'], 'ue' => $ue, 'periode' => $periode]);
                            if ($sessionUe) {
                                $ue->setSession($sessionUe->getPeriode()->getSession()->getIntitule());
                            } else {
                                $ue->setSession("Session 1");
                            }
                        }
                        $creditCapitalise = 0;
                        $ue->setNoteFinal(0);
                        $ue->setMoyenne(0);
                        $ue->setCredit(0);
                        $ue->setCoef(0);
                        foreach ($ue->getMatieres() as &$matiere) {
                            foreach ($notes as &$note) {
                                if ($note->getMatiere()->getId() == $matiere->getId()) {
                                    $matiere->ereaseNote();
                                    $matiere->addNote($note);
                                    $moyenneCC = number_format(($note->getCc1() + $note->getCc2()) / 2, 2, '.', ',');
                                    $noteFinal = number_format($moyenneCC * 0.4 + $note->getExamen() * 0.6, 2, '.', ',');
                                    $ue->setNoteFinal($ue->getNoteFinal() +
                                        $noteFinal * $matiere->getCoefficients());
                                    if ($noteFinal < 10) {
                                        $creditCapitalise += 0;
                                    } else {
                                        $creditCapitalise += $matiere->getCredits();
                                    }
                                }

                            }
                            $ue->setCoef($ue->getCoef() + $matiere->getCoefficients());
                            $ue->setCredit($ue->getCredit() + $matiere->getCredits());
                        }
                        $ue->setMoyenne(number_format($ue->getNoteFinal() / $ue->getCoef(), 2, '.', ','));
                        if ($ue->getMoyenne() < 10) {
                            array_push($ueComp, $ue);
                        } else {
                            $creditCapitalise = $ue->getCredit();
                            $ue->setResultat("Validée");
                        }
                        $ue->setCreditCapitalise($creditCapitalise);
                        $totalCreditCapitalise += $ue->getCreditCapitalise();
                    }
                    if (count($ueComp) != 0) {
                        foreach ($ueComp as &$ue) {
                            $newMoyenne = 0;
                            $compensations = $ue->getCompensations();
                            if (count($compensations) != 0) {
                                $totalCreditCapitaliseComp = 0;
                                foreach ($compensations[0]->getUes() as $ueC) {
                                    $totalCreditCapitaliseComp += $ueC->getCredit();
                                    $newMoyenne += $ueC->getMoyenne() * $ueC->getCreditCapitalise();
                                }
                                if ($totalCreditCapitaliseComp != 0 && (($newMoyenne / $totalCreditCapitaliseComp) > 10) && $ue->getResultat!="Validée") {
                                    $ue->setResultat('Validée par compensation');
                                    $totalCreditCapitalise -= $ue->getCreditCapitalise();
                                    $ue->setCreditCapitalise($ue->getCredit());
                                    $totalCreditCapitalise += $ue->getCreditCapitalise();
                                }
                            }
                        }
                    }
                    foreach ($appreciations as $appreciation) {
                        if ($resultat > $appreciation->getMin() && $resultat <= $appreciation->getMax()) {
                            $apprec = $appreciation->getLibelle();
                        }
                    }
                    $html .= $this->renderView('bulletin/S1ALL/index.html.twig', [
                        'controller_name' => 'BulletinController',
                        'annee' => $annee,
                        'classe' => $classe,
                        'periode' => $periode,
                        'specialisation' => $spec,
                        'mention' => $mention,
                        'domaine' => $domaine,
                        'grade' => $grade,
                        'ues' => $ues,
                        'etudiant' => $et['etudiant'],
                        'totalG' => $et['totalG'],
                        'totalGD' => $et['totalGD'],
                        'totalCredit' => $et['totalCredit'],
                        'totalCreditCapitalise' => $et['totalCreditCapitalise'],
                        "institut" => $institut,
                        'totalAssiduite' => $et['totalAssiduite'],
                        'totalAbsence' => $et['totalAbsence'],
                        'totalAbsenceJustifie' => $et['totalAbsenceJustifie'],
                        'resultat' => $resultat,
                        'appreciation' => $apprec,
                        'kernel' => $kernel,
                    ]);
                    $periodeprec = $this->periodePrecRepo->findOneBy(['etudiant' => $et['etudiant'], "classe" => $classe]);
                    if (!$periodeprec) {
                        $periodeprec = (new PeriodePrec())->setEtudiant($et['etudiant'])->setClasse($classe)->setPeriode($periode);
                        $this->em->persist($periodeprec);
                    } else {
                        $periodeprec->setPeriode($periode);
                    }
                    $this->rang($classe, $classe->getNiveau(), $periode);
                    $etParcours = $this->parcoursRepo->findOneBy(['etudiant' => $et['etudiant'], 'classe' => $classe, 'niveau' => $classe->getNiveau(), 'periode' => $periode]);
                    if ($etParcours) {
                        $etParcours->setCreditCapitalise($et["totalCreditCapitalise"])->setMoyenne($resultat)->setAssiduite($et['totalAssiduite']);
                    } else {
                        $parcours = (new Parcours())->setCreditCapitalise($et["totalCreditCapitalise"])->setMoyenne($resultat)
                            ->setAssiduite($et['totalAssiduite'])->setEtudiant($et['etudiant'])->setNiveau($classe->getNiveau())
                            ->setClasse($classe)->setPeriode($periode)->setAnneeAcademic($annee);
                        $this->em->persist($parcours);
                    }
                }
            }
            $html .= $this->renderView("bulletin/S1ALL/footer.html.twig");
            $options = [
                'margin-top' => 0,
                'margin-right' => 0,
                'margin-bottom' => 0,
                'margin-left' => 0,


            ];
            $json = null;
            $filename = $classe->getNomClasse() . '_' . (new \DateTime())->getTimestamp();
            $pdf = null;
            if (count($etudiants) != 0) {
                if ($option == 1) {
                    $filename = str_replace(' ', '', $classe->getNomClasse() . '_Admis_' . str_replace('/', '-', $periode->getLibelle()));
                    $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
                    $file = base64_encode($pdf);
                    if ($this->bulletinRepo->findOneBy(['periode' => $periode, 'classe' => $classe, 'fileName' => $filename])) {
                        $bulletin = $this->bulletinRepo->findOneBy(['classe' => $classe, 'periode' => $periode, 'fileName' => $filename]);
                        $bulletin->setUpdatedAt(new \DateTime());
                    } else {
                        $bulletin = (new Bulletin())->setFile($file)->setFileName($filename)->setClasse($classe)
                            ->setPeriode($periode)->setAdmis(1)->setNonAdmis(0)->setConditionnel(0);
                    }
                    file_put_contents($this->getParameter('bulletin_directory') . '/' . $filename . '.pdf', $pdf);
                } elseif ($option == 2) {
                    $filename = str_replace(' ', '', $classe->getNomClasse() . '_NonAdmis_' . str_replace('/', '-', $periode->getLibelle()));
                    $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
                    $file = base64_encode($pdf);
                    if ($this->bulletinRepo->findOneBy(['periode' => $periode, 'classe' => $classe, 'fileName' => $filename])) {
                        $bulletin = $this->bulletinRepo->findOneBy(['classe' => $classe, 'periode' => $periode, 'fileName' => $filename]);
                        $bulletin->setUpdatedAt(new \DateTime());
                    } else {
                        $bulletin = (new Bulletin())->setFile($file)->setFileName($filename)->setClasse($classe)
                            ->setPeriode($periode)->setAdmis(0)->setNonAdmis(1)->setConditionnel(0);
                    }
                    file_put_contents($this->getParameter('bulletin_directory') . '/' . $filename . '.pdf', $pdf);
                } else {
                    $filename = str_replace(' ', '', $classe->getNomClasse() . '_' . str_replace('/', '-', $periode->getLibelle()));
                    $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
                    $file = base64_encode($pdf);
                    if ($this->bulletinRepo->findOneBy(['periode' => $periode, 'classe' => $classe, 'fileName' => $filename])) {
                        $bulletin = $this->bulletinRepo->findOneBy(['classe' => $classe, 'periode' => $periode, 'fileName' => $filename]);
                        $bulletin->setUpdatedAt(new \DateTime());
                    } else {
                        $bulletin = (new Bulletin())->setFile($file)->setFileName($filename)->setClasse($classe)
                            ->setPeriode($periode);
                    }
                    file_put_contents($this->getParameter('bulletin_directory') . '/' . $filename . '.pdf', $pdf);
                }
                $this->em->persist($bulletin);
                $json = array("id" => $bulletin->getId(), "message" => "success", "file" => $file, "filename" => $filename, "periode" => $bulletin->getPeriode(), "langue" => $bulletin->getLangue(), "admis" => $bulletin->isAdmis(), "nonAdmis" => $bulletin->isNonAdmis(), "conditionnel" => $bulletin->isConditionnel());
                $json = json_encode($json, JSON_PRETTY_PRINT);
            }
            $this->em->flush();
            if (count($etudiants) == 0) {
                if ($option == 1) {
                    $json = array('message' => "Pas d'étudiant admis");
                } elseif ($option == 2) {
                    $json = array('message' => "Pas d'étudiant non admis");
                }

                $json = json_encode($json, JSON_PRETTY_PRINT);
            }
        } else {
            $json = array('message' => "Pas d'étudiant ayant des notes");
            $json = json_encode($json, JSON_PRETTY_PRINT);
        }
        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/api/bulletins/S2/All', name: 'app_:bulletin_S2_all', methods: ['POST'])]
    public function indexSemestre2All(Request $request)
    {
        $data = $request->request;
        $classe = $this->classeRepo->find($data->get('classe'));
        $periodeG = $this->periodeRepo->find($data->get('periode'));
        $ues = $this->ueRepo->findByClasseByPeriode($classe->getId(), $periodeG->getId());
        $dataEt = [];
        $annee = $this->anneeRepo->find($data->get('anneeAcademic'));
        foreach ($classe->getEtudiants() as &$etudiant) {
            $periodeprec = ($this->periodePrecRepo->findOneBy(['etudiant' => $etudiant, "classe" => $classe]))->getPeriode();
            $notes = $this->noteRepo->findBy(["etudiant" => $etudiant, "periode" => $periodeG, "classe" => $classe]);
            $et = [];
            $precBulletin = $this->parcoursRepo->findOneBy(['etudiant' => $etudiant, 'classe' => $classe, 'niveau' => $classe->getNiveau(), 'periode' => $periodeprec]);;
            if ($precBulletin) {
                $CCS = $precBulletin->getCreditCapitalise();
                $MS = $precBulletin->getMoyenne();
            }
            $totalG = 0;
            $totalCredit = 0;
            $totalCreditCapitalise = 0;
            $totalGD = 0;
            $total_absence = 0;
            $total_absence_justifie = 0;
            $absences = $this->absRepo->findByClasseAndPeriode($etudiant, $annee->getAnneeDebut(), $annee->getAnneeFin());
            foreach ($absences as &$absence) {
                $total_absence += $absence->getNbreAbsence();
                $total_absence_justifie += $absence->getAbsenceJustifie();
            }
            $totalAssiduite = $this->calcul($total_absence, $total_absence_justifie);

            $ueComp = [];
            foreach ($ues as &$ue) {
                $creditCapitalise = 0;
                $ue->setNoteFinal(0);
                $ue->setMoyenne(0);
                $ue->setCredit(0);
                $ue->setCoef(0);
                foreach ($ue->getMatieres() as &$matiere) {
                    $exist = false;
                    foreach ($notes as &$note) {
                        if ($note->getMatiere()->getId() == $matiere->getId()) {
                            $exist = true;
                            $matiere->ereaseNote();
                            $matiere->addNote($note);
                            $moyenneCC = number_format(($note->getCc1() + $note->getCc2()) / 2, 2, '.', ',');
                            $noteFinal = number_format(floatval($moyenneCC) * 0.4 + $note->getExamen() * 0.6, 2, '.', ',');
                            $ue->setNoteFinal($ue->getNoteFinal() +
                                floatval($noteFinal) * $matiere->getCoefficients());
                            if (floatval($noteFinal) < 10) {
                                $creditCapitalise += 0;
                            } else {
                                $creditCapitalise += $matiere->getCredits();
                            }
                        }
                    }
                    if (!$exist) {
                        if ($periodeG->getSession()->getIntitule() != "Session 2") {
                            $newNote = (new Note())->setClasse($classe)->setPeriode($periodeG)->setEtudiant($etudiant);
                            $this->em->persist($newNote);
                            array_push($notes, $newNote);
                            $matiere->ereaseNote();
                            $matiere->addNote($newNote);
                        } else {
                            return new Response(null, 500, [], true);
                        }
                    }
                    $ue->setCoef($ue->getCoef() + $matiere->getCoefficients());
                    $ue->setCredit($ue->getCredit() + $matiere->getCredits());
                    $ue->setSession($periodeG->getSession()->getIntitule());
                }
                $ue->setMoyenne(number_format($ue->getNoteFinal() / $ue->getCoef(), 2, '.', ','));
                if ($ue->getMoyenne() < 10) {
                    array_push($ueComp, $ue);
                } else {
                    $creditCapitalise = $ue->getCredit();
                    $ue->setResultat("Validée");
                }
                $ue->setCreditCapitalise($creditCapitalise);
                $totalG += number_format($ue->getMoyenne() * $ue->getCredit(), 2, '.', ',');
                $totalGD += $ue->getCredit() * 20;
                $totalCredit += $ue->getCredit();
                $totalCreditCapitalise += $ue->getCreditCapitalise();
            }
            $resultat = ($totalG + ($totalAssiduite - 10)) / $totalCredit;
            $et['CCS'] = $CCS;
            $et['MS'] = $MS;
            $et['totalAssiduite'] = $totalAssiduite;
            $et['totalAbsence'] = $total_absence;
            $et['totalAbsenceJustifie'] = $total_absence_justifie;
            $et['totalG'] = $totalG;
            $et['totalGD'] = $totalGD;
            $et['totalCredit'] = $totalCredit;
            $et['totalCreditCapitalise'] = $totalCreditCapitalise;
            $et['resultat'] = $resultat;
            $et['etudiant'] = $etudiant;
            $et['ues'] = $ues;
            array_push($dataEt, $et);
        }
        return $this->indexSemestre2Option($dataEt, $request);
    }

    public function indexSemestre2Option(array $dataEt, Request $request)
    {
        if (count($dataEt) > 0) {
            $kernel = $this->getParameter('kernel');
            $data = $request->request;
            $annee = $this->anneeRepo->find($data->get('anneeAcademic'));
            $classe = $this->classeRepo->find($data->get('classe'));
            if ($classe->getProchainNiveau() != 0) {
                $prochain = $this->nivRepo->find($classe->getProchainNiveau())->getIntitule();
            } else {
                $prochain = "fin de cycle";
            }
            $periode = $this->periodeRepo->find($data->get('periode'));
            $institut = $this->instRepo->find($data->get('institut'));
            $parametrage = $annee->getParametrage();
            $appreciations = $parametrage->getAppreciations();
            $spec = $classe->getSpecialisation();
            $mention = $spec->getMention();
            $domaine = $mention->getDomaine();
            $grade = $domaine->getGrade();
            $ues = $this->ueRepo->findByClasseByPeriode($classe->getId(), $periode->getId());
            $html = $this->renderView("bulletin/S2ALL/header.html.twig", [
                'kernel' => $kernel
            ]);
            $option = $data->get('filtre');
            $etudiants = [];
            $etudiantsSession2 = [];
            if ($periode->getSession()->getIntitule() == "Session 2") {
                $passages = $this->passageRepo->findBy(['periode' => $periode, 'classe' => $classe]);
                foreach ($passages as $passage) {
                    if (!in_array($passage->getEtudiant(), $etudiantsSession2)) {
                        array_push($etudiantsSession2, $passage->getEtudiant());
                    }

                }
            }
            if ($option == 1) {
                foreach ($dataEt as $etudiant) {
                    if (($etudiant['CCS'] + $etudiant['totalCreditCapitalise']) == 60) {
                        if (count($etudiantsSession2) > 0) {
                            foreach ($etudiantsSession2 as $item) {
                                if ($item->getId() == $etudiant['etudiant']->getId()) {
                                    array_push($etudiants, $etudiant);
                                }
                            }
                        } else {
                            array_push($etudiants, $etudiant);
                        }
                    }
                }
            } elseif ($option == 2) {
                foreach ($dataEt as $etudiant) {
                    if (($etudiant['CCS'] + $etudiant['totalCreditCapitalise']) < 42) {
                        if (count($etudiantsSession2) > 0) {
                            foreach ($etudiantsSession2 as $item) {
                                if ($item->getId() == $etudiant['etudiant']->getId()) {
                                    array_push($etudiants, $etudiant);
                                }
                            }
                        } else {
                            array_push($etudiants, $etudiant);
                        }
                    }
                }
            } elseif ($option == 3) {
                foreach ($dataEt as $etudiant) {
                    if (($etudiant['CCS'] + $etudiant['totalCreditCapitalise']) >= 42 && ($etudiant['CCS'] + $etudiant['totalCreditCapitalise']) < 60) {
                        if (count($etudiantsSession2) > 0) {
                            foreach ($etudiantsSession2 as $item) {
                                if ($item->getId() == $etudiant['etudiant']->getId()) {
                                    array_push($etudiants, $etudiant);
                                }
                            }
                        } else {
                            array_push($etudiants, $etudiant);
                        }
                    }
                }
            } else {
                if (count($etudiantsSession2) > 0) {
                    foreach ($etudiantsSession2 as $item) {
                        foreach ($dataEt as $etudiant) {
                            if ($item->getId() == $etudiant['etudiant']->getId()) {
                                array_push($etudiants, $etudiant);
                            }
                        }
                    }
                } else {
                    $etudiants = $dataEt;
                }
            }
            foreach ($etudiants as &$Et) {
                $notes = $this->noteRepo->findBy(["etudiant" => $Et['etudiant'], "periode" => $periode, "classe" => $classe]);
                if ($notes) {
                    $apprec = "Echec";
                    $resultat = $Et['resultat'];
                    $totalCreditCapitalise = 0;

                    foreach ($appreciations as $appreciation) {
                        if ($resultat > $appreciation->getMin() && $resultat <= $appreciation->getMax()) {
                            $apprec = $appreciation->getLibelle();
                        }
                    }
                    $etParcours = $this->parcoursRepo->findOneBy(['etudiant' => $Et['etudiant'], 'classe' => $classe, 'niveau' => $classe->getNiveau(), 'periode' => $periode]);
                    if ($etParcours) {
                        $etParcours->setCreditCapitalise($Et["totalCreditCapitalise"])->setMoyenne($resultat)->setAssiduite($Et['totalAssiduite']);
                    } else {
                        $parcours = (new Parcours())->setCreditCapitalise($Et["totalCreditCapitalise"])->setMoyenne($resultat)
                            ->setAssiduite($Et['totalAssiduite'])->setEtudiant($Et['etudiant'])->setNiveau($classe->getNiveau())
                            ->setClasse($classe)->setPeriode($periode)->setAnneeAcademic($annee);
                        $this->em->persist($parcours);
                    }

                    $ueComp = [];
                    foreach ($ues as &$ue) {
                        $ue->setResultat("Non validée");
                        if ($periode->getSession()->getIntitule() == "Session 2") {
                            $sessionUe = $this->passageRepo->findOneBy(['etudiant' => $Et['etudiant'], 'ue' => $ue, 'periode' => $periode]);
                            if ($sessionUe) {
                                $ue->setSession($sessionUe->getPeriode()->getSession()->getIntitule());
                            } else {
                                $ue->setSession("Session 1");
                            }
                        }
                        $creditCapitalise = 0;
                        $ue->setNoteFinal(0);
                        $ue->setMoyenne(0);
                        $ue->setCredit(0);
                        $ue->setCoef(0);
                        foreach ($ue->getMatieres() as &$matiere) {
                            foreach ($notes as &$note) {
                                if ($note->getMatiere()->getId() == $matiere->getId()) {
                                    $matiere->ereaseNote();
                                    $matiere->addNote($note);
                                    $moyenneCC = number_format(($note->getCc1() + $note->getCc2()) / 2, 2, '.', ',');
                                    $noteFinal = number_format($moyenneCC * 0.4 + $note->getExamen() * 0.6, 2, '.', ',');
                                    $ue->setNoteFinal($ue->getNoteFinal() +
                                        $noteFinal * $matiere->getCoefficients());
                                    if ($noteFinal < 10) {
                                        $creditCapitalise += 0;
                                    } else {
                                        $creditCapitalise += $matiere->getCredits();
                                    }
                                }


                            }
                            $ue->setCoef($ue->getCoef() + $matiere->getCoefficients());
                            $ue->setCredit($ue->getCredit() + $matiere->getCredits());
                        }
                        $ue->setMoyenne(number_format($ue->getNoteFinal() / $ue->getCoef(), 2, '.', ','));
                        if ($ue->getMoyenne() < 10) {
                            array_push($ueComp, $ue);
                        } else {
                            $creditCapitalise = $ue->getCredit();
                            $ue->setResultat("Validée");
                        }
                        $ue->setCreditCapitalise($creditCapitalise);
                        $totalCreditCapitalise += $ue->getCreditCapitalise();
                    }
                    if (count($ueComp) != 0) {
                        foreach ($ueComp as &$ue) {
                            $newMoyenne = 0;
                            $compensations = $ue->getCompensations();
                            if (count($compensations) != 0) {
                                $totalCreditCapitaliseComp = 0;
                                foreach ($compensations[0]->getUes() as $ueC) {
                                    $totalCreditCapitaliseComp += $ueC->getCredit();
                                    $newMoyenne += $ueC->getMoyenne() * $ueC->getCreditCapitalise();
                                }
                                if ($totalCreditCapitaliseComp != 0 && (($newMoyenne / $totalCreditCapitaliseComp) > 10) && $ue->getResultat!="Validée") {
                                    $ue->setResultat('Validée par compensation');
                                    $totalCreditCapitalise -= $ue->getCreditCapitalise();
                                    $ue->setCreditCapitalise($ue->getCredit());
                                    $totalCreditCapitalise += $ue->getCreditCapitalise();
                                }
                            }
                        }
                    }
                    if (count($this->recapAnneeRepo->findBy(["etudiant" => $Et['etudiant'], "anneeAcademic" => $annee])) == 0) {
                        $recap = (new RecapAnnee())->setAnneeAcademic($annee)->setTotalCredit($Et['CCS'] + $Et['totalCreditCapitalise'])->setEtudiant($Et['etudiant'])->setMoyenne(($resultat * $Et['MS']) / 2)->setAssiduite($Et['totalAssiduite']);
                        $this->em->persist($recap);
                    } else {
                        $recap = $this->recapAnneeRepo->findOneBy(["etudiant" => $Et['etudiant'], "anneeAcademic" => $annee]);
                        $recap->setTotalCredit($Et['CCS'] + $Et['totalCreditCapitalise'])->setMoyenne(($resultat * $Et['MS']) / 2)->setAssiduite($Et['totalAssiduite']);

                    }
                    $html .= $this->renderView('bulletin/S2ALL/index.html.twig', [
                        'kernel' => $kernel,
                        'controller_name' => 'BulletinController',
                        'annee' => $annee,
                        'classe' => $classe,
                        'periode' => $periode,
                        'specialisation' => $spec,
                        'mention' => $mention,
                        'domaine' => $domaine,
                        'grade' => $grade,
                        'ues' => $ues,
                        'etudiant' => $Et['etudiant'],
                        'totalG' => $Et['totalG'],
                        'totalGD' => $Et['totalGD'],
                        'totalCredit' => $Et['totalCredit'],
                        'totalCreditCapitalise' => $Et['totalCreditCapitalise'],
                        "institut" => $institut,
                        'totalAssiduite' => $Et['totalAssiduite'],
                        'totalAbsence' => $Et['totalAbsence'],
                        'totalAbsenceJustifie' => $Et['totalAbsenceJustifie'],
                        'resultat' => $resultat,
                        'appreciation' => $apprec,
                        "CCS1" => $Et['CCS'],
                        "MS1" => $Et['MS'],
                        'niveau' => $prochain
                    ]);
                }
            }
            $html .= $this->renderView("bulletin/S2ALL/footer.html.twig");
            $options = [
                'margin-top' => 0,
                'margin-right' => 0,
                'margin-bottom' => 0,
                'margin-left' => 0,


            ];
            $json = null;
            $this->rang($classe, $classe->getNiveau(), $periode);
            if (count($etudiants) != 0) {
                if ($option == 1) {
                    $filename = str_replace(' ', '', $classe->getNomClasse() . '_Admis_' . str_replace('/', '-', $periode->getLibelle()));
                    $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
                    $file = base64_encode($pdf);
                    if ($this->bulletinRepo->findOneBy(['periode' => $periode, 'classe' => $classe, 'fileName' => $filename])) {
                        $bulletin = $this->bulletinRepo->findOneBy(['classe' => $classe, 'periode' => $periode, 'fileName' => $filename]);
                        $bulletin->setUpdatedAt(new \DateTime());
                    } else {
                        $bulletin = (new Bulletin())->setFile($file)->setFileName($filename)->setClasse($classe)
                            ->setPeriode($periode)->setAdmis(1)->setNonAdmis(0)->setConditionnel(0);
                    }
                    file_put_contents($this->getParameter('bulletin_directory') . '/' . $filename . '.pdf', $pdf);
                } elseif ($option == 2) {
                    $filename = str_replace(' ', '', $classe->getNomClasse() . '_NonAdmis_' . str_replace('/', '-', $periode->getLibelle()));
                    $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
                    $file = base64_encode($pdf);
                    if ($this->bulletinRepo->findOneBy(['periode' => $periode, 'classe' => $classe, 'fileName' => $filename])) {
                        $bulletin = $this->bulletinRepo->findOneBy(['classe' => $classe, 'periode' => $periode, 'fileName' => $filename]);
                        $bulletin->setUpdatedAt(new \DateTime());
                    } else {
                        $bulletin = (new Bulletin())->setFile($file)->setFileName($filename)->setClasse($classe)
                            ->setPeriode($periode)->setAdmis(0)->setNonAdmis(1)->setConditionnel(0);
                    }
                    file_put_contents($this->getParameter('bulletin_directory') . '/' . $filename . '.pdf', $pdf);
                } elseif ($option == 3) {
                    $filename = str_replace(' ', '', $classe->getNomClasse() . '_Conditionnel_' . str_replace('/', '-', $periode->getLibelle()));
                    $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
                    $file = base64_encode($pdf);
                    if ($this->bulletinRepo->findOneBy(['periode' => $periode, 'classe' => $classe, 'fileName' => $filename])) {
                        $bulletin = $this->bulletinRepo->findOneBy(['classe' => $classe, 'periode' => $periode, 'fileName' => $filename]);
                        $bulletin->setUpdatedAt(new \DateTime());
                    } else {
                        $bulletin = (new Bulletin())->setFile($file)->setFileName($filename)->setClasse($classe)
                            ->setPeriode($periode)->setAdmis(0)->setNonAdmis(0)->setConditionnel(1);
                    }
                    file_put_contents($this->getParameter('bulletin_directory') . '/' . $filename . '.pdf', $pdf);
                } else {
                    $filename = str_replace(' ', '', $classe->getNomClasse() . '_' . str_replace('/', '-', $periode->getLibelle()));
                    $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
                    $file = base64_encode($pdf);
                    if ($this->bulletinRepo->findOneBy(['periode' => $periode, 'classe' => $classe, 'fileName' => $filename])) {
                        $bulletin = $this->bulletinRepo->findOneBy(['classe' => $classe, 'periode' => $periode, 'fileName' => $filename]);
                        $bulletin->setUpdatedAt(new \DateTime());
                    } else {
                        $bulletin = (new Bulletin())->setFile($file)->setFileName($filename)->setClasse($classe)
                            ->setPeriode($periode);
                    }
                    file_put_contents($this->getParameter('bulletin_directory') . '/' . $filename . '.pdf', $pdf);
                }
                $this->em->persist($bulletin);
                $json = array("id" => $bulletin->getId(), "file" => $file, "message" => "success", "filename" => $filename, "periode" => $bulletin->getPeriode(), "langue" => $bulletin->getLangue(), "admis" => $bulletin->isAdmis(), "nonAdmis" => $bulletin->isNonAdmis(), "conditionnel" => $bulletin->isConditionnel());
                $json = json_encode($json, JSON_PRETTY_PRINT);
            }
            $this->em->flush();
            if (count($etudiants) == 0) {
                if ($option == 1) {
                    $json = array('message' => "Pas d'étudiant admis");
                } elseif ($option == 2) {
                    $json = array('message' => "Pas d'étudiant non admis");
                } elseif ($option == 3) {
                    $json = array('message' => "Pas d'étudiant en passage condtionnel");
                }
                $json = json_encode($json, JSON_PRETTY_PRINT);
            }
        } else {
            $json = array('message' => "Pas d'étudiant ayant des notes");
            $json = json_encode($json, JSON_PRETTY_PRINT);
        }
        return new JsonResponse($json, 200, [], true);

    }

    #[Route('/api/bulletins/S1/{id}', name: 'app_bulletin_S1', methods: ['POST'])]
    public function indexSemestre1(Etudiant $etudiant, ParcoursRepository $parcoursRepo, Pdf $knpSnappyPdf, InstitutRepository $instRepo, AbsenceRepository $absRepo, UeRepository $ueRepo, AnneeAcademicRepository $anneeRepo, PeriodeRepository $periodeRepo, ClasseRepository $classeRepo, NoteRepository $noteRepo, Request $request)
    {
        $kernel = $this->getParameter('kernel');
        $data = $request->request;
        $classe = $classeRepo->find($data->get('classe'));
        $periode = $periodeRepo->find($data->get('periode'));

        if (!$data->has('submit')) {
            $notes = $noteRepo->findBy(["etudiant" => $etudiant, "periode" => $periode]);
            $annee = $anneeRepo->find($data->get('anneeAcademic'));
            $jour = new \DateTime();
            $totalAssiduite = 0;
            $total_absence = 0;
            $total_absence_justifie = 0;
            $absences = $absRepo->findByClasseAndPeriode($etudiant, $periode->getDateDebut(), $periode->getDateFin());
            foreach ($absences as &$absence) {
                $total_absence += $absence->getNbreAbsence();
                $total_absence_justifie += $absence->getAbsenceJustifie();
            }
            $totalAssiduite = $this->calcul($total_absence, $total_absence_justifie);
            $institut = $instRepo->find($data->get('institut'));
            $parametrage = $annee->getParametrage();
            $appreciations = $parametrage->getAppreciations();
            $apprec = "Echec";
            $spec = $classe->getSpecialisation();
            $mention = $spec->getMention();
            $domaine = $mention->getDomaine();
            $grade = $domaine->getGrade();
            $totalG = 0;
            $totalCredit = 0;
            $totalCreditCapitalise = 0;
            $totalGD = 0;
            $ues = $ueRepo->findByClasseByPeriode($classe->getId(), $periode->getId());

            $ueComp = [];
            foreach ($ues as &$ue) {
                $ue->setResultat("Non validée");
                if ($periode->getSession()->getIntitule() == "Session 2") {
                    $sessionUe = $this->passageRepo->findOneBy(['etudiant' => $etudiant, 'ue' => $ue, 'periode' => $periode]);
                    if ($sessionUe) {
                        $ue->setSession($sessionUe->getPeriode()->getSession()->getIntitule());
                    } else {
                        $ue->setSession("Session 1");
                    }
                } else {
                    $ue->setSession("Session 1");
                }
                $creditCapitalise = 0;
                $ue->setNoteFinal(0);
                foreach ($ue->getMatieres() as &$matiere) {
                    $exist = false;
                    foreach ($notes as &$note) {
                        if ($note->getMatiere()->getId() == $matiere->getId()) {
                            $exist = true;
                            $matiere->ereaseNote();
                            $matiere->addNote($note);
                            $moyenneCC = number_format(($note->getCc1() + $note->getCc2()) / 2, 2, '.', ',');
                            $noteFinal = number_format($moyenneCC * 0.4 + $note->getExamen() * 0.6, 2, '.', ',');
                            $ue->setNoteFinal($ue->getNoteFinal() +
                                $noteFinal * $matiere->getCoefficients());
                            if ($noteFinal < 10) {
                                $creditCapitalise += 0;
                            } else {
                                $creditCapitalise += $matiere->getCredits();
                            }
                        }
                    }
                    if (!$exist) {
                        if ($periode->getSession()->getIntitule() != "Session 2") {
                            $newNote = (new Note())->setClasse($classe)->setPeriode($periode)->setEtudiant($etudiant);
                            $this->em->persist($newNote);
                            array_push($notes, $newNote);
                            $matiere->ereaseNote();
                            $matiere->addNote($newNote);
                        } else {
                            return new Response(null, 500, [], true);
                        }
                    }
                    $ue->setCoef($ue->getCoef() + $matiere->getCoefficients());
                    $ue->setCredit($ue->getCredit() + $matiere->getCredits());
                }
                $ue->setMoyenne(number_format($ue->getNoteFinal() / $ue->getCoef(), 2, '.', ','));
                if ($ue->getMoyenne() < 10) {
                    array_push($ueComp, $ue);
                } else {
                    $creditCapitalise = $ue->getCredit();
                    $ue->setResultat("Validée");
                }
                $ue->setCreditCapitalise($creditCapitalise);
                $totalG += number_format($ue->getMoyenne() * $ue->getCredit(), 2, '.', ',');
                $totalGD += $ue->getCredit() * 20;
                $totalCredit += $ue->getCredit();
                $totalCreditCapitalise += $ue->getCreditCapitalise();
            }
            if (count($ueComp) != 0) {
                foreach ($ueComp as &$ue) {
                    $newMoyenne = 0;
                    $compensations = $ue->getCompensations();
                    if (count($compensations) > 0) {
                        $totalCreditCapitaliseComp = 0;
                        foreach ($compensations[0]->getUes() as &$ueC) {
                            $totalCreditCapitaliseComp += $ueC->getCredit();
                            $newMoyenne += $ueC->getMoyenne() * $ueC->getCreditCapitalise();
                        }
                        if ($totalCreditCapitaliseComp != 0 && (($newMoyenne / $totalCreditCapitaliseComp) > 10) && $ue->getResultat() != "Validée" ) {
                            $ue->setResultat('Validée par compensation');
                            $totalCreditCapitalise -= $ue->getCreditCapitalise();
                            $ue->setCreditCapitalise($ue->getCredit());
                            $totalCreditCapitalise += $ue->getCreditCapitalise();
                        }
                    }
                }
            }
            $resultat = ($totalG + ($totalAssiduite - 10)) / $totalCredit;
            foreach ($appreciations as $appreciation) {
                if ($resultat > $appreciation->getMin() && $resultat <= $appreciation->getMax()) {
                    $apprec = $appreciation->getLibelle();
                }
            }
            $html = $this->renderView('bulletin/S1/index.html.twig', [
                'kernel' => $kernel,
                'controller_name' => 'BulletinController',
                'annee' => $annee,
                'classe' => $classe,
                'periode' => $periode,
                'specialisation' => $spec,
                'mention' => $mention,
                'domaine' => $domaine,
                'grade' => $grade,
                'ues' => $ues,
                'notes' => $notes,
                'etudiant' => $etudiant,
                'totalG' => $totalG,
                'totalGD' => $totalGD,
                'totalCredit' => $totalCredit,
                'totalCreditCapitalise' => $totalCreditCapitalise,
                "institut" => $institut,
                "jour" => $jour,
                'totalAssiduite' => $totalAssiduite,
                'totalAbsence' => $total_absence,
                'totalAbsenceJustifie' => $total_absence_justifie,
                'resultat' => $resultat,
                'appreciation' => $apprec
            ]);
        }
        if ($html) {
            $options = [
                'margin-top' => 0,
                'margin-right' => 0,
                'margin-bottom' => 0,
                'margin-left' => 0,
                'page-size' => 'A4'
            ];
            $periodeprec = $this->periodePrecRepo->findOneBy(['etudiant' => $etudiant, "classe" => $classe]);
            if (!$periodeprec) {
                $periodeprec = (new PeriodePrec())->setEtudiant($etudiant)->setClasse($classe)->setPeriode($periode);
                $this->em->persist($periodeprec);
            } else {
                $periodeprec->setPeriode($periode);
            }
            $filename = str_replace(' ', '', $etudiant->getPrenom() . " " . $etudiant->getNom() . '_' . str_replace('/', '-', $periode->getLibelle()));
            $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
            $file = base64_encode($pdf);
            if ($this->bulletinRepo->findOneBy(['etudiant' => $etudiant, 'periode' => $periode, 'classe' => $classe])) {
                $bulletin = $this->bulletinRepo->findOneBy(['etudiant' => $etudiant, 'periode' => $periode, 'classe' => $classe]);
                $bulletin->setUpdatedAt(new \DateTime());
            } else {
                $bulletin = (new Bulletin())->setFile($file)->setFileName($filename)->setEtudiant($etudiant)
                    ->setPeriode($periode)->setClasse($classe);
            }
            file_put_contents($this->getParameter('bulletin_directory') . '/' . $filename . '.pdf', $pdf);
            $this->em->persist($bulletin);
            $this->rang($classe, $classe->getNiveau(), $periode);
            $etParcours = $this->parcoursRepo->findOneBy(['etudiant' => $etudiant, 'classe' => $classe, 'niveau' => $classe->getNiveau(), 'periode' => $periode]);
            if ($etParcours) {
                $etParcours->setCreditCapitalise($totalCreditCapitalise)->setMoyenne($resultat)->setAssiduite($totalAssiduite);
            } else {
                $parcours = (new Parcours())->setCreditCapitalise($totalCreditCapitalise)->setMoyenne($resultat)
                    ->setAssiduite($totalAssiduite)->setEtudiant($etudiant)->setClasse($classe)->setPeriode($periode)
                    ->setNiveau($classe->getNiveau())->setAnneeAcademic($annee);
                $this->em->persist($parcours);
            }
            $this->em->flush();
            $json = array("id" => $bulletin->getId(), "file" => $file, "message" => "success", "filename" => $filename, "periode" => $bulletin->getPeriode(), "langue" => $bulletin->getLangue(), "admis" => $bulletin->isAdmis(), "nonAdmis" => $bulletin->isNonAdmis(), "conditionnel" => $bulletin->isConditionnel());

        }
        $json = json_encode($json, JSON_PRETTY_PRINT);
        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/api/bulletins/S2/{id}', name: 'app_bulletin_S2', methods: ['POST'])]
    public function indexSemestre2(Etudiant $etudiant, ParcoursRepository $parcoursRepo, Pdf $knpSnappyPdf, InstitutRepository $instRepo, AbsenceRepository $absRepo, UeRepository $ueRepo, AnneeAcademicRepository $anneeRepo, PeriodeRepository $periodeRepo, ClasseRepository $classeRepo, NoteRepository $noteRepo, Request $request)
    {
        $kernel = $this->getParameter('kernel');
        $data = $request->request;

        $classe = $classeRepo->find($data->get('classe'));
        if ($classe->getProchainNiveau() != 0) {
            $prochain = $this->nivRepo->find($classe->getProchainNiveau())->getIntitule();
        } else {
            $prochain = "fin de cycle";
        }
        $periodeG = $periodeRepo->find($data->get('periode'));
        //$passage  = $this->passageRepo->findOneBy(["periode"=>$periodeG,"classe"=>$classe,"etudiant"=>$etudiant]);

        $notes = $noteRepo->findBy(["etudiant" => $etudiant, "periode" => $periodeG]);
        $periodeprec = ($this->periodePrecRepo->findOneBy(['etudiant' => $etudiant, "classe" => $classe]))->getPeriode();
        $precBulletin = $this->parcoursRepo->findOneBy(['etudiant' => $etudiant, 'classe' => $classe, 'niveau' => $classe->getNiveau(), 'periode' => $periodeprec]);;
        if ($precBulletin) {
            $CCS = $precBulletin->getCreditCapitalise();
            $MS = $precBulletin->getMoyenne();
        }
        $annee = $anneeRepo->find($data->get('anneeAcademic'));
        $jour = new \DateTime();
        $totalAssiduite = 0;
        $total_absence = 0;
        $total_absence_justifie = 0;
        $absences = $absRepo->findByClasseAndPeriode($etudiant, $annee->getAnneeDebut(), $annee->getAnneeFin());
        foreach ($absences as &$absence) {
            $total_absence += $absence->getNbreAbsence();
            $total_absence_justifie += $absence->getAbsenceJustifie();
        }
        $totalAssiduite = $this->calcul($total_absence, $total_absence_justifie);
        $institut = $instRepo->find($data->get('institut'));
        $parametrage = $annee->getParametrage();
        $appreciations = $parametrage->getAppreciations();
        $apprec = "Echec";
        $spec = $classe->getSpecialisation();
        $mention = $spec->getMention();
        $domaine = $mention->getDomaine();
        $grade = $domaine->getGrade();
        $totalG = 0;
        $totalCredit = 0;
        $totalCreditCapitalise = 0;
        $totalGD = 0;
        $ues = $ueRepo->findByClasseByPeriode($classe->getId(), $periodeG->getId());

        $ueComp = [];
        foreach ($ues as &$ue) {
            $ue->setResultat("Non Validée");
            if ($periodeG->getSession()->getIntitule() == "Session 2") {
                $sessionUe = $this->passageRepo->findOneBy(['etudiant' => $etudiant, 'ue' => $ue, 'periode' => $periodeG]);
                if ($sessionUe) {
                    $ue->setSession($sessionUe->getPeriode()->getSession()->getIntitule());
                } else {
                    $ue->setSession("Session 1");
                }
            } else {
                $ue->setSession("Session 1");
            }
            $creditCapitalise = 0;
            $ue->setNoteFinal(0);

            foreach ($ue->getMatieres() as &$matiere) {
                $exist = false;
                foreach ($notes as &$note) {
                    if ($note->getMatiere()->getId() == $matiere->getId()) {
                        $exist = true;
                        $matiere->ereaseNote();
                        $matiere->addNote($note);
                        $moyenneCC = number_format(($note->getCc1() + $note->getCc2()) / 2, 2, '.', ',');
                        $noteFinal = number_format($moyenneCC * 0.4 + $note->getExamen() * 0.6, 2, '.', ',');
                        $ue->setNoteFinal($ue->getNoteFinal() +
                            $noteFinal * $matiere->getCoefficients());
                        if ($noteFinal < 10) {
                            $creditCapitalise += 0;
                        } else {
                            $creditCapitalise += $matiere->getCredits();
                        }
                    }
                }
                if (!$exist) {
                    if ($periodeG->getSession()->getIntitule() != "Session 2") {
                        $newNote = (new Note())->setClasse($classe)->setPeriode($periodeG)->setEtudiant($etudiant);
                        $this->em->persist($newNote);
                        array_push($notes, $newNote);
                        $matiere->ereaseNote();
                        $matiere->addNote($newNote);
                    } else {
                        return new Response(null, 500, [], true);
                    }
                }
                $ue->setCoef($ue->getCoef() + $matiere->getCoefficients());
                $ue->setCredit($ue->getCredit() + $matiere->getCredits());
            }
            $ue->setMoyenne(number_format($ue->getNoteFinal() / $ue->getCoef(), 2, '.', ','));
            if ($ue->getMoyenne() < 10) {
                array_push($ueComp, $ue);
            } else {
                $creditCapitalise = $ue->getCredit();
                $ue->setResultat("Validée");
            }
            $ue->setCreditCapitalise($creditCapitalise);
            $totalG += number_format($ue->getMoyenne() * $ue->getCredit(), 2, '.', ',');
            $totalGD += $ue->getCredit() * 20;
            $totalCredit += $ue->getCredit();
            $totalCreditCapitalise += $ue->getCreditCapitalise();
        }
        if (count($ueComp) != 0) {
            foreach ($ueComp as &$ue) {
                $newMoyenne = 0;
                $compensations = $ue->getCompensations();
                if (count($compensations) != 0) {
                    $totalCreditCapitaliseComp = 0;
                    foreach ($compensations[0]->getUes() as $ueC) {
                        $totalCreditCapitaliseComp += $ueC->getCredit();
                        $newMoyenne += $ueC->getMoyenne() * $ueC->getCreditCapitalise();
                    }
                    if ($totalCreditCapitaliseComp != 0 && (($newMoyenne / $totalCreditCapitaliseComp) > 10) && $ue->getResultat!="Validée") {
                        $ue->setResultat('Validée par compensation');
                        $totalCreditCapitalise -= $ue->getCreditCapitalise();
                        $ue->setCreditCapitalise($ue->getCredit());
                        $totalCreditCapitalise += $ue->getCreditCapitalise();
                    }
                }
            }
        }
        $resultat = ($totalG + ($totalAssiduite - 10)) / $totalCredit;
        foreach ($appreciations as $appreciation) {
            if ($resultat > $appreciation->getMin() && $resultat <= $appreciation->getMax()) {
                $apprec = $appreciation->getLibelle();
            }
        }
        if (count($this->recapAnneeRepo->findBy(["etudiant" => $etudiant, "anneeAcademic" => $annee])) == 0) {
            $recap = (new RecapAnnee())->setAnneeAcademic($annee)->setTotalCredit($CCS + $totalCreditCapitalise)->setEtudiant($etudiant)->setMoyenne(($resultat + $MS) / 2)->setAssiduite($totalAssiduite);
            $this->em->persist($recap);
        } else {
            $recap = $this->recapAnneeRepo->findOneBy(["etudiant" => $etudiant, "anneeAcademic" => $annee]);
            $recap->setTotalCredit($CCS + $totalCreditCapitalise)->setMoyenne(($resultat + $MS) / 2)->setAssiduite($totalAssiduite);
        }
        $html = $this->renderView('bulletin/S2/index.html.twig', [
            'kernel' => $kernel,
            'controller_name' => 'BulletinController',
            'annee' => $annee,
            'classe' => $classe,
            'periode' => $periodeG,
            'specialisation' => $spec,
            'mention' => $mention,
            'domaine' => $domaine,
            'grade' => $grade,
            'ues' => $ues,
            'notes' => $notes,
            'etudiant' => $etudiant,
            'totalG' => $totalG,
            'totalGD' => $totalGD,
            'totalCredit' => $totalCredit,
            'totalCreditCapitalise' => $totalCreditCapitalise,
            "institut" => $institut,
            "jour" => $jour,
            'totalAssiduite' => $totalAssiduite,
            'totalAbsence' => $total_absence,
            'totalAbsenceJustifie' => $total_absence_justifie,
            'resultat' => $resultat,
            'appreciation' => $apprec,
            "CCS1" => $CCS,
            "MS1" => $MS,
            'niveau' => $prochain

        ]);
        $options = [
            'margin-top' => 0,
            'margin-right' => 0,
            'margin-bottom' => 0,
            'margin-left' => 0,
            'page-size' => 'A4'

        ];
        $filename = str_replace(' ', '', $etudiant->getPrenom() . " " . $etudiant->getNom() . '_' . str_replace('/', '-', $periodeG->getLibelle()));
        $pdf = $this->knpSnappyPdf->getOutputFromHtml($html, $options);
        $file = base64_encode($pdf);
        if ($this->bulletinRepo->findOneBy(['etudiant' => $etudiant, 'periode' => $periodeG, 'classe' => $classe])) {
            $bulletin = $this->bulletinRepo->findOneBy(['etudiant' => $etudiant, 'periode' => $periodeG, 'classe' => $classe]);
            $bulletin->setUpdatedAt(new \DateTime());
        } else {
            $bulletin = (new Bulletin())->setFile($file)->setFileName($filename)->setEtudiant($etudiant)
                ->setPeriode($periodeG)->setClasse($classe);
        }
        file_put_contents($this->getParameter('bulletin_directory') . '/' . $filename . '.pdf', $pdf);
        $this->em->persist($bulletin);
        $this->rang($classe, $classe->getNiveau(), $periodeG);
        $etParcours = $this->parcoursRepo->findOneBy(['etudiant' => $etudiant, 'classe' => $classe, 'niveau' => $classe->getNiveau(), 'periode' => $periodeG]);
        if ($etParcours) {
            $etParcours->setCreditCapitalise($totalCreditCapitalise)->setMoyenne($resultat)->setAssiduite($totalAssiduite);
        } else {
            $parcours = (new Parcours())->setCreditCapitalise($totalCreditCapitalise)->setMoyenne($resultat)
                ->setAssiduite($totalAssiduite)->setEtudiant($etudiant)->setClasse($classe)->setPeriode($periodeG)
                ->setNiveau($classe->getNiveau())->setAnneeAcademic($annee);
            $this->em->persist($parcours);
        }
        $this->em->flush();
        $json = array("id" => $bulletin->getId(), "file" => $file, "message" => "success", "filename" => $filename, "periode" => $bulletin->getPeriode(), "langue" => $bulletin->getLangue(), "admis" => $bulletin->isAdmis(), "nonAdmis" => $bulletin->isNonAdmis(), "conditionnel" => $bulletin->isConditionnel());


        $json = json_encode($json, JSON_PRETTY_PRINT);
        return new JsonResponse($json, 200, [], true);
    }

    public function rang(Classe $classe, Niveau $niveau, Periode $periode): void
    {
        $parcours = $this->parcoursRepo->findBy(['classe' => $classe, 'niveau' => $niveau, 'periode' => $periode]);
        usort($parcours, fn($a, $b) => $a->getMoyenne() < $b->getMoyenne());
        $sortRang = 0;
        foreach ($parcours as &$par) {
            $par->setRang(++$sortRang);
        }
        $this->em->flush();

    }
}
