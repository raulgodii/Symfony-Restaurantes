<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DenegarAccesoController extends AbstractController
{
    #[Route('/denegar_acceso', name: 'access_denied_route')]
    public function index(): Response
    {
        return $this->render('acceso/denagado.html.twig');
    }
}