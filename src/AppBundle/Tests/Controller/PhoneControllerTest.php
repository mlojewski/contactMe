<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PhoneControllerTest extends WebTestCase
{
    public function testAdd_phone()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/add_phone');
    }

    public function testCreate_phone()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/create_phone');
    }

    public function testModify_phone()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/modify_phone');
    }

}
