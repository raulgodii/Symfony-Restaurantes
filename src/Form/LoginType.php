<?php

namespace App\Form;
use App\Entity\Restaurante;
use App\Form\RegistrationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginType extends AbstractType
{
/**
     * @Route("/register", name="user_register")
     */
    public function register(Request $request): Response
    {
        $restaurante = new Restaurante();
        $form = $this->createForm(RegistrationType::class, $restaurante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Manejar la lógica de registro aquí, por ejemplo, guardar el usuario en la base de datos
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($restaurante);
            $entityManager->flush();

            // Redirigir a alguna página después de que el usuario se haya registrado exitosamente
            return $this->redirectToRoute('registration_success');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
