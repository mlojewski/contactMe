<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddressControllerTest extends WebTestCase
{
    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Add');
    }

    public function testCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Create');
    }

    public function testModify()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Modify');
    }

}
