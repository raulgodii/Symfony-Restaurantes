<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestauranteController extends AbstractController
{
    #[Route('/restaurantes/{login}', name: 'app_restaurante', methods: ['GET'])]
    public function index($login): Response
    {
        // Lógica específica de la página del restaurante
        // Puedes agregar lógica para distinguir entre casos de login y registro

        return $this->render('restaurante/index.html.twig', [
            'login' => $login,
        ]);
    }
}
