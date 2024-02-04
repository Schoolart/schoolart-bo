<?php

namespace App\Service;

use Twilio\Rest\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

class SmsSender{


    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function sendSms($message,$numero){

       $response = $this->client->request('POST', 'https://gateway.intechsms.sn/api/send-sms',[
            "body"=>[
            "app_key"=>$_ENV['INTECH_SMS'],
            "sender"=>"Brazil Burg",
            "content"=>$message,
            "msisdn"=>[
                $numero
            ]
        ],

    ]);
    }
    public function sendTwilio(){
        $auth_token = "a7f90e1b762df3a7a4a61d4b720024c1";
        $account_sid="ACd7c1cc8f1e211afdc5cf474627d3faee";



        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            '+221761445893',
            array(
                'from' => '+221761445893',
                'body' => 'I sent this message in under 10 minutes!'
            )
        );
     }

}