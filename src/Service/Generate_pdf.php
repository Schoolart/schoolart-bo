<?php

namespace App\Service;

use App\Entity\AnneeAcademic;
use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Entity\FicheIdentification;
use App\Entity\Institut;
use App\Entity\Niveau;
use App\Entity\Specialisation;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Generate_pdf
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;

    }

    public function generate(string $qr,string $filename,AnneeAcademic $annee,Classe $classe,Institut $institut,Etudiant $etudiant,string $photo,string $logo){
        return $this->client->request('POST', 'https://api.pdfmonkey.io/api/v1/documents',[
            "json"=>[
                "document"=> [
                    "document_template_id"=> "E81B89CE-ECA8-4E14-82E9-06ACFA1C3C0A",
                    "payload" => [
                        "etablis"=>$institut->getEtablissement()->getNom(),
                        "annee"=>$annee->getLibelle(),
                        "institut"=>$institut->getNom(),
                        "nom"=>$etudiant->getNom(),
                        "prenom"=>$etudiant->getPrenom(),
                        "naiss"=>"Né(e) le ".$etudiant->getDateNaissance()->format("d F Y") ." à ".$etudiant->getVilleNaissance(),
                        "grade"=>$classe->getSpecialisation()->getMention()->getDomaine()->getGrade()->getIntitule(),
                        "matricule"=>$etudiant->getIdentifiant(),
                        "classe"=>$classe->getNomClasse()?$classe->getNomClasse():$classe->getDescription(),
                        "adresse"=>$institut->getAdresse1().' - BP '.$institut->getCodePostal().' Fann -'.' '.$institut->getVille(),
                        "tel"=>'Tel: '.$institut->getTelephone(),
                        "qr"=>$qr,
                        "ism"=>$logo,
                        "photo"=>$photo
                    ],
                    "meta"=> [
                        "clientId"=>"E81B89CE-ECA8-4E14-82E9-06ACFA1C3C0A",
                        "_filename"=>$filename,
                    ],
                    "status"=> "pending",
                ]
            ],
            "headers"=>[
                'Accept' => 'application/json',
                "Content-Type" => "application/json; charset=UTF-8",
                'Authorization' => 'Bearer EybY6J6WVgEn1pPZkdSy',
            ]

        ]);


    }
    public function getPdf(string $id){
        return $this->client->request('GET', 'https://api.pdfmonkey.io/api/v1/document_cards/'.$id,[
            "headers"=>[
                'Accept' => 'application/json',
                "Content-Type" => "application/json; charset=UTF-8",
                'Authorization' => 'Bearer EybY6J6WVgEn1pPZkdSy',
            ]

        ]);

    }
    public function deletePdf(string $id){
        $this->client->request('DELETE', 'https://api.pdfmonkey.io/api/v1/documents/'.$id,[
            "headers"=>[
                'Accept' => 'application/json',
                "Content-Type" => "application/json; charset=UTF-8",
                'Authorization' => 'Bearer EybY6J6WVgEn1pPZkdSy',
            ]
        ]);

    }

    public function generateFicheIdentification(FicheIdentification $fiche,string $logo){
       dd($fiche->getMatieres()->toArray());
        return $this->client->request('POST', 'https://api.pdfmonkey.io/api/v1/documents',[
            "json"=>[
                "document"=> [
                    "document_template_id"=> "B8476658-B702-40C1-A7D4-B8F5C1E292D8",
                    "payload" => [
                        "ism"=>$logo,
                        "fiche"=> json_encode($fiche),
                        "dateNow"=> (new \DateTime())->format("d/m/y")
                    ],
                    "meta"=> [
                        "clientId"=>"B8476658-B702-40C1-A7D4-B8F5C1E292D8",
                        "_filename"=> $fiche->getProfesseur()->getPrenom().'_'.$fiche->getProfesseur()->getNom().'_'.$fiche->getInstitut()->getNom(),
                    ],
                    "status"=> "pending",
                ]
            ],
            "headers"=>[
                'Accept' => 'application/json',
                "Content-Type" => "application/json; charset=UTF-8",
                'Authorization' => 'Bearer EybY6J6WVgEn1pPZkdSy',
            ]

        ]);

    }

}