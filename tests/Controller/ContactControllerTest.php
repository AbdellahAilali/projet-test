<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ContactControllerTest extends WebTestCase
{
    private $client = null;

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

    public function testContact()
    {
        $crawler = $this->client->request('POST', '/contact');
        $form    = $crawler->selectButton('Envoyer')->form();

        $form['contact[name]']      = 'Doe';
        $form['contact[firstname]'] = 'john';
        $form['contact[email]']     = 'johndoe@gmail.com';
        $form['contact[question]']  = 'Voici ma question';

        $this->client->submit($form);

        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
    }

    protected function tearDown()
    {
        parent::tearDown();
        echo'mark1';
        $this->entityManager->close();
        $this->entityManager = null;
    }
}