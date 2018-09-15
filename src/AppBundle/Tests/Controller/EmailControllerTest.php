<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailControllerTest extends WebTestCase
{
    public function testAdd_email()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/add_email');
    }

    public function testCreate_email()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/create_email');
    }

    public function testModify_email()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/modify_email');
    }

}
