<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var FormFactory
     */
    public $formFactory;

    /**
     * @param EntityManagerInterface $entityManager
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin", name="admin_interface")
     * @return Response
     */
    public function loadAllUserAction()
    {
        /** @var Contact   [] $contacts */
        $contacts = $this->entityManager
            ->getRepository(Contact::class)
            ->findAll();

        if (empty($contacts)) {
            throw new NotFoundHttpException('Contacts not found');
        }

        $tabContacts=[];
        foreach ($contacts as $key => $contact) {

            $tabContacts[$key] = [
                "id" => $contact->getId(),
                "name" => $contact->getName(),
                "email" => $contact->getEmail(),
                "question" => $contact->getQuestion(),
                "isCheck" => $contact->isCheck()
            ];
        }

        return $this->render('admin/index.html.twig', ['tabContacts' => $tabContacts]);

    }

    /**
     * @Route("update/{id}", name="update")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function updatePublicationAction($id, Request $request)
    {
        echo $id;
       $response = json_decode($request->getContent(),  true);
        /** @var Contact $contact */
        $contact = $this->entityManager
            ->getRepository(Contact::class)
            ->find($id);

        $contact->updateCheck($response['etat']);

        $this->entityManager->flush();
        return new Response("Success");
        
    }
}