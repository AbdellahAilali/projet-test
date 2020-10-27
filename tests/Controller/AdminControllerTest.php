<?php

namespace App\Tests\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdminControllerTest extends WebTestCase
{
    private $client = null;

    /**
     * @var Contact $contact
     */
    protected static $contact;

    /**
     * @var EntityManagerInterface $em
     */
    protected static $em;

    public function setUp()
    {     //tester html

        self::$contact = new Contact();
        self::$contact->setId('143');
        self::$contact->setName('john');
        self::$contact->setFirstname('Doe');
        self::$contact->setEmail('johndoe@gmail.com');
        self::$contact->setQuestion('J\'ai un problème avec mon ...');
        self::$contact->setIsCheck(false);

        self::$em->persist(self::$contact);
        self::$em->flush();

        $this->client = static::createClient();
    }

    public function testLoadAllContact()
    {
        $this->client->request('GET', '/admin');
        $this->client->loginUser(self::$contact);

        // test e.g. the profile page
        $this->assertResponseIsSuccessful();
        $this->assertEquals(
            Response::HTTP_FOUND,
            $this->client->getResponse()->getStatusCode());
    }


    public static function tearDownAfterClass(): void
    {
        self::$em->remove(self::$contact);
    }
}