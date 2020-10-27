<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdminControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testLoadAllContact()
    {
        $this->client->request('GET', '/admin');

        $this->assertEquals(
            Response::HTTP_FOUND,
            $this->client->getResponse()->getStatusCode());
    }

    public function testLoadAllContactActionError()
    {
        $this->client->request('GET', '/adminn');

        $this->assertSame(404, $this->client->getResponse()->getStatusCode());

    }
}