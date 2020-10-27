<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\{FormFactory, FormFactoryInterface};
use Symfony\Component\HttpFoundation\{Request, Response};
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
    public function __construct(EntityManagerInterface $entityManager, FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin", name="admin_interface")
     * @return Response
     */
    public function loadAllContactAction()
    {
        /** @var Contact $contacts */
        $contacts = $this->getDoctrine()->getRepository(Contact::class)->findAll();

        return $this->render('admin/index.html.twig', ['contacts' => $contacts]);

    }

    /**
     * @Route("update/{id}", name="update")
     * @param Request $request
     * @param $id
     */
    public function updateAction(string $id, Request $request)
    {
        /** @var Contact $contact */
        $response = json_decode($request->getContent(),  true);
        $contact  = $this->getDoctrine()->getRepository(Contact::class)->find($id);

        if (empty($contact)) {
            throw new NotFoundHttpException('Contact not found');
        }

        $contact->updateCheck($response['etat']);
        $this->entityManager->flush();

        return new Response('success');
    }
}