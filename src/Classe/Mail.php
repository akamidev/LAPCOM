<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;



class Mail
{


    public function send($to_email, $to_name, $subject, $template,  $vars = null)


    {
        // Récupération du template pour l'envoie de l'email

        $content = file_get_contents(dirname(__DIR__).'/Mail/'.$template);
        //Récupération du variable facultatives

        if ($vars) {
            foreach ($vars as $key => $var) {
                $content = str_replace('{{ '.$key.' }}', $var, $content);
            }
        }
        $mj = new Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "akamimehdi.dev@gmail.com",
                        'Name' => "LAPCOM"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 5939550,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content
                    ]
                ]
            ]
        ];

        $mj->post(Resources::$Email, ['body' => $body]);
    }
}
