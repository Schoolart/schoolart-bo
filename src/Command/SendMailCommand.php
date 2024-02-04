<?php
namespace App\Command;

use App\Controller\FactureController;
use App\Entity\FactureEtudiant;
use App\Entity\Institut;
use App\Entity\ParametrageInstitut;
use App\Repository\FactureEtudiantRepository;
use App\Repository\ParametrageInstitutRepository;
use App\Service\ContactNotification;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(
    name: 'app:send-email',
    description: 'Send email',
    hidden: false,
)]
class SendMailCommand extends Command
{
    public function __construct(
        private ContactNotification $notify,
        private FactureEtudiantRepository $factureRepo,
        private ParametrageInstitutRepository $paramRepo,
        private FactureController $factureController
    ){
        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('tache cron start');
        $paramInstituts = $this->paramRepo->findBy(['envoiAutomatiqueFacture'=>true]);
        foreach ($paramInstituts as $paramInstitut) {
            $institut = $paramInstitut->getInstitut();
            $output->writeln('institut : '.$institut->getNom());
            $anneeAcademic = $paramInstitut->getAnneeAcademic();
            $output->writeln('Annee Academic : '.$anneeAcademic->getLibelle());
            $factureEtudiants  =  $this->factureRepo->findByAnneAndByDate($anneeAcademic,false,date_add((new \DateTime),\DateInterval::createFromDateString($paramInstitut->getJourEnvoiAvantDateLimite().' day')));
            foreach ($factureEtudiants as $factureEtudiant) {
                $pdf  = $this->factureController->generateFacture($factureEtudiant->getEtudiant(),$factureEtudiant->getClasse(),$anneeAcademic,$institut,$factureEtudiant);
                $this->notify->SendFacture($factureEtudiant,$pdf,$institut,$this->factureController->getKernel(),$factureEtudiant->getEtudiant()->getPrenom() . " " . $factureEtudiant->getEtudiant()->getNom());
                $output->writeln('mail send');
            }
        }
        $output->writeln('tache cron stop');
        return Command::SUCCESS;
    }
}
