<?php
     namespace App\Controller;

     use App\Entity\Etudiant;
     use App\Entity\User;
     use App\Repository\InstitutRepository;
use App\Service\ContactNotification;
use PhpParser\Node\Expr\Throw_;
     use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
     use Symfony\Component\HttpFoundation\JsonResponse;
     use Symfony\Component\HttpFoundation\Request;
     use Symfony\Component\HttpFoundation\Response;
     use Symfony\Component\Routing\Annotation\Route;

     class UserController extends AbstractController {

         public function __invoke(Request $request)
         {
             $file  = $request->files->get('file');
             $etudiant = $request->attributes->get('data');
             if(!($etudiant instanceof Etudiant)){
                 Throw new \RuntimeException("Etudiant attendu");
             }
             $etudiant->setImage($file);
             return $etudiant;
         }
        #[Route('/api/user/reset/{id}', name: 'app-user-reset')]
        public function planning(User $user,Request $request, InstitutRepository $institutRepository,ContactNotification $notify): Response
        {
            $kernel = $this->getParameter('kernel');
            $data  = $request->request;
            $institut= $institutRepository->find($data->get('institut'));
            $notify->ResetPassword($user,$institut,$kernel);
            return new JsonResponse([], 200, [], false);
        }
}