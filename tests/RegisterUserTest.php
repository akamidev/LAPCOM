<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    public function testSomething(): void
    {   
        // 1.Créer un faux client navigateur de pointer vers 1 URL, 
        // 2.remplir les champs de mon formulaire d'inscription.
        // 3. Est ce que tu peux regarder si dans ma page j'ai le message alerte suivante : "Votre compte est correctement créé, veuillez vous connecter."
//1.
        $client = static::createClient();
        $client->request('GET', '/inscription');

//2.

$client->submitForm('register_user_submit', [
    'register_user[firstname]' =>'doe',
    'register_user[lastname]' =>'julie',
    'register_user[email]' => 'akami@mehdi.fr',
    'register_user[plainPassword][first]' =>'123456',
    'register_user[plainPassword][second]' =>'123456'

]);
   
//FOLLOW REDIRECT : permet de suivre les redirections

$this->assertResponseRedirects('/connexion');
$client->followRedirect();

 
//3. 

$this->assertSelectorExists('div:contains("Votre compte a bien été créé, veuillez vous connecter.")');

     
    }
}
