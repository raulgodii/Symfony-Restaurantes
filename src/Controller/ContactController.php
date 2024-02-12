<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="handle_contact_form")
     */
    public function handleContactForm(): Response
    {
        // Lógica para manejar el formulario de contacto
        // ...

        return $this->render('contact/form.html.twig');
    }
}
