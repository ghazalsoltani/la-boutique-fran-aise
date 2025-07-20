<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    public function testSomething(): void
    {
        /*
         * 1. Créer un faux client (navigateur) de pointer vers une URL
         * 2. Remplir les champs de mon formulaire d'inscription
         * 3. Est-ce que tu peux regarder si dans ma page j'ai le message (alerts) suivants : Votre compte est correctement créé, veuillez vous connecter.(The addflash message in RegisterController)
         */

        //1.
        $client = static::createClient();
        $client->request('GET', '/inscription');

        //2. (firstname; lastname, email, password, conformation password)
        $client->submitForm('valider', [
            'register_user[email]'=> 'ghazal@exemple.fr',
            'register_user[plainPassword][first]'=> '123456',
            'register_user[plainPassword][second]'=> '123456',
            'register_user[firstname]'=> 'ghazal',
            'register_user[lastname]'=> 'Sol',
        ]);
        //FOLLOW
        $this->assertResponseRedirects('/connexion');
        $client->followRedirect();

        // 3. This method asserts that an element matching the given selector exists in the HTML DOM.
        $this->assertSelectorExists('div:contains("Votre compte est correctement créé, veuillez vous connecter.")');

    }
}
