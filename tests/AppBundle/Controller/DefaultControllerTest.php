<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        //$this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(302, $client->getResponse()->getStatusCode()); 
        //$this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
       

       // $crawler = $client->followRedirect();
        $this->assertSame(0, $crawler->filter('html:contains("Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !")')->count());
    }
}
