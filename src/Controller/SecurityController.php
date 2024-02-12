<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(Request $request): Response
    {
        $form = $this->createForm(UserType::class);

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/registro', name: 'app_registro')]
    public function registro(Request $request): Response
    {
        $form = $this->createForm(UserType::class);

        return $this->render('security/registro.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
