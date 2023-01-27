<?php

namespace Tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

    public function testListAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'Insafeaitoumaksa';
        $form['_password'] = 'admin';
        $client->submit($form);
        $crawler = $client->request('GET', '/users');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Liste des utilisateurs")')->count());
    }

    public function testCreateAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'sedite' . uniqid();
        $form['user[password][first]'] = 'admin';
        $form['user[password][second]'] = 'admin';
        $form['user[email]'] = 'testedite' . uniqid() . '@gmail.com';
        $form['user[roles][0]'] = 'ROLE_USER';
        $client->submit($form);

        $client->request('GET', '/users');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testEditAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'Insafeaitoumaksa';
        $form['_password'] = 'admin';
        $client->submit($form);

        $crawler = $client->request('GET', '/users/21/edit');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());


        $this->assertSame(1, $crawler->filter('input[name="user[username]"]')->count());
        $this->assertSame(1, $crawler->filter('input[name="user[password][first]"]')->count());
        $this->assertSame(1, $crawler->filter('input[name="user[password][second]"]')->count());
        $this->assertSame(1, $crawler->filter('input[name="user[email]"]')->count());
        $this->assertSame(2, $crawler->filter('input[name="user[roles][]"]')->count());

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'testedite'.uniqid();
        $form['user[password][first]'] = 'admin';
        $form['user[password][second]'] = 'admin';
        $form['user[email]'] = 'insafe'.uniqid().'@gmail.come';
        $form['user[roles][0]'] = 'ROLE_USER';

        $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testAccessListWithUser()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'Insafeaitoumaksa3';
        $form['_password'] = 'admin';
        $client->submit($form);
        $client->request('GET', '/users');
        self::assertEquals(403, $client->getResponse()->getStatusCode());
    }
}
