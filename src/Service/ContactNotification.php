<?php
namespace App\Service;

use App\Entity\Etudiant;
use App\Entity\FactureEtudiant;
use App\Entity\Institut;
use App\Entity\Paiement;
use App\Entity\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Idearia\Logger;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;

class ContactNotification
{

    /**
     * @var Environment|null
     */
    private $environment;
    private $mailer;
    private $entreprise = [
        'nom'=>'MegaOctetSolution',
        'email'=>'megaoctetsolutionschoolart@gmail.com',
        'adresse1'=>'Liberte 6',
        'siteWeb'=>'https://schoolart.megaoctetsolution.com',
        'telephone'=>'775909087',
        'logo'=>'logoMegaOctet.png'
    ];
    private $senderMail = "megaoctetsolutionschoolart@gmail.com";

    public function __construct(Environment $environment,MailerInterface $mailer)
    {

        $this->environment = $environment;
        $this->mailer =  $mailer;
    }

    public function NewEtudiantNotify(Etudiant $contact,Institut $institut,string $kernel)
    {
        try{
            $logo = 'data:image/' . explode('.',$institut->getLogo())[1]. ';base64,' .base64_encode(file_get_contents($kernel."/public/images/instituts/".$institut->getLogo(), FILE_USE_INCLUDE_PATH));
            $mega = 'data:image/' . explode('.',$this->entreprise['logo'])[1]. ';base64,' .base64_encode(file_get_contents($kernel."/public/".$this->entreprise['logo'], FILE_USE_INCLUDE_PATH));

            $client = new Client([
                    'base_uri' => "https://dmnm98.api.infobip.com/",
                    'headers' => [
                        'Authorization' => "App b64549475098ccdf29c8268849ec45c8-37e6ecac-e013-4e86-a7b3-0f5b355b1506",
                        'Content-Type' => 'multipart/form-data',
                        'Accept' => 'application/json',
                    ]
                ]);
                $response = $client->request(
                    'POST',
                    'email/2/send',
                    [
                        RequestOptions::MULTIPART => [
                            ['name' => 'from', 'contents' => $this->senderMail],
                            ['name' => 'to', 'contents' => "komla.adaisso@ism.edu.sn"],
                            ['name' => 'subject', 'contents' => "Lettre d'admission"],
                            ['name' => 'html', 'contents' => $this->environment->render('mail/admission.html.twig',
                            [
                                'password'=>base64_decode($contact->getPss()),
                                'contact'=>$contact,
                                "institut"=>$institut,
                                "entreprise"=>$this->entreprise,
                                'logo'=>$logo,
                                "mega"=>$mega
                            ])],
                            // example how to attach a file
                            /*[
                                'Content-type' => 'multipart/form-data',
                                'name' => 'file',
                                'contents' => fopen('/tmp/testfile.pdf', 'r'),
                                'filename' => 'testfile.pdf',
                            ],*/
                        ],
                    ]
                );
                Logger::info( "send mail success" );
        }catch(ClientException $e){
            Logger::error( "send mail impossible , verifier votre fournisseur d'envoie de mail " );
        }

    }
    public function NewEtudiantOfficielNotify(Etudiant $contact,Institut $institut,string $kernel)
    {
        try{
            $logo = 'data:image/' . explode('.',$institut->getLogo())[1]. ';base64,' .base64_encode(file_get_contents($kernel."/public/images/instituts/".$institut->getLogo(), FILE_USE_INCLUDE_PATH));
            $mega = 'data:image/' . explode('.',$this->entreprise['logo'])[1]. ';base64,' .base64_encode(file_get_contents($kernel."/public/".$this->entreprise['logo'], FILE_USE_INCLUDE_PATH));

            $client = new Client([
                    'base_uri' => "https://dmnm98.api.infobip.com/",
                    'headers' => [
                        'Authorization' => "App b64549475098ccdf29c8268849ec45c8-37e6ecac-e013-4e86-a7b3-0f5b355b1506",
                        'Content-Type' => 'multipart/form-data',
                        'Accept' => 'application/json',
                    ]
                ]);
                $response = $client->request(
                    'POST',
                    'email/2/send',
                    [
                        RequestOptions::MULTIPART => [
                            ['name' => 'from', 'contents' => $this->senderMail],
                            ['name' => 'to', 'contents' => "komla.adaisso@ism.edu.sn"],
                            ['name' => 'subject', 'contents' => "Lettre d'inscription"],
                            ['name' => 'html', 'contents' => $this->environment->render('mail/inscription.html.twig',
                            [
                                'password'=>base64_decode($contact->getPss()),
                                'contact'=>$contact,
                                "institut"=>$institut,
                                "entreprise"=>$this->entreprise,
                                'logo'=>$logo,
                                "mega"=>$mega
                            ])],
                            // example how to attach a file
                            /*[
                                'Content-type' => 'multipart/form-data',
                                'name' => 'file',
                                'contents' => fopen('/tmp/testfile.pdf', 'r'),
                                'filename' => 'testfile.pdf',
                            ],*/
                        ],
                    ]
                );
                Logger::info( "send mail success" );
        }catch(ClientException $e){
            Logger::error( "send mail impossible , verifier votre fournisseur d'envoie de mail " );
        }
    }
      public function SendRecu(Paiement $paiement,Institut $institut,string $kernel)
    {
        try{
            $logo = 'data:image/' . explode('.',$institut->getLogo())[1]. ';base64,' .base64_encode(file_get_contents($kernel."/public/images/instituts/".$institut->getLogo(), FILE_USE_INCLUDE_PATH));
            $mega = 'data:image/' . explode('.',$this->entreprise['logo'])[1]. ';base64,' .base64_encode(file_get_contents($kernel."/public/".$this->entreprise['logo'], FILE_USE_INCLUDE_PATH));

            $client = new Client([
                    'base_uri' => "https://dmnm98.api.infobip.com/",
                    'headers' => [
                        'Authorization' => "App b64549475098ccdf29c8268849ec45c8-37e6ecac-e013-4e86-a7b3-0f5b355b1506",
                        'Content-Type' => 'multipart/form-data',
                        'Accept' => 'application/json',
                    ]
                ]);
                $response = $client->request(
                    'POST',
                    'email/2/send',
                    [
                        RequestOptions::MULTIPART => [
                            ['name' => 'from', 'contents' => $this->senderMail],
                            ['name' => 'to', 'contents' => "komla.adaisso@ism.edu.sn"],
                            ['name' => 'subject', 'contents' => "Paiement scolarité"],
                            ['name' => 'html', 'contents' => $this->environment->render('mail/paiement.html.twig',
                            [
                                'paiement'=>$paiement,
                                "institut"=>$institut,
                                "entreprise"=>$this->entreprise,
                                'logo'=>$logo,
                                "mega"=>$mega
                            ])],
                            // example how to attach a file
                            /*[
                                'Content-type' => 'multipart/form-data',
                                'name' => 'file',
                                'contents' => fopen('/tmp/testfile.pdf', 'r'),
                                'filename' => 'testfile.pdf',
                            ],*/
                        ],
                    ]
                );
                $response = $client->request(
                'POST',
                'whatsapp/1/message/template',
                [
                    RequestOptions::JSON => [
                        'messages' => [
                            [
                                'from' => '447860099299',
                                'to' => "221775909087",
                                'content' => [
                                    'templateName' => 'registration_success',
                                    'templateData' => [
                                        'body' => [
                                            'placeholders' => ['sender', 'message', 'delivered', 'testing']
                                        ],
                                        'header' => [
                                            'type' => 'IMAGE',
                                            'mediaUrl' => 'https://api.infobip.com/ott/1/media/infobipLogo',
                                        ],
                                        'buttons' => [
                                            ['type' => 'QUICK_REPLY', 'parameter' => 'yes-payload'],
                                            ['type' => 'QUICK_REPLY', 'parameter' => 'no-payload'],
                                            ['type' => 'QUICK_REPLY', 'parameter' => 'later-payload']
                                        ]
                                    ],
                                    'language' => 'en',
                                ],
                            ]
                        ]
                    ],
                ]
            );
            Logger::info( "send mail success" );
        }catch(ClientException $e){
            Logger::error( "send mail impossible , verifier votre fournisseur d'envoie de mail " );
        }
    }

     public function SendFacture(FactureEtudiant $factureEtudiant,string $pdf,$institut,$kernel,$filename)
    {
        try{
            $logo = 'data:image/' . explode('.',$institut->getLogo())[1]. ';base64,' .base64_encode(file_get_contents($kernel."/public/images/instituts/".$institut->getLogo(), FILE_USE_INCLUDE_PATH));
            $mega = 'data:image/' . explode('.',$this->entreprise['logo'])[1]. ';base64,' .base64_encode(file_get_contents($kernel."/public/".$this->entreprise['logo'], FILE_USE_INCLUDE_PATH));

            $client = new Client([
                    'base_uri' => "https://dmnm98.api.infobip.com/",
                    'headers' => [
                        'Authorization' => "App b64549475098ccdf29c8268849ec45c8-37e6ecac-e013-4e86-a7b3-0f5b355b1506",
                        'Content-Type' => 'multipart/form-data',
                        'Accept' => 'application/json',
                    ]
                ]);
                $response = $client->request(
                    'POST',
                    'email/2/send',
                    [
                        RequestOptions::MULTIPART => [
                            ['name' => 'from', 'contents' => $this->senderMail],
                            ['name' => 'to', 'contents' => "komla.adaisso@ism.edu.sn"],
                            ['name' => 'subject', 'contents' => 'Facture N°'.$factureEtudiant->getCode()],
                            [
                                'name' => 'attachment',
                                'Content-type' => 'multipart/form-data',
                                'contents' => $pdf,
                                'filename' => 'Facture N°'.$factureEtudiant->getCode().$filename.'.pdf',
                            ],
                            ['name' => 'html', 'contents' => $this->environment->render('mail/facture.html.twig',
                            [
                                'factureEtudiant'=>$factureEtudiant,
                                "institut"=>$institut,
                                "entreprise"=>$this->entreprise,
                                'logo'=>$logo,
                                "mega"=>$mega
                            ])],
                        ],

                    ]
                );
                Logger::info( "send mail success" );
        }catch(ClientException $e){
            Logger::error( "send mail impossible , verifier votre fournisseur d'envoie de mail " );
        }
    }
    public function ResetPassword(User $contact,Institut $institut,string $kernel)
    {
        try{
            $logo = 'data:image/' . explode('.',$institut->getLogo())[1]. ';base64,' .base64_encode(file_get_contents($kernel."/public/images/instituts/".$institut->getLogo(), FILE_USE_INCLUDE_PATH));
            $mega = 'data:image/' . explode('.',$this->entreprise['logo'])[1]. ';base64,' .base64_encode(file_get_contents($kernel."/public/".$this->entreprise['logo'], FILE_USE_INCLUDE_PATH));

            $client = new Client([
                    'base_uri' => "https://dmnm98.api.infobip.com/",
                    'headers' => [
                        'Authorization' => "App b64549475098ccdf29c8268849ec45c8-37e6ecac-e013-4e86-a7b3-0f5b355b1506",
                        'Content-Type' => 'multipart/form-data',
                        'Accept' => 'application/json',
                    ]
                ]);
                $response = $client->request(
                    'POST',
                    'email/2/send',
                    [
                        RequestOptions::MULTIPART => [
                            ['name' => 'from', 'contents' => $this->senderMail],
                            ['name' => 'to', 'contents' => "komla.adaisso@ism.edu.sn"],
                            ['name' => 'subject', 'contents' => "Réinitialisation de mot de passe"],
                            ['name' => 'html', 'contents' => $this->environment->render('mail/reset.html.twig',
                            [
                                'password'=>base64_decode($contact->getPss()),
                                'contact'=>$contact,
                                "institut"=>$institut,
                                "entreprise"=>$this->entreprise,
                                'logo'=>$logo,
                                "mega"=>$mega
                            ])],
                        ],
                    ]
                );
                Logger::info( "send mail success" );
            }catch(ClientException $e){
                Logger::error( "send mail impossible , verifier votre fournisseur d'envoie de mail " );
            }
    }
}
