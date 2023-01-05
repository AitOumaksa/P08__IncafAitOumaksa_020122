<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function loginUser()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Connexion')->form();
        $this->client->submit($form, ['username' => 'Insafeaitoumaksa', 'password' => '@/Insafe12']);
    }

    public function testListAction()
    {
        $this->loginUser();
        $this->client->request('GET', '/users');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
