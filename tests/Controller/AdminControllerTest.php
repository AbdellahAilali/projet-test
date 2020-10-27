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

        $this->contact = new Contact();
        $this->contact->setId('999');
        $this->contact->setName('johnny');
        $this->contact->setFirstname('Doeli');
        $this->contact->setEmail('johndoe@gmail.com');
        $this->contact->setQuestion('Je voudrais savoir la taille du colis ?');
        $this->contact->setIsCheck(false);

        $this->entityManager->persist($this->contact);
        $this->entityManager->flush();
    }

    public function testLoadAllContact()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'john@gmail.com',
            'PHP_AUTH_PW'   => 'myPassword',
        ]);

        $crawler = $client->request('GET', '/admin');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('html h1' , 'Interface Administrateur');
        $this->assertSelectorTextContains('html tbody td' , 'johnny');

        $expectedName = $crawler->filter('html tbody td')->eq(1);
        $this->assertSame($expectedName->html() , "Doeli");

        $expectedEmail = $crawler->filter('html tbody td')->eq(2);
        $this->assertSame($expectedEmail->html() , 'johndoe@gmail.com');

        $expectedQuestion= $crawler->filter('html tbody td')->eq(3);
        $this->assertSame($expectedQuestion->html() ,'Je voudrais savoir la taille du colis ?');
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}