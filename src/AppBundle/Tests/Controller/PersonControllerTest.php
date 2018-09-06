<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PersonControllerTest extends WebTestCase
{
    public function testCreatenew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/CreateNew');
    }

    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Add');
    }

    public function testModify()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Modify');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Delete');
    }

    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Show');
    }

    public function testShowall()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ShowAll');
    }

}
