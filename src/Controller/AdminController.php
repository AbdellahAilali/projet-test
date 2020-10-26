<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
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
     * @var ContactRepository
     */
    public $contactRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param FormFactoryInterface $formFactory
     * @param ContactRepository $contactRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory,
        ContactRepository $contactRepository)
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->contactRepository = $contactRepository;
    }

    /**
     * @Route("/admin", name="admin_interface")
     * @return Response
     */
    public function loadAllUserAction()
    {
        /** @var Contact $contacts */
        $contacts = $this->contactRepository->findAll();

        if (empty($contacts)) {
            throw new NotFoundHttpException('Contacts not found');
        }

        $tabContacts=[];
        foreach ($contacts as $key => $contact) {

            $tabContacts[$key] = [
                "id" => $contact->getId(),
                "name" => $contact->getName(),
                "firstname" => $contact->getFirstname(),
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
    public function updatePublicationAction(string $id, Request $request)
    {
        $response = json_decode($request->getContent(),  true);

        /** @var Contact $contact */
        $contact = $this->contactRepository->find($id);
        $contact->updateCheck($response['etat']);
        $this->entityManager->flush();

        return $this->redirectToRoute("admin_interface");
        
    }
}