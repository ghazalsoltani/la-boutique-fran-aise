<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;
use PhpParser\Node\Scalar\MagicConst\Dir;

class Mail
{
    public function send($to_email, $to_name, $subject, $template, $vars = null)
    {
        //Récuperation du template
        $content = file_get_contents(dirname(__DIR__).'/Mail/'.$template);

        //Récupère les variables facultatives
        if ($vars) {
            foreach ($vars as $key=>$var) {
                $content = str_replace('{'.$key.'}', $var, $content);
            }
        }

        $mj = new Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "marie.johnson2558@gmail.com",
                        'Name' => "La Boutique Française"
                    ],
                    'To' => [
                        [
                            'Email' => "$to_email",
                            'Name' => "$to_name"
                        ]
                    ],
                    'TemplateID' =>7169151,
                    'TemplateLanguage' => true,
                    'Subject' => "$subject",
                    'Variables' => [
                        'content' => $content
                    ]
                ]
            ]
        ];

        $mj->post(Resources::$Email, ['body' => $body]);
    }
}