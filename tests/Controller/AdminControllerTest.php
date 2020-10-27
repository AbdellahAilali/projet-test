<?php

namespace App\Tests\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    private $client = null;

    /**
     * @var Contact $contact
     */
    protected $contact;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function setUp()
    {
        $this->client = static::createClient();

        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testLoadAllContact()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'john@gmail.com',
            'PHP_AUTH_PW'   => 'myPassword',
        ]);

        $client->request('GET', '/admin');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('html h1' , 'Interface Administrateur');
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}