<?php

namespace App\Controller;

use App\Repository\ProfileRepository;
use App\Repository\SousDroitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DroitController extends AbstractController
{
    private EntityManagerInterface $em;
    private $profileRepo;
    public function __construct(ProfileRepository $profileRepo,EntityManagerInterface $em){
        $this->profileRepo =  $profileRepo;
        $this->em=$em;
    }
    #[Route('/api/droit/duplicate', name: 'app_droit_duplicate',methods: ["POST"])]
    public function index(Request $request): Response
    {
        $data  = $request->request;
        $profilNew  = $this->profileRepo->find($data->get('profilNew'));
        $profilOld = $this->profileRepo->find($data->get('profilOld'));
        if($profilNew){
            $droits = clone $profilOld->getDroits();
            foreach ($droits as $droit){
                $new_droit =  clone $droit;
                $new_droit->clearId();
                foreach ($droit->getSousDroits() as $sousDroit){
                    $new_sousDroit = clone $sousDroit;
                    $new_sousDroit->clearId();
                    $new_droit->addSousDroit($new_sousDroit);
                }
                $profilNew->addDroit($new_droit);
            }
            $this->em->flush();
            return new Response(null,200,[],false);
        }

        return new Response(null,500,[],false);
    }
}
