<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RestauranteController extends AbstractController
{
    #[Route('/restaurante', name: 'app_restaurante')]
    public function index(): Response
    {
        return $this->render('restaurante/index.html.twig', [
            'controller_name' => 'RestauranteController',
        ]);
    }
}
