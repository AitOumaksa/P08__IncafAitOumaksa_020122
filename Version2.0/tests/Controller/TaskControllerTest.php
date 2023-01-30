<?php

namespace Tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    
    public function  testListAction()
    {
        
        $client = $this->createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'Admin10';
        $form['_password'] = 'admin';
        $client->submit($form); 

        $client->request('GET', '/tasks');

        $this->assertEquals(200, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne un 200

    }
    public function testListActionWithoutLogin()
    {
        $client = $this->createClient();
        $client->request('GET', '/tasks');
        $this->assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('input[name="_username"]')->count());
        $this->assertSame(1, $crawler->filter('input[name="_password"]')->count());
    }

    public function testCreateAction()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'Admin10';
        $form['_password'] = 'admin';
        $client->submit($form); 

        $crawler = $client->request('GET', '/tasks/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('input[name="task[title]"]')->count());
        $this->assertSame(1, $crawler->filter('textarea[name="task[content]"]')->count());

        $uniqId = uniqid();
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = "Titre tâche de test : ". $uniqId;
        $form['task[content]'] = 'Ceci est une tâche crée par un test';
        $client->submit($form); 
        $this->assertSame(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

    }
    public function testCreateActionNotLoggeded()
    {
        $client = $this->createClient();
        $client->request('GET', '/tasks/create');

        $this->assertEquals(302, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne une redirection

        $crawler = $client->followRedirect();
        $this->assertSame(2, $crawler->filter('form input#username')->count() + $crawler->filter('form input#password')->count()); //et que celle-ci se fait sur /login
    }

    public function testEditTaskNotLoggedIn()
    {
        $client = static::createClient();
        $client->request('GET', '/tasks/2/edit');

        $this->assertEquals(302, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne une redirection

        $crawler = $client->followRedirect();
        $this->assertSame(2, $crawler->filter('form input#username')->count() + $crawler->filter('form input#password')->count()); 
    }
    public function testEditAction()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'Admin10';
        $form['_password'] = 'admin';
        $client->submit($form);

        $crawler = $client->request('GET', '/tasks/6/edit');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('input[name="task[title]"]')->count());
        $this->assertSame(1, $crawler->filter('textarea[name="task[content]"]')->count());

        $uniqId = uniqid();
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Titre tâche de test modifiée : ' . $uniqId;
        $form['task[content]'] = 'Je modifie une tache';
        $client->submit($form);
        $this->assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testEditActionNotAutorozid()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'sedite63d7c6e8b2f01';
        $form['_password'] = 'admin';
        $client->submit($form);

        $crawler = $client->request('GET', '/tasks/6/edit');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());

    }
    
    
    public function testEditActionNotLoggeded()
    {
        $client = $this->createClient();
        $client->request('GET', '/tasks/6/edit');

        $this->assertEquals(302, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne une redirection

        $crawler = $client->followRedirect();
        $this->assertSame(2, $crawler->filter('form input#username')->count() + $crawler->filter('form input#password')->count()); //et que celle-ci se fait sur /login
    }
    
    public function testToggleTaskAction()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'Admin10';
        $form['_password'] = 'admin';
        $client->submit($form);

        $client->request('GET', '/tasks/6/toggle');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

    }
    public function testToggleTaskNotAuthorized()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'sedite63d7c6e8b2f01';
        $form['_password'] = 'admin';
        $client->submit($form);
        $client->request('GET', '/tasks/6/toggle');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());

        
    }

    public function testDeleteTaskNotLoggedIn()
    {
        $client = static::createClient();
        $client->request('GET', '/tasks/6/delete');

        $this->assertEquals(302, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne une redirection

        $crawler = $client->followRedirect();
        $this->assertSame(2, $crawler->filter('form input#username')->count() + $crawler->filter('form input#password')->count()); //et que celle-ci se fait sur /login
    }

    public function testDeleteAction()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'Admin10';
        $form['_password'] = 'admin';
        $client->submit($form);

        $client->request('GET', '/tasks/4/delete');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testDeleteTaskNotAuthorized()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'sedite63d7c6e8b2f01';
        $form['_password'] = 'admin';
        $client->submit($form);
        $client->request('GET', '/tasks/6/delete');

        $this->assertEquals(403, $client->getResponse()->getStatusCode()); //on s'assure que ça retourne un 403 non autorisé
    }
}