<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\VO\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactFormController extends AbstractController
{
    #[Route('/contact', name: 'contactForm')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $message = new Message($data['name'], $data['lastname'], $data['email'], $data['message']);


        }

        return $this->render('contact_form/index.html.twig', ['form' => $form]);
    }
}
